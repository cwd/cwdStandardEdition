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

namespace App\Infrastructure\Web\EventListener\Menu;

use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;

/**
 * Class AbstractMenuListener.
 */
abstract class AbstractMenuListener
{
    /**
     * @param SidebarMenuEvent $event
     */
    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }
    }

    /**
     * @param string $route
     * @param array  $items
     *
     * @return array<MenuItemModel>
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) { /** @var $item MenuItemModel */
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else {
                if ($item->getRoute() == $route) {
                    $item->setIsActive(true);
                }
            }
        }

        return $items;
    }
}
