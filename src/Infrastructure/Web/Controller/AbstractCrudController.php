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

namespace App\Infrastructure\Web\Controller;

use Cwd\CommonBundle\Controller\AbstractCrudController as CwdAbstractCrudController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CrudController.
 */
abstract class AbstractCrudController extends CwdAbstractCrudController
{
    /**
     * Set default options, set required options - whatever is needed.
     * This will be called during first access to any of the object-related methods.
     *
     * @param OptionsResolver $resolver
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'checkModelClass' => null,
            'redirectRoute' => 'dashboard',
            'gridRoute' => null,
            'createRoute' => null,
            'redirectParameter' => [],
            'successMessage' => 'Data successfully saved',
            'formTemplate' => 'Layout/form.html.twig',
            'title' => 'Admin',
            'createLabel' => 'undefined',
            'createPermission' => '',
            'gridOptions' => [
                [
                    'aTargets' => [0],
                    'sWidth' => '40px',
                    'sClass' => 'text-right',
                ],
                [
                    'aTargets' => [-1],
                    'sWidth' => '60px',
                    'sClass' => 'text-center',
                ],
            ],
        ]);

        $resolver->setRequired([
            'entityService',
            'entityFormType',
            'gridService',
            'icon',
        ]);
    }

    /**
     * @Method({"GET"})
     * @Template("Grid:list.html.twig")
     *
     * @return array
     */
    public function listAction()
    {
        return [
            'grid' => $this->getGrid(),
            'icon' => $this->getOption('icon'),
            'title' => $this->getOption('title'),
            'gridRoute' => $this->getOption('gridRoute'),
            'createRoute' => $this->getOption('createRoute'),
            'createLabel' => $this->getOption('createLabel'),
            'createPermission' => $this->getOption('createPermission'),
        ];
    }
}
