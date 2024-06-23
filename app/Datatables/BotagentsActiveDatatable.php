<?php

namespace App\Datatables;

use App\Models\BotAgents;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class BotagentsActiveDatatable extends Datatable
{
    public $slug = 'botagents_active';

    public function datasource()
    {
        return BotAgents::query()->where('is_active', true);
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

            Column::add(__('WhatsApp Number'))
            ->data('whatsapp_number'),

            Column::add(__('Current Status'))
                ->data('current_status'),

            Column::add(__('Conversation Model'))
                ->data('conversation_model'),

            Column::add(__('Phone Book'))
                ->notOrderable()
                ->data('phoneBooks', function ($book) {
                    return $book->phoneBooks->implode('title', ', ') ?: '-';
                }),

            // Column::add(__('Is Active'))
            //     ->data('is_active'),

            // Column::add(__('Created At'))
            //     ->width('180px')
            //     ->data('created_at')
            //     ->fromNow(),

            Column::add(__('Active At'))
                ->width('180px')
                ->data('activated_at')
                ->fromNow(),

            Column::add()
                ->width('20px')
                ->actions(function (BotAgents $botagent) {
                    return join([
                        // Button::show('botagents.show', $botagents),
                        // Button::edit('botagents.edit', $botagents),
                        // Button::delete('botagents.destroy', $botagents),
                        Button::delete('mantra.botagents.inactivate', $botagent->uuid),
                    ]);
                }),
        ];
    }
}