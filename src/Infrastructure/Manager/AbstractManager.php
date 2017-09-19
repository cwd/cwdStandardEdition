<?php

/*
 * This file is part of MailingOwl.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Infrastructure\Manager;

use Cwd\CommonBundle\Service\AbstractBaseService as CwdAbstractBaseService;

/**
 * Base Service class to ease creation of model-specific service classes.
 * If this code proves useful, we should consider moving it into the Generic service.
 */
abstract class AbstractManager extends CwdAbstractBaseService
{

}
