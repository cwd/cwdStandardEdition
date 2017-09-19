<?php

/*
 * This file is part of MailingOwl.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Context;

use Behat\Mink\Driver\BrowserKitDriver;
use Behat\Mink\Exception\ExpectationException;
use Behat\Mink\Exception\UnsupportedDriverActionException;
use Behat\MinkExtension\Context\RawMinkContext;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Infrastructure\Manager\UserManager;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthContext extends RawMinkContext
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var UserManager
     */
    private $userService;

    /**
     * AuthContext constructor.
     *
     * @param TokenStorageInterface $tokenStorage
     * @param UserManager           $userService
     */
    public function __construct(TokenStorageInterface $tokenStorage,UserManager $userService)
    {
        $this->tokenStorage = $tokenStorage;
        $this->userService = $userService;
    }

    /**
     * @Given /^I am authenticated as User "([^"]*)"$/
     *
     * Use this to authenticate a user with the specified username
     *
     * @param string $username
     *
     * @throws UnsupportedDriverActionException
     */
    public function iAmAuthenticatedAsUser($username)
    {
        $driver = $this->getSession()->getDriver();

        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('This step is only supported by the BrowserKitDriver', $driver);
        }

        $client = $driver->getClient();

        $user = $this->fetchUser($username, $client);
        $this->forceSession($user, $client);
    }

    /**
     * Fetch a user from the database using the given username.
     *
     *
     * @param string $username
     * @param Client $client
     *
     * @throws ExpectationException
     *
     * @return UserInterface
     */
    protected function fetchUser($username, Client $client)
    {
        $user = $client->getContainer()->get('fos_user.user_manager')->findUserByUsernameOrEmail($username);

        if (null === $user) {
            $message = 'User with username "'.$username.'" does not exist';

            throw new ExpectationException($message, $this->getSession());
        }

        return $user;
    }

    /**
     * Force a valid session in the virtual browser.
     *
     * @param UserInterface $user
     * @param Client        $client
     */
    protected function forceSession(UserInterface $user, Client $client)
    {
        $client->getCookieJar()->set(new Cookie(session_name(), true));
        $session = $client->getContainer()->get('session');

        $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
        $session->set('_security_main', serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
    }

    /**
     * Check for BrowserKit driver.
     *
     * @throws UnsupportedDriverActionException
     *
     * @return BrowserKitDriver
     */
    protected function getBrowserKitDriver()
    {
        $driver = $this->getSession()->getDriver();

        if (!$driver instanceof BrowserKitDriver) {
            throw new UnsupportedDriverActionException('This step is only supported by the BrowserKitDriver', $driver);
        }

        return $driver;
    }
}
