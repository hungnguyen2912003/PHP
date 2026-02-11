<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminMeasurementDataTable extends DataTable
{
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('role', 'user')
            ->with(['measurements'])
            ->withCount('measurements');
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('fullname', function ($row) {
                return $row->fullname;
            })
            ->editColumn('username', function ($row) {
                return '@' . $row->username;
            })

            ->editColumn('measurements_count', function ($row) {
                return '<span class="badge bg-primary fs-14">' . $row->measurements_count . '</span>';
            })
            ->addColumn('action', 'admin.pages.measurements.columns.user_action')
            ->rawColumns(['bmi', 'measurements_count', 'action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('admin-measurement-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orders([])
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Brt<"d-flex justify-content-between align-items-center p-20"ip>',
                'buttons' => [],
                'language' => [
                    'url' => asset('lang/' . app()->getLocale() . '/datatable.json')
                ],
                'drawCallback' => 'function() {
                            const tooltipTriggerList = document.querySelectorAll("[data-bs-toggle=\"tooltip\"]")
                            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
                        }',
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(__('label.stt'))->searchable(false)->orderable(false)->addClass('text-start text-nowrap'),
            Column::make('fullname')->title(__('label.full_name'))->searchable(true)->addClass('text-nowrap'),
            Column::make('username')->title(__('label.username'))->searchable(true)->addClass('text-nowrap'),
            Column::make('measurements_count')->title(__('label.measurement_record'))->searchable(false)->addClass('text-nowrap text-center')->type('string'),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-end text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Admin_Measurement_' . date('YmdHis');
    }
}
