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
            ->editColumn('name', function ($row) {
                return $row->name; // Spatie Translatable handles the automatic casting to the current locale
            })
            ->editColumn('status', function ($row) {
                // Return a badge based on status
                $badges = [
                    \App\Models\Contest::STATUS_INPROGRESS => 'bg-warning',
                    \App\Models\Contest::STATUS_COMPLETED => 'bg-success',
                    \App\Models\Contest::STATUS_CANCELLED => 'bg-danger',
                ];
                $class = $badges[$row->status] ?? 'bg-secondary';
                $statusKey = match($row->status) {
                    \App\Models\Contest::STATUS_INPROGRESS => 'inprogress',
                    \App\Models\Contest::STATUS_COMPLETED => 'completed',
                    \App\Models\Contest::STATUS_CANCELLED => 'cancelled',
                    default => 'unknown',
                };
                $translatedStatus = __('value.status.' . $statusKey);
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
            ->editColumn('win_limit', function ($row) {
                return $row->completed_details_count . '/' . $row->win_limit;
            })
            ->addColumn('action', function ($row) {
                return view('admin.pages.contest.columns.action', compact('row'))->render();
            })
            ->rawColumns(['status', 'image', 'action', 'win_limit'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<Contest>
     */
    public function query(Contest $model): QueryBuilder
    {
        return $model->newQuery()
            ->withCount('details')
            ->withCount(['details as completed_details_count' => function ($query) {
                $query->where('status', \App\Models\ContestDetail::STATUS_COMPLETED);
            }])
            ->when($this->request->get('from_date'), function ($query, $fromDate) {
                return $query->whereDate('start_date', '>=', $fromDate);
            })
            ->when($this->request->get('to_date'), function ($query, $toDate) {
                return $query->whereDate('start_date', '<=', $toDate);
            });
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('contests-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax('', null, [
                        'from_date' => '$("#fromDate").val()',
                        'to_date' => '$("#toDate").val()',
                    ])
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
            Column::make('name')->title(__('label.contest_name'))->addClass('text-nowrap'),
            Column::computed('image')->title(__('label.image'))->searchable(false)->orderable(false)->addClass('text-center align-middle text-nowrap'),
            Column::make('target')->title(__('label.target'))->type('string')->addClass('text-nowrap'),
            Column::make('reward_points')->title(__('label.reward_points'))->type('string')->addClass('text-nowrap'),
            Column::make('win_limit')->title(__('label.win_limit'))->type('string')->addClass('text-nowrap'),
            Column::make('details_count')->title(__('label.participants'))->searchable(false)->addClass('text-center text-nowrap')->type('number'),
            Column::make('start_date')->title(__('label.start_date'))->type('string')->addClass('text-nowrap'),
            Column::make('end_date')->title(__('label.end_date'))->type('string')->addClass('text-nowrap'),
            Column::make('status')->title(__('label.status'))->addClass('text-nowrap'),
            Column::make('created_at')->title(__('label.created_at'))->visible(false),
            Column::computed('action')
                  ->title(__('label.action'))
                  ->exportable(false)
                  ->printable(false)
                  ->width(100)
                  ->addClass('text-nowrap')
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
