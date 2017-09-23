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

namespace App\Infrastructure\Web\Grid;

use Cwd\BootgridBundle\Column\ActionType;
use Cwd\BootgridBundle\Column\DateType;
use Cwd\BootgridBundle\Column\NumberType;
use Cwd\BootgridBundle\Column\TextType;
use Cwd\BootgridBundle\Grid\AbstractGrid;
use Cwd\BootgridBundle\Grid\GridBuilderInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType.
 */
class UserGrid extends AbstractGrid
{
    /**
     * @param GridBuilderInterface $builder
     * @param array                $options
     */
    public function buildGrid(GridBuilderInterface $builder, array $options)
    {
        $builder->add(new NumberType('id', 'u.id', ['label' => 'generic.id', 'identifier' => true, 'visible' => false]))
                ->add(new TextType('username', 'u.username', ['label' => 'user.username']))
                ->add(new TextType('firstname', 'u.firstname', ['label' => 'user.firstname']))
                ->add(new TextType('lastname', 'u.lastname', ['label' => 'user.lastname']))
                ->add(new TextType('email', 'u.email', ['label' => 'user.email']))
                ->add(new DateType(
                    'createdAt',
                    'u.createdAt',
                    [
                        'label' => 'generic.created',
                        'format' => 'd.m.Y H:i:s',
                    ]
                ))
                ->add(new DateType(
                    'updatedAt',
                    'u.updatedAt',
                    [
                        'label' => 'generic.updated',
                        'visible' => false,
                        'format' => 'd.m.Y H:i:s',
                    ]
                ))
                ->add(new ActionType(
                    'actions',
                    'u.id',
                    [
                        'label' => '',
                        'actions' => [
                            [
                                'route' => 'app_infrastructure_web_user_edit',
                                'class' => 'btn-primary',
                                'icon' => 'fa-edit',
                                'title' => 'generic.edit',
                            ],
                            [
                                'route' => 'app_infrastructure_web_user_delete',
                                'class' => 'btn-danger deleterow',
                                'icon' => 'fa-trash-o',
                                'title' => 'generic.delete',
                            ],
                        ],
                    ]
                ));
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver->setDefaults([
            'data_route' => 'app_infrastructure_web_user_ajaxdata',
            'client' => null,
        ]);
    }

    /**
     * @param ObjectManager $objectManager
     * @param array         $params
     *
     * @return QueryBuilder
     */
    public function getQueryBuilder(ObjectManager $objectManager, array $params = []): QueryBuilder
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $objectManager
            ->getRepository('Model:User')
            ->createQueryBuilder('u')
            ->addOrderBy('u.lastname', 'ASC');

        return $queryBuilder;
    }
}
