<?php

/*
 * This file is part of Application.
 *
 * (c) 2017 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Tests;

use App\Domain\User\UserManager;

trait UserTrait
{
    /**
     * @param null $pid
     *
     * @return User
     */
    protected function getUser($pid = null)
    {
        if (null !== $pid) {
            return $this->container->get(UserManager::class)->find($pid);
        }

        $users = $this->container->get(UserManager::class)->findAllByModel('Model:User', [], [], 1);

        return current($users);
    }

    /**
     * @return User
     */
    protected function getUserByRole($role = 'ROLE_ADMIN')
    {
        /** @var QueryBuilder $x */
        $x = $this->container->get(UserManager::class)->getRepository()->createQueryBuilder('x');
        $x->setMaxResults(1)
            ->andWhere('x.roles LIKE :role')
            ->setParameter('role', '%'.$role.'%');

        $object = $x->getQuery()->getSingleResult();

        return $object;
    }
}
