<?php

/*
 * This file is part of Application.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Domain\User\Exception;

use Cwd\CommonBundle\Exception\AbstractBaseException;

/**
 * Class UserNotFoundException.
 */
class UserNotFoundException extends AbstractBaseException
{
}
