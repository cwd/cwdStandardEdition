<?php

/*
 * This file is part of MailingOwl.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace App\Context;

use App\Domain\User\UserManager;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use FOS\UserBundle\Model\UserManager as FosUserManager;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Domain\Model\User;

class UserContext implements Context
{
    /**
     * @var FosUserManager
     */
    private $userManager;

    /**
     * @var UserManager
     */
    private $userService;

    /**
     * @var EncoderFactoryInterface
     */
    private $encoderFactory;

    public function __construct(UserManager $userManager, FosUserManager $fosUserManager, EncoderFactoryInterface $encoderFactory)
    {
        $this->userService = $userManager;
        $this->userManager = $fosUserManager;
        $this->encoderFactory = $encoderFactory;
    }

    /**
     * @Given /^the following users:$/
     */
    public function theFollowingUsers(TableNode $table)
    {
        $rows = $table->getColumnsHash();

        foreach ($rows as $row) {
            $user = new User();
            $user->setUsername($row['username']);
            $user->setFirstname($row['firstname']);
            $user->setLastname($row['lastname']);
            $user->setEmail(isset($row['email']) ? $row['email'] : $row['name']);
            $user->setEmailCanonical(isset($row['email']) ? $row['email'] : $row['name']);
            $user->setPassword('');
            $user->setEnabled(true);

            if (isset($row['password'])) {
                $user->setPlainPassword($row['password']);
            }

            if (isset($row['roles'])) {
                $roles = array_filter(array_map('trim', explode(',', $row['roles'])));

                foreach ($roles as $role) {
                    $user->addRole(strtoupper($role));
                }
            }

            $this->userManager->updateCanonicalFields($user);
            $this->userManager->updatePassword($user);

            $this->userService->persist($user);
            $this->userService->flush();

            $qb = $this->userService->getRepository()->createQueryBuilder('u');

            $query = $qb->update('Model:User', 'u')
                ->set('u.id', $qb->expr()->literal($row['uuid']))
                ->where('u.username = :username')
                ->andWhere('u.email = :email')
                ->setParameters([
                    'username' => $row['username'],
                    'email'    => $row['email']
                ])
                ->getQuery();

            $query->execute();
        }
    }

    /**
     * @Given /^the password of "([^"]*)" should be "([^"]*)"$/
     */
    public function thePasswordOfShouldBe($label, $password)
    {
        $user = $this->repositories->getByLabel(User::class, $label);
        $encoder = $this->encoderFactory->getEncoder($user);
        $encodedPassword = $encoder->encodePassword($password, $user->getSalt());

        \PHPUnit_Framework_Assert::assertSame($encodedPassword, $user->getPassword());
    }

    /**
     * @Given /^the password recovery token "([^"]*)" for the user "([^"]*)"$/
     */
    public function thePasswordRecoveryTokenForTheUser($token, $label)
    {
        $user = $this->repositories->getByLabel(User::class, $label);
        $user->setConfirmationToken($token);
        $user->setPasswordRequestedAt(new \DateTime());

        $this->repositories->flush(User::class);
    }

    /**
     * @Given /^the expired password recovery token "([^"]*)" for the user "([^"]*)"$/
     */
    public function theExpiredPasswordRecoveryTokenForTheUser($token, $label)
    {
        $user = $this->repositories->getByLabel(User::class, $label);
        $user->setConfirmationToken($token);
        $user->setPasswordRequestedAt(new \DateTime('-1 month'));

        $this->repositories->flush(User::class);
    }

    /**
     * @Given /^the user "([^"]*)" is locked$/
     */
    public function theUserIsLocked($label)
    {
        $user = $this->repositories->getByLabel(User::class, $label);
        $user->setLocked(true);

        $this->repositories->flush(User::class);
    }

    /**
     * @Given /^the label "([^"]*)" for the user ID "([^"]*)"$/
     */
    public function theLabelForTheUserID($label, $id)
    {
        $this->repositories->saveLabel(User::class, $label, UserId::fromString($id));
    }
}
