<?php

/*
 * This file is part of Timetrackign-Bridge.
 * (c) 2017 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Cwd\FosUserExtensionBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class CwdFosUserExtensionBundle.
 */
class CwdFosUserExtensionBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
