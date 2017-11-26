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

namespace App\Domain;

use Cwd\CommonBundle\Manager\AbstractManager as cwdAbstractManager;

/**
 * Base Service class to ease creation of model-specific service classes.
 * If this code proves useful, we should consider moving it into the Generic service.
 */
abstract class AbstractManager extends cwdAbstractManager
{
}
