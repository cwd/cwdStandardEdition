<?php

/*
 * This file is part of Application.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Web\Controller;

use App\Domain\User\UserManager;
use App\Domain\Model\User;
use App\Infrastructure\Web\Form\UserType;
use App\Infrastructure\Web\Grid\UserGrid;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class UserController.
 *
 *
 * @Route("/user")
 */
class UserController extends AbstractCrudController
{
    /**
     * Set raw option values right before validation. This can be used to chain
     * options in inheritance setups.
     *
     * @return array
     */
    protected function setOptions()
    {
        $options = [
            'entityService' => UserManager::class,
            'entityFormType' => UserType::class,
            'gridService' => UserGrid::class,
            'createRoute' => 'app_infrastructure_web_user_create',
            'redirectRoute' => 'app_infrastructure_web_user_list',
            'icon' => 'fa fa-users',
            'title' => 'user.title',
            'createLabel' => 'user.create',
            'createPermission' => 'user.create',
        ];

        return array_merge(parent::setOptions(), $options);
    }

    /**
     * @param Request $request
     *
     * @Route("/list/data")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return JsonResponse
     */
    public function ajaxDataAction(Request $request)
    {
        $grid = $this->getGrid($request->request->all());
        $data = $grid->getData();

        return new JsonResponse($data);
    }

    /**
     * @Route("/list")
     * @Route("/")
     * @Method({"GET"})
     * @Template("Grid/list.html.twig")
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return array
     */
    public function listAction()
    {
        return parent::listAction();
    }

    /**
     * @Route("/detail/{id}")
     * @Method({"GET"})
     * @Template()
     * @ParamConverter("crudObject", class="Model:User")
     *
     * @param User $crudObject
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return array<string,User>
     */
    public function detailAction(User $crudObject)
    {
        return ['crudObject' => $crudObject];
    }

    /**
     * @Route("/create")
     * @Method({"GET", "POST"})
     *
     * @param Request $request
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return RedirectResponse|Response
     */
    public function createAction(Request $request)
    {
        $object = new User();

        return $this->formHandler($object, $request, true);
    }

    /**
     * Edit action.
     *
     * @ParamConverter("crudObject", class="Model:User")
     * @Route("/edit/{id}")
     * @Method({"GET", "POST", "PUT"})
     *
     * @param User    $crudObject
     * @param Request $request
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return RedirectResponse|Response
     */
    public function editAction(User $crudObject, Request $request)
    {
        return $this->formHandler($crudObject, $request, false);
    }

    /**
     * @Route("/delete/{id}")
     * @ParamConverter("crudObject", class="Model:User")
     * @Method({"GET", "DELETE"})
     *
     * @param User    $crudObject
     * @param Request $request
     *
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @return RedirectResponse|null
     */
    public function deleteAction(User $crudObject, Request $request)
    {
        return $this->deleteHandler($crudObject, $request);
    }
}
