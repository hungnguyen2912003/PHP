<?php

namespace App\DataTables;

use App\Models\UserContest;
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

    public function query(UserContest $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('user')
            ->where('contest_id', $this->contestId);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('user_name', function ($row) {
                return $row->user->fullname ?? 'N/A';
            })
            ->editColumn('total_steps', function ($row) {
                return number_format($row->total_steps);
            })
            ->editColumn('joined_at', function ($row) {
                return $row->joined_at ? $row->joined_at->format('Y-m-d H:i') : __('value.not_available');
            })
            ->editColumn('rank', function ($row) {
                return $row->rank ?? __('value.not_available');
            })
            ->editColumn('score', function ($row) {
                return $row->score ? number_format($row->score) : __('value.not_available');
            })
            ->editColumn('completed_at', function ($row) {
                if ($row->completed_at) {
                    return '<span class="badge bg-success bg-opacity-10 text-success px-3">' . __('value.status.completed') . '</span>';
                }
                return '<span class="badge bg-warning bg-opacity-10 text-warning px-3">' . __('value.status.incompleted') . '</span>';
            })
            ->rawColumns(['completed_at'])
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
            Column::make('user_name')->title(__('label.full_name'))->searchable(true)->name('user.fullname')->orderable(false)->addClass('text-nowrap'),
            Column::make('total_steps')->title(__('label.total_steps'))->searchable(false)->orderable(true)->addClass('text-center text-nowrap')->type('number'),
            Column::make('joined_at')->title(__('label.joined_at'))->searchable(false)->orderable(true)->addClass('text-center text-nowrap')->type('datetime-local'),
            Column::make('rank')->title(__('label.rank'))->searchable(false)->orderable(true)->addClass('text-center text-nowrap'),
            Column::make('score')->title(__('label.reward_points'))->searchable(false)->orderable(true)->addClass('text-center text-nowrap'),
            Column::make('completed_at')->title(__('label.status'))->addClass('text-center text-nowrap'),
        ];
    }
}
