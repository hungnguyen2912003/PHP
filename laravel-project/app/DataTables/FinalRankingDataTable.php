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
        $query = $model->newQuery()
            ->with('user')
            ->where('contest_id', $this->contest->id);

        // Only show final rank data after contest is finalized
        if ($this->contest->status !== Contest::STATUS_COMPLETED) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where('total_steps', '>=', $this->contest->target)
            ->orderByRaw('TIMESTAMPDIFF(SECOND, start_at, end_at) ASC')
            ->orderBy('start_at', 'asc')
            ->limit($this->contest->win_limit);
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $rewardPoints = $this->contest->reward_points;

        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->addColumn('user_info', function ($row) {
                return view('admin.pages.contest.columns.user_info', compact('row'))->render();
            })
            ->editColumn('start_at', function ($row) {
                return $row->start_at ? $row->start_at->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('end_at', function ($row) {
                return $row->end_at ? $row->end_at->format('Y-m-d H:i:s') : '-';
            })
            ->editColumn('total_steps', function ($row) {
                return view('admin.pages.contest.columns.total_steps', compact('row'))->render();
            })
            ->addColumn('duration', function ($row) {
                if (!$row->start_at || !$row->end_at) return '-';
                $seconds = abs($row->start_at->diffInSeconds($row->end_at));
                $h = intdiv($seconds, 3600);
                $m = intdiv($seconds % 3600, 60);
                $s = $seconds % 60;
                return sprintf('%02d:%02d:%02d', $h, $m, $s);
            })
            ->addColumn('reward_points', function () use ($rewardPoints) {
                return $this->calculateReward(++$this->rankCounter, $rewardPoints);
            })
            ->rawColumns(['user_info', 'total_steps'])
            ->setRowId('id');
    }

    /**
     * Calculate reward points based on rank position.
     * Top 1: 100%, Top 2: 80%, Top 3: 70%, Top 4+: 60%
     */
    private function calculateReward(int $rank, int $rewardPoints): int
    {
        return match (true) {
            $rank === 1 => $rewardPoints,
            $rank === 2 => (int) round($rewardPoints * 0.8),
            $rank === 3 => (int) round($rewardPoints * 0.7),
            default => (int) round($rewardPoints * 0.6),
        };
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
            Column::make('DT_RowIndex')->title(__('label.stt'))->searchable(false)->orderable(false)->width('8%')->addClass('text-center fw-bold text-success ps-3'),
            Column::make('user_info')->title(__('label.participants'))->name('user.full_name')->orderable(false)->width('25%'),
            Column::make('start_at')->title(__('label.start_at'))->searchable(false)->orderable(false)->width('17%')->addClass('text-center text-nowrap'),
            Column::make('end_at')->title(__('label.end_at'))->searchable(false)->orderable(false)->width('17%')->addClass('text-center text-nowrap'),
            Column::make('duration')->title(__('label.duration'))->searchable(false)->orderable(false)->width('13%')->addClass('text-center text-nowrap'),
            Column::make('total_steps')->title(__('label.total_steps'))->searchable(false)->orderable(false)->width('15%')->addClass('text-end text-nowrap'),
            Column::make('reward_points')->title(__('label.reward_points'))->searchable(false)->orderable(false)->width('12%')->addClass('text-end pe-3 text-nowrap'),
        ];
    }
}
