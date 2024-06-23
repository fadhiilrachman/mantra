<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class GreetingsTemplate implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Greetings Template', [
            'permission' => 'backend',
            'icon' => 'comment-dots',
            'order' => 3,
        ]);

        $item->add('Create new template', [
            'permission' => 'backend',
            'active' => 'mantra.greetings.create',
            'route' => 'mantra.greetings.create',
        ]);

        $item->add('List template', [
            'permission' => 'backend',
            'active' => 'mantra.greetings.list',
            'route' => 'mantra.greetings.list',
        ]);
    }
}
