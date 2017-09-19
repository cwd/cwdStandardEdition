<?php

/*
 * This file is part of Application.
 * (c) 2016 cwd.at GmbH <office@cwd.at>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Infrastructure\Web\EventListener\Menu;

use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class MainMenuListener.
 */
class MainMenuListener extends AbstractMenuListener
{
    /**
     * @var AuthorizationChecker
     */
    private $authorizationChecker;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * MainMenuListener constructor.
     *
     * @param AuthorizationChecker $authorizationChecker
     * @param TranslatorInterface  $translator
     */
    public function __construct(AuthorizationChecker $authorizationChecker, TranslatorInterface $translator)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->translator = $translator;
    }

    /**
     * @param Request $request
     *
     * @return MenuItemModel[]
     */
    protected function getMenu(Request $request)
    {
        $rootItems = [];

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $rootItems[] = new MenuItemModel(
                'users',
                $this->translator->trans('user.menu_title'),
                'app_infrastructure_web_user_list',
                [],
                'fa fa-users'
            );
        }

        return $this->activateByRoute($request->get('_route'), $rootItems);
    }
}
