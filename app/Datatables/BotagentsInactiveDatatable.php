<?php

namespace App\Datatables;

use App\Models\BotAgents;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class BotagentsInactiveDatatable extends Datatable
{
    public $slug = 'botagents_inactive';

    public function datasource()
    {
        return BotAgents::query()->where('is_active', false);
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

            Column::add(__('Conversation Model'))
                ->data('conversation_model'),

            Column::add(__('Phone Book'))
                ->notOrderable()
                ->data('phoneBooks', function ($book) {
                    return $book->phoneBooks->implode('title', ', ') ?: '-';
                }),

            // Column::add(__('Is Active'))
            //     ->data('is_active'),

            Column::add(__('Created At'))
                ->width('180px')
                ->data('created_at')
                ->fromNow(),

            // Column::add(__('Updated At'))
            //     ->width('180px')
            //     ->data('updated_at')
            //     ->dateFormat(),

            Column::add()
                ->width('20px')
                ->actions(function (BotAgents $botagent) {
                    return join([
                        Button::add('Activate')
                            ->icon('qrcode', 's')
                            ->color('primary')
                            ->route('mantra.botagents.activate', $botagent->uuid)
                            ->make(),
                        // Button::edit('botagents.edit', $botagents),
                        Button::delete('mantra.botagents.destroy', $botagent->uuid),
                    ]);
                }),
        ];
    }
}