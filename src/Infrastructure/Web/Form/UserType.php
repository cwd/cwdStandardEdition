<?php

/*
 * This file is part of Application.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Web\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserType.
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return FormBuilderInterface
     */
    public function buildForm(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $builder
            ->add('firstname', TextType::class, ['label' => 'user.firstname'])
            ->add('lastname', TextType::class, ['label' => 'user.lastname'])
            ->add('username', TextType::class, ['label' => 'user.username'])
            ->add('email', EmailType::class, ['label' => 'user.email'])
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'label' => 'user.password',
                    'invalid_message' => 'user.password.mustmatch',
                    'first_options' => ['label' => 'user.password'],
                    'second_options' => ['label' => 'user.password_repeat'],
                ]
            );

        return $builder;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'App\Infrastructure\Model\Entity\User',
            ]
        );
    }
}
