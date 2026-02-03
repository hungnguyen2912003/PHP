<?php

namespace App\DataTables;

use App\Models\Weight;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WeightDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('recorded_at', function ($weight) {
                $format = 'Y-m-d H:i:s';
                if (app()->getLocale() == 'vi')
                    $format = 'd/m/Y H:i:s';
                elseif (app()->getLocale() == 'ja')
                    $format = 'Y/m/d H:i:s';
                return $weight->recorded_at->format($format);
            })
            ->editColumn('weight', function ($weight) {
                return $weight->weight . ' kg';
            })
            ->editColumn('attachment', function ($weight) {
                return view('client.pages.weight.columns.attachment', compact('weight'));
            })
            ->addColumn('action', function ($weight) {
                return view('client.pages.weight.columns.action', compact('weight'));
            })
            ->rawColumns(['attachment', 'action'])
            ->setRowId('id');
    }

    public function query(Weight $model): QueryBuilder
    {
        return $model->newQuery()->where('user_id', auth()->id())->orderBy('recorded_at', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('weights-table')
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
            Column::make('recorded_at')->title(__('label.recorded_at'))->addClass('text-nowrap'),
            Column::make('weight')->title(__('label.weight'))->addClass('text-nowrap'),
            Column::make('attachment')->title(__('label.attachment'))->addClass('text-nowrap'),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Weights_' . date('YmdHis');
    }
}
