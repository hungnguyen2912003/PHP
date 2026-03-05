<?php

namespace App\DataTables;

use App\Models\Contest;
use App\Models\ContestDetail;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class FinalRankingDataTable extends DataTable
{
    private Contest $contest;
    private int $rankCounter = 0;

    public function __construct(Contest $contest)
    {
        $this->contest = $contest;
    }

    public function query(ContestDetail $model): QueryBuilder
    {
        if ($this->contest->status !== Contest::STATUS_COMPLETED) {
            return $model->newQuery()->where('contest_id', $this->contest->id)->whereRaw('1 = 0');
        }

        return $this->contest->getRankedWinners();
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
            ->editColumn('final_steps', function ($row) {
                return view('admin.pages.contest.columns.total_steps', compact('row'))->render();
            })
            ->addColumn('reward_points', function () {
                return $this->contest->calculateReward(++$this->rankCounter);
            })
            ->rawColumns(['user_info', 'final_steps'])
            ->setRowId('id');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('final-ranking-table')
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
            Column::make('DT_RowIndex')->title(__('label.stt'))->searchable(false)->orderable(false)->width('10%')->addClass('text-center fw-bold text-success ps-3'),
            Column::make('user_info')->title(__('label.participants'))->name('user.full_name')->orderable(false)->width('30%'),
            Column::make('joined_at')->title(__('label.joined_at'))->searchable(false)->orderable(false)->width('20%')->addClass('text-center text-nowrap'),
            Column::make('final_steps')->title(__('label.total_steps'))->searchable(false)->orderable(false)->width('25%')->addClass('text-end text-nowrap'),
            Column::make('reward_points')->title(__('label.reward_points'))->searchable(false)->orderable(false)->width('15%')->addClass('text-end pe-3 text-nowrap'),
        ];
    }
}
