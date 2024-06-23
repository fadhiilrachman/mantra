<?php

namespace App\Datatables;

use App\Models\PhoneContacts;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class PhonecontactsDatatable extends Datatable
{
    public $slug = 'phonecontacts';

    public function datasource()
    {
        return PhoneContacts::query()
            ->where('book_id', request()->book_id);
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

            Column::add(__('Number'))
                ->data('number'),

            Column::add(__('Name'))
                ->data('name', function ($contact) {
                    return $contact->name ?: '-';
                }),

            Column::add(__('Phone Book'))
                ->notOrderable()
                ->data('book_id', function ($contact) {
                    return $contact->book->title ?: '-';
                }),

            // Column::add(__('Created At'))
            //     ->width('180px')
            //     ->data('created_at')
            //     ->dateFormat(),

            Column::add()
                ->width('70px')
                ->actions(function (PhoneContacts $phonebook) {
                    return join([
                        // Button::show('phonebook.show', $phonebook->id),
                        // Button::edit('phonebook.edit', $phonebook->id),
                        Button::delete('mantra.phonebook.phonecontact.destroy', $phonebook->uuid),
                    ]);
                }),
        ];
    }
}