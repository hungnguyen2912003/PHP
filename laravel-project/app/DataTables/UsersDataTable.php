<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder<User> $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('fullname', function ($user) {
                return view('admin.pages.users.columns.fullname', compact('user'));
            })
            ->editColumn('date_of_birth', function ($user) {
                if (!$user->date_of_birth)
                    return '<span class="text-warning">' . __('admin/pages/users/table.values.not_available') . '</span>';
                $format = 'Y-m-d';
                if (app()->getLocale() == 'vi')
                    $format = 'd/m/Y';
                elseif (app()->getLocale() == 'ja')
                    $format = 'Y/m/d';
                return $user->date_of_birth->format($format);
            })
            ->editColumn('gender', function ($user) {
                if (!$user->gender)
                    return '<span class="text-warning">' . __('admin/pages/users/table.values.not_available') . '</span>';
                return match ($user->gender) {
                    'male' => __('admin/pages/users/table.values.gender.male'),
                    'female' => __('admin/pages/users/table.values.gender.female'),
                    'other' => __('admin/pages/users/table.values.gender.other'),
                    default => $user->gender,
                };
            })
            ->editColumn('role_id', function ($user) {
                return view('admin.pages.users.columns.role', compact('user'));
            })
            ->editColumn('status', function ($user) {
                return view('admin.pages.users.columns.status', compact('user'));
            })
            ->addColumn('action', function ($user) {
                return view('admin.pages.users.columns.action', compact('user'));
            })
            ->rawColumns(['fullname', 'date_of_birth', 'gender', 'role_id', 'status', 'action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     *
     * @return QueryBuilder<User>
     */
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()->with('role');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
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
                            const tooltipTriggerList = document.querySelectorAll(\'[data-bs-toggle="tooltip"]\')
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
            Column::make('DT_RowIndex')->title(__('admin/pages/users/table.columns.stt'))->searchable(false)->orderable(false)->addClass('text-start'),
            Column::make('fullname')->title(__('admin/pages/users/table.columns.full_name')),
            Column::make('date_of_birth')->title(__('admin/pages/users/table.columns.date_of_birth')),
            Column::make('gender')->title(__('admin/pages/users/table.columns.gender')),
            Column::make('email')->title(__('admin/pages/users/table.columns.email')),
            Column::make('phone')->title(__('admin/pages/users/table.columns.phone'))->defaultContent('<span class="text-warning">' . __('admin/pages/users/table.values.not_available') . '</span>'),
            Column::make('address')->title(__('admin/pages/users/table.columns.address'))->defaultContent('<span class="text-warning">' . __('admin/pages/users/table.values.not_available') . '</span>'),
            Column::make('role_id')->title(__('admin/pages/users/table.columns.role')),
            Column::make('status')->title(__('admin/pages/users/table.columns.status')),
            Column::computed('action')
                ->title(__('admin/pages/users/table.columns.action'))
                ->exportable(false)
                ->printable(false)
                ->width(100),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
