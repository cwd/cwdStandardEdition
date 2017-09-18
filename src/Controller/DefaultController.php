<?php
/**
 * Created by PhpStorm.
 * User: ludwig
 * Date: 18.09.17
 * Time: 17:00
 */

namespace App\Controller;

use Cwd\CommonBundle\Controller\AbstractBaseController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractBaseController
{
    /**
     * @Route("/")
     */
    public function defaultAction()
    {
        return $this->render("Default/index.html.twig");
    }
}