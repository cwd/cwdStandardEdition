<?php

/*
 * This file is part of Exceet Carrier Text Verwaltung
 *
 * (c) 2017 cwd.at GmbH <office@cwd.at>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Web\Grid;

use App\Domain\User\User;
use Cwd\FancyGridBundle\Column\ActionType;
use Cwd\FancyGridBundle\Column\DateType;
use Cwd\FancyGridBundle\Column\NumberType;
use Cwd\FancyGridBundle\Column\TextType;
use Cwd\FancyGridBundle\Grid\AbstractGrid;
use Cwd\FancyGridBundle\Grid\GridBuilderInterface;
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
        $builder->add(new NumberType('id', 'u.id', ['label' => 'generic.id', 'identifier' => true, 'flex' => 1]))
                ->add(new TextType('username', 'u.username', ['label' => 'user.username', 'flex' => 4]))
                ->add(new TextType('firstname', 'u.firstname', ['label' => 'user.firstname', 'flex' => 2]))
                ->add(new TextType('lastname', 'u.lastname', ['label' => 'user.lastname', 'flex' => 3]))
                ->add(new TextType('email', 'u.email', ['label' => 'user.email', 'flex' => 2]))
                ->add(new DateType(
                    'createdAt',
                    'u.createdAt',
                    [
                        'label' => 'generic.created',
                    ]
                ))
                ->add(new DateType(
                    'updatedAt',
                    'u.updatedAt',
                    [
                        'label' => 'generic.updated',
                    ]
                ))
                ->add(new ActionType(
                    'actions',
                    'u.id',
                    [
                        'label' => '',
                        'minWidth' => 100,
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
            ->getRepository(User::class)
            ->createQueryBuilder('u')
            ->addOrderBy('u.lastname', 'ASC');

        return $queryBuilder;
    }
}
