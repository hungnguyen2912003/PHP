<?php

namespace App\DataTables;

use App\Models\ContestDetail;
use App\Models\Contest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ContestDetailDataTable extends DataTable
{
    private string $contestId;

    public function __construct(string $contestId)
    {
        $this->contestId = $contestId;
    }

    public function query(ContestDetail $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('user')
            ->where('contest_id', $this->contestId);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_name', function ($row) {
                return $row->user->full_name ?? 'N/A';
            })
            ->editColumn('total_steps', function ($row) {
                return number_format($row->total_steps);
            })
            ->editColumn('start_at', function ($row) {
                return $row->start_at ? $row->start_at->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('end_at', function ($row) {
                return $row->end_at ? $row->end_at->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('device_type', function ($row) {
                return $row->device_type ?? '-';
            })
            ->editColumn('status', function ($row) {
                $statusData = match($row->status) {
                    \App\Models\ContestDetail::STATUS_COMPLETED => ['class' => 'bg-success', 'label' => __('value.status.completed')],
                    \App\Models\ContestDetail::STATUS_CANCELLED => ['class' => 'bg-danger', 'label' => __('value.status.cancelled')],
                    default => ['class' => 'bg-warning', 'label' => __('value.status.incompleted')],
                };
                return '<span class="badge ' . $statusData['class'] . ' bg-opacity-10 text-' . str_replace('bg-', '', $statusData['class']) . ' px-3">' . $statusData['label'] . '</span>';
            })
            ->rawColumns(['status'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('contest-detail-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy([])
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Brt<"d-flex justify-content-between align-items-center p-20"ip>',
                'buttons' => [],
                'language' => [
                    'url' => asset('lang/' . app()->getLocale() . '/datatable.json')
                ],
                'scrollX' => true,
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(__('label.stt'))->searchable(false)->orderable(false)->addClass('text-start text-nowrap'),
            Column::make('user_name')->title(__('label.full_name'))->searchable(true)->name('user.full_name')->orderable(false),
            Column::make('total_steps')->title(__('label.total_steps'))->searchable(false)->orderable(true)->addClass('text-center'),
            Column::make('start_at')->title(__('label.start_at'))->searchable(false)->orderable(true)->addClass('text-center'),
            Column::make('end_at')->title(__('label.end_at'))->searchable(false)->orderable(true)->addClass('text-center'),
            Column::make('device_type')->title(__('label.device_type'))->searchable(false)->orderable(true)->addClass('text-center'),
            Column::make('status')->title(__('label.status'))->addClass('text-center'),
        ];
    }
}
