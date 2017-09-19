<?php

/*
 * This file is part of Application.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Web\EventListener\User;

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Avanzu\AdminThemeBundle\Model\UserModel;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class ShowUserListener.
 */
class ShowUserListener
{
    /**
     * @var UserInterface
     */
    protected $loginUser;

    /**
     * ShowUserListener constructor.
     *
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        if ($tokenStorage->getToken() !== null) {
            $this->loginUser = $tokenStorage->getToken()->getUser();
        }
    }

    /**
     * @param ShowUserEvent $event
     */
    public function onShowUser(ShowUserEvent $event)
    {
        if (!$this->loginUser instanceof UserInterface) {
            return;
        }

        $name = $this->loginUser->getFirstname().' '.$this->loginUser->getLastname();
        $event->setUser(
            new UserModel(
                $this->loginUser->getUsername(),
                $this->getGravatar(),
                $this->loginUser->getCreatedAt(),
                true,
                $name,
                $this->getUserType()
            )
        );
    }

    /**
     * @return string
     */
    private function getUserType()
    {
        $roles = $this->loginUser->getRoles();

        if (in_array('ROLE_SUPER_ADMIN', $roles)) {
            return 'Superadmin';
        } elseif (in_array('ROLE_ADMIN', $roles)) {
            return 'Admin';
        } elseif (in_array('ROLE_CLIENT', $roles)) {
            return 'Client';
        }

        return 'User';
    }

    /**
     * @return string
     */
    private function getGravatar()
    {
        if (!$this->loginUser instanceof UserInterface) {
            return '';
        }

        $url = 'https://www.gravatar.com/avatar/';

        return $url.strtolower(md5($this->loginUser->getEmail()));
    }
}
