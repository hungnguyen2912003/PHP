<?php

namespace App\DataTables;

use App\Models\UserContest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class TemporaryRankingDataTable extends DataTable
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
            ->where('contest_id', $this->contestId)
            ->orderByDesc('total_steps');
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user_info', function ($row) {
                return view('admin.pages.contest.columns.user_info', compact('row'))->render();
            })
            ->editColumn('joined_at', function ($row) {
                return $row->joined_at ? $row->joined_at->format('Y-m-d H:i:s') : __('value.not_available');
            })
            ->editColumn('total_steps', function ($row) {
                return view('admin.pages.contest.columns.total_steps', compact('row'))->render();
            })
            ->rawColumns(['user_info', 'total_steps'])
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
                'dom' => 'Brt',
                'paging' => false,
                'info' => false,
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
            Column::make('joined_at')->title(__('label.joined_at'))->searchable(false)->orderable(false)->width('25%')->addClass('text-center text-nowrap'),
            Column::make('total_steps')->title(__('label.total_steps'))->searchable(false)->orderable(false)->width('35%')->addClass('text-end pe-3 text-nowrap'),
        ];
    }
}
