<?php

namespace App\DataTables\Admin;

use App\Models\Weight;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class WeightsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('user', function ($weight) {
                return $weight->user->fullname ?? __('value.unknown');
            })
            ->editColumn('recorded_at', function ($weight) {
                if (!$weight->recorded_at)
                    return '<span class="text-warning">' . __('value.not_available') . '</span>';
                $format = 'Y-m-d H:i';
                if (app()->getLocale() == 'vi')
                    $format = 'd/m/Y H:i';
                elseif (app()->getLocale() == 'ja')
                    $format = 'Y/m/d H:i';
                return $weight->recorded_at->format($format);
            })
            ->editColumn('weight', function ($weight) {
                return $weight->weight . ' kg';
            })
            ->editColumn('attachment', function ($weight) {
                return view('admin.pages.weights.columns.attachment', compact('weight'));
            })
            ->addColumn('action', function ($weight) {
                return view('admin.pages.weights.columns.action', compact('weight'));
            })
            ->filterColumn('user', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('fullname', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('recorded_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(recorded_at, '%d/%m/%Y %H:%i') like ?", ["%{$keyword}%"])
                    ->orWhereRaw("DATE_FORMAT(recorded_at, '%Y/%m/%d %H:%i') like ?", ["%{$keyword}%"])
                    ->orWhereRaw("DATE_FORMAT(recorded_at, '%Y-%m-%d %H:%i') like ?", ["%{$keyword}%"]);
            })
            ->orderColumn('user', function ($query, $order) {
                $query->orderBy(
                    \App\Models\User::select('fullname')
                        ->whereColumn('users.id', 'weights.user_id')
                        ->limit(1),
                    $order
                );
            })
            ->rawColumns(['recorded_at', 'weight', 'attachment', 'action'])
            ->setRowId('id');
    }

    public function query(Weight $model): QueryBuilder
    {
        return $model->newQuery()->with('user')->orderBy('recorded_at', 'desc');
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
            Column::make('user')->title(__('label.full_name'))->addClass('text-nowrap'),
            Column::make('recorded_at')->title(__('label.recorded_at'))->addClass('text-nowrap')->type('string'),
            Column::make('weight')->title(__('label.weight'))->addClass('text-nowrap'),
            Column::computed('attachment')->title(__('label.attachment'))->addClass('text-nowrap text-center')->searchable(false)->orderable(false),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->searchable(false)
                ->orderable(false)
                ->width(100)
                ->addClass('text-end text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Weights_' . date('YmdHis');
    }
}
