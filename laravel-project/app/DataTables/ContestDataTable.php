<?php

namespace App\DataTables;

use App\Models\Contest;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ContestDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<Contest> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($row) {
                // Return a badge based on status
                $badges = [
                    'inprogress' => 'bg-warning',
                    'completed' => 'bg-success',
                    'cancelled' => 'bg-danger',
                ];
                $class = $badges[$row->status] ?? 'bg-secondary';
                $translatedStatus = __('value.status.' . $row->status);
                return '<span class="badge ' . $class . '">' . $translatedStatus . '</span>';
            })
            ->editColumn('start_date', function ($row) {
                return $row->start_date ? $row->start_date->format('Y-m-d') : __('value.not_available');
            })
            ->editColumn('end_date', function ($row) {
                return $row->end_date ? $row->end_date->format('Y-m-d') : __('value.not_available');
            })
            ->addColumn('image', function ($row) {
                if ($row->image_url) {
                    return '<img src="' . asset($row->image_url) . '" alt="Image" style="height: 50px; object-fit: cover;" class="rounded">';
                }
                return '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->addColumn('action', function ($row) {
                return view('admin.pages.contest.columns.action', compact('row'))->render();
            })
            ->rawColumns(['status', 'image', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Contest>
     */
    public function query(Contest $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('contests-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->pageLength(10)
                    ->orders([])
                    ->parameters([
                        'dom' => 'Brt<"d-flex justify-content-between align-items-center p-20"ip>',
                        'buttons' => [],
                        'language' => [
                            'url' => asset('lang/' . app()->getLocale() . '/datatable.json'),
                        ],
                        'drawCallback' => 'function() {
                            const tooltipTriggerList = document.querySelectorAll("[data-bs-toggle=\"tooltip\"]")
                            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
                        }',
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title(__('label.contest_name')),
            Column::computed('image')->title(__('label.image'))->searchable(false)->orderable(false)->addClass('text-center align-middle'),
            Column::make('target')->title(__('label.target'))->type('string'),
            Column::make('reward_points')->title(__('label.reward_points'))->type('string'),
            Column::make('win_limit')->title(__('label.win_limit'))->type('string'),
            Column::make('start_date')->title(__('label.start_date'))->type('string'),
            Column::make('end_date')->title(__('label.end_date'))->type('string'),
            Column::make('status')->title(__('label.status')),
            Column::make('created_at')->title(__('label.created_at'))->visible(false),
            Column::computed('action')
                  ->title(__('label.action'))
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Contest_' . date('YmdHis');
    }
}
