<?php

namespace App\DataTables;

use App\Models\Height;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HeightDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('recorded_at', function ($height) {
                $format = 'Y-m-d H:i';
                if (app()->getLocale() == 'vi')
                    $format = 'd/m/Y H:i';
                elseif (app()->getLocale() == 'ja')
                    $format = 'Y/m/d H:i';
                return $height->recorded_at->format($format);
            })
            ->editColumn('height', function ($height) {
                return $height->height . ' cm';
            })
            ->editColumn('attachment', function ($height) {
                return view('client.pages.height.columns.attachment', compact('height'));
            })
            ->addColumn('action', function ($height) {
                return view('client.pages.height.columns.action', compact('height'));
            })
            ->rawColumns(['attachment', 'action'])
            ->setRowId('id');
    }

    public function query(Height $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', auth()->id())->orderBy('recorded_at', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('heights-table')
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
            Column::make('recorded_at')->title(__('label.recorded_at'))->addClass('text-nowrap')->type('string'),
            Column::make('height')->title(__('label.height'))->addClass('text-nowrap'),
            Column::make('attachment')->title(__('label.attachment'))->addClass('text-nowrap text-center'),
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
        return 'Heights_' . date('YmdHis');
    }
}
