<?php

namespace App\DataTables;

use App\Models\UserContest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use App\Models\Contest;

class TemporaryRankingDataTable extends DataTable
{
    private Contest $contest;

    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function query(UserContest $model): QueryBuilder
    {
        return UserContest::query()
            ->with('user')
            ->where('contest_id', $this->contest->id)
            ->whereNotNull('start_time')
            ->whereNotNull('end_time')
            ->orderByRaw('CASE WHEN total_steps >= ? AND status = ? THEN 0 ELSE 1 END ASC', [
                $this->contest->target,
                UserContest::STATUS_COMPLETED,
            ])
            ->orderBy('duration', 'asc')
            ->orderBy('start_time', 'asc');
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user_info', function ($row) {
                return view('admin.pages.contest.columns.user_info', compact('row'))->render();
            })
            ->addColumn('start_at', function ($row) {
                return $row->start_time ? $row->start_time->format('Y-m-d H:i:s') : __('value.not_available');
            })
            ->addColumn('end_at', function ($row) {
                return $row->end_time ? $row->end_time->format('Y-m-d H:i:s') : __('value.not_available');
            })
            ->addColumn('duration', function ($row) {
                if ($row->start_time && $row->end_time) {
                    $seconds = $row->start_time->diffInSeconds($row->end_time);
                    return sprintf('%02d:%02d:%02d', floor($seconds / 3600), floor(($seconds % 3600) / 60), $seconds % 60);
                }
                return __('value.not_available');
            })
            ->editColumn('total_steps', function ($row) {
                return view('admin.pages.contest.columns.total_steps', compact('row'))->render();
            })
            ->rawColumns(['user_info', 'duration', 'total_steps'])
            ->setRowId('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('temporary-ranking-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy([])
            ->parameters([
                'dom' => 'Brtip',
                'paging' => true,
                'info' => true,
                'buttons' => [],
                'language' => [
                    'url' => asset('lang/' . app()->getLocale() . '/datatable.json')
                ],
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('DT_RowIndex')->title(__('label.stt'))->searchable(false)->orderable(false)->width('10%')->addClass('text-center fw-bold text-primary ps-3 text-nowrap'),
            Column::make('user_info')->title(__('label.participants'))->name('user.full_name')->orderable(false)->width('30%')->addClass('text-nowrap'),
            Column::make('start_at')->title(__('label.start_at'))->searchable(false)->orderable(false)->width('15%')->addClass('text-center text-nowrap'),
            Column::make('end_at')->title(__('label.end_at'))->searchable(false)->orderable(false)->width('15%')->addClass('text-center text-nowrap'),
            Column::make('duration')->title(__('label.duration'))->searchable(false)->orderable(false)->width('15%')->addClass('text-center text-nowrap'),
            Column::make('total_steps')->title(__('label.total_steps'))->searchable(false)->orderable(false)->width('15%')->addClass('text-end pe-3 text-nowrap'),
        ];
    }
}
