<?php

namespace App\Menu;

use Sebastienheyd\Boilerplate\Menu\Builder;
use Sebastienheyd\Boilerplate\Menu\MenuItemInterface;

class PhoneBook implements MenuItemInterface
{
    public function make(Builder $menu)
    {
        $item = $menu->add('Phone Book', [
            'permission' => 'backend_access',
            'icon' => 'phone-square',
            'order' => 2,
        ]);

        $item->add('Upload new book', [
            'permission' => 'backend_access',
            'active' => 'mantra.phonebook.upload',
            'route' => 'mantra.phonebook.upload',
        ]);

        $item->add('List book', [
            'permission' => 'backend_access',
            'active' => 'mantra.phonebook.list',
            'route' => 'mantra.phonebook.list',
        ]);
    }
}
