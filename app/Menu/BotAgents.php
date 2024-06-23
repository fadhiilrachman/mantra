<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class BotAgents implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Bot Agents', [
            'permission' => 'backend_access',
            'icon' => 'robot',
            'order' => 1,
        ]);

        $item->add('Register new agent', [
            'permission' => 'backend_access',
            'active' => 'mantra.botagents.register',
            'route' => 'mantra.botagents.register',
        ]);

        $item->add('Active agents', [
            'permission' => 'backend_access',
            'active' => 'mantra.botagents.active',
            'route' => 'mantra.botagents.active',
        ]);

        $item->add('Inactive agents', [
            'permission' => 'backend_access',
            'active' => 'mantra.botagents.inactive',
            'route' => 'mantra.botagents.inactive',
        ]);

        $item->add('Logs', [
            'permission' => 'backend_access',
            'active' => 'mantra.botagents.logs',
            'route' => 'mantra.botagents.logs',
        ]);
    }
}
