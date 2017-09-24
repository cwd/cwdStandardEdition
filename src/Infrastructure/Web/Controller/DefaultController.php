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

/**
 * Created by PhpStorm.
 * User: ludwig
 * Date: 18.09.17
 * Time: 17:00.
 */

namespace App\Infrastructure\Web\Controller;

use Cwd\CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractBaseController
{
    /**
     * @Route("/")
     */
    public function defaultAction()
    {
        return $this->render('Default/index.html.twig');
    }
}
