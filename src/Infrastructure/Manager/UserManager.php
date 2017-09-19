<?php

/*
 * This file is part of MailingOwl.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Manager;

use Doctrine\Common\Persistence\ManagerRegistry;
use App\Infrastructure\Model\Entity\User as Entity;
use App\Infrastructure\Model\Repository\UserRepository as EntityRepository;
use Psr\Log\LoggerInterface;

/**
 * Class MailingOwlAdminBundle Service Contract.
 *
 *
 * @method Entity getNew()
 * @method Entity find($pid)
 * @method EntityRepository getRepository()
 * @method NotFoundException createNotFoundException($message = null, $code = null, $previous = null)
 */
class UserManager extends AbstractManager
{
    /**
     * @param ManagerRegistry $managerRegistry
     * @param LoggerInterface $logger
     */
    public function __construct(ManagerRegistry $managerRegistry, LoggerInterface $logger)
    {
        parent::__construct($managerRegistry, $logger);
    }

    /**
     * Set raw option values right before validation. This can be used to chain
     * options in inheritance setups.
     *
     * @return array<string,string>
     */
    protected function setServiceOptions()
    {
        return [
            'modelName' => 'Model:User',
            'notFoundExceptionClass' => 'App\Infrastructure\Manager\Exception\UserNotFoundException',
        ];
    }
}
