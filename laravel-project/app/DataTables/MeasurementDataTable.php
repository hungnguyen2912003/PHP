<?php

namespace App\DataTables;

use App\Models\Measurement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class MeasurementDataTable extends DataTable
{
    public function query(Measurement $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('user_id', auth()->id())
            ->when($this->request->get('from_date'), function ($query, $fromDate) {
                return $query->whereDate('recorded_at', '>=', $fromDate);
            })
            ->when($this->request->get('to_date'), function ($query, $toDate) {
                return $query->whereDate('recorded_at', '<=', $toDate);
            })
            ->orderBy('recorded_at', 'desc');
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('recorded_at', function ($row) {
                return \Carbon\Carbon::parse($row->recorded_at)->format('d/m/Y H:i');
            })
            ->editColumn('weight', function ($row) {
                if ($row->weight) {
                    return $row->weight;
                }
                return '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->editColumn('height', function ($row) {
                if ($row->height) {
                    return $row->height;
                }
                return '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->editColumn('attachment', function ($row) {
                if ($row->attachment_url) {
                    return '<a href="' . asset($row->attachment_url) . '" target="_blank" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="' . __('label.view_attachment') . '"><i class="ri-attachment-line"></i></a>';
                }
                return '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->addColumn('action', 'client.pages.measurement.columns.action')
            ->rawColumns(['weight', 'height', 'attachment', 'action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('measurement-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', null, [
                'from_date' => '$("#fromDate").val()',
                'to_date' => '$("#toDate").val()',
            ])
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
            Column::make('weight')->title(__('label.weight') . ' ' . '(kg)')->addClass('text-nowrap')->type('string'),
            Column::make('height')->title(__('label.height') . ' ' . '(cm)')->addClass('text-nowrap')->type('string'),
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
        return 'Measurement_' . date('YmdHis');
    }
}