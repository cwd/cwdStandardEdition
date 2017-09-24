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

use Cwd\CommonBundle\Tests\AbstractBaseServiceTestCase;

/**
 * Class MailingOwl\BaseService.
 */
abstract class AbstractManagerTestCase extends AbstractBaseServiceTestCase
{
    use UserTrait;

    public function setUp()
    {
        parent::setUp();
        $this->loadFixturesFromDirectory(__DIR__.'/DataFixtures');
    }
}
