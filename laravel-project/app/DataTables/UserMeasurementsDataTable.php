<?php

namespace App\DataTables;

use App\Models\Measurement;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserMeasurementsDataTable extends DataTable
{
    protected string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function query(Measurement $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('user_id', $this->userId)
            ->when($this->request->get('from_date'), function ($query, $fromDate) {
                return $query->whereDate('recorded_at', '>=', $fromDate);
            })
            ->when($this->request->get('to_date'), function ($query, $toDate) {
                return $query->whereDate('recorded_at', '<=', $toDate);
            })
            ->when(!$this->request->get('order'), function ($query) {
                $query->orderBy('recorded_at', 'desc');
            });
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('recorded_at', function ($row) {
                return \Carbon\Carbon::parse($row->recorded_at)->format('d/m/Y H:i');
            })
            ->editColumn('height', function ($row) {
                return $row->height ? $row->height : '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->editColumn('bmi', function ($row) {
                return $row->bmi ? $row->bmi : '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->editColumn('body_fat', function ($row) {
                return $row->body_fat ? $row->body_fat : '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->editColumn('fat_free_body_weight', function ($row) {
                return $row->fat_free_body_weight ? $row->fat_free_body_weight : '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->editColumn('attachment', function ($row) {
                if ($row->attachment_url) {
                    return '<img src="' . asset($row->attachment_url) . '" alt="Attachment" class="img-thumbnail" style="height: 50px;">';
                }
                return '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->addColumn('action', 'admin.pages.measurements.columns.action')
            ->rawColumns(['height', 'bmi', 'body_fat', 'fat_free_body_weight', 'attachment', 'action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-measurement-table')
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
            Column::make('bmi')->title(__('label.bmi'))->addClass('text-nowrap')->type('string'),
            Column::make('body_fat')->title(__('label.body_fat'))->addClass('text-nowrap')->type('string'),
            Column::make('fat_free_body_weight')->title(__('label.fat_free_body_weight'))->addClass('text-nowrap')->type('string'),
            Column::make('attachment')->title(__('label.attachment'))->addClass('text-nowrap text-center')->orderable(false),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-end text-nowrap'),
        ];
    }
}
