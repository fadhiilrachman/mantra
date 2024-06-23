<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class Reports implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Reports', [
            'permission' => 'backend_access',
            'icon' => 'book',
            'order' => 4,
        ]);

        $item->add('Active numbers', [
            'permission' => 'backend_access',
            'active' => 'mantra.reports.activenumbers',
            'route' => 'mantra.reports.activenumbers',
        ]);
    }
}
