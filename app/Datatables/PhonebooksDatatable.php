<?php

namespace App\Datatables;

use App\Models\PhoneBooks;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class PhonebooksDatatable extends Datatable
{
    public $slug = 'phonebooks';

    public function datasource()
    {
        return PhoneBooks::query()->select('uuid', 'title', 'created_at');
    }

    public function setUp()
    {
        $this->order('id', 'desc');
    }

    public function columns(): array
    {
        return [
            // Column::add(__('Id'))
            //     ->data('id'),

            Column::add(__('Title'))
                ->data('title'),

            Column::add(__('Created At'))
                ->width('180px')
                ->data('created_at')
                ->fromNow(),

            Column::add()
                ->width('70px')
                ->actions(function (PhoneBooks $phonebook) {
                    return join([
                        Button::show('mantra.phonebook.phonecontact.list', $phonebook->uuid),
                        // Button::edit('phonebook.edit', $phonebook->id),
                        Button::delete('mantra.phonebook.destroy', $phonebook->uuid),
                    ]);
                }),
        ];
    }
}