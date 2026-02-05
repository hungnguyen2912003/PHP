<?php

namespace App\DataTables\Admin;

use App\Models\Height;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HeightsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('user', function ($height) {
                return $height->user->fullname ?? __('value.unknown');
            })
            ->editColumn('recorded_at', function ($height) {
                $format = 'Y-m-d H:i';
                if (app()->getLocale() == 'vi')
                    $format = 'd/m/Y H:i';
                elseif (app()->getLocale() == 'ja')
                    $format = 'Y/m/d H:i';
                return $height->recorded_at->format($format);
            })
            ->editColumn('height', function ($height) {
                return $height->height . ' cm';
            })
            ->editColumn('attachment', function ($height) {
                return view('admin.pages.heights.columns.attachment', compact('height'));
            })
            ->addColumn('action', function ($height) {
                return view('admin.pages.heights.columns.action', compact('height'));
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
                        ->whereColumn('users.id', 'heights.user_id')
                        ->limit(1),
                    $order
                );
            })
            ->rawColumns(['attachment', 'action'])
            ->setRowId('id');
    }

    public function query(Height $model): QueryBuilder
    {
        return $model->newQuery()->with('user')->orderBy('recorded_at', 'desc');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('heights-table')
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
            Column::make('height')->title(__('label.height'))->addClass('text-nowrap'),
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
        return 'Heights_' . date('YmdHis');
    }
}
