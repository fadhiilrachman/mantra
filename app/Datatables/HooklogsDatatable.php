<?php

namespace App\Datatables;

use App\Models\HookLogs;
use Sebastienheyd\Boilerplate\Datatables\Button;
use Sebastienheyd\Boilerplate\Datatables\Column;
use Sebastienheyd\Boilerplate\Datatables\Datatable;

class HooklogsDatatable extends Datatable
{
    public $slug = 'hooklogs';

    public function datasource()
    {
        return HookLogs::query()->select('uuid', 'session_id', 'type', 'created_at');
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

            Column::add(__('Session Id'))
                ->data('session_id'),

            Column::add(__('Type'))
                ->data('type'),

            Column::add(__('Created At'))
                ->width('180px')
                ->data('created_at')
                ->dateFormat(),

            Column::add()
                ->width('70px')
                ->actions(function (HookLogs $hooklog) {
                    return join([
                        Button::show('mantra.botagents.logs.detail', $hooklog->uuid),
                    ]);
                }),
        ];
    }
}