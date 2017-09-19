<?php

/*
 * This file is part of MailingOwl.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cwd\ThemeBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class MailingOwlThemeBundle.
 */
class CwdThemeBundle extends Bundle
{
    /**
     * @return string
     */
    public function getParent()
    {
        return 'AvanzuAdminThemeBundle';
    }
}
