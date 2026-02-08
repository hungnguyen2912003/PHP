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
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addIndexColumn()
            ->editColumn('fullname', function ($user) {
                return view('admin.pages.users.columns.fullname', compact('user'));
            })
            ->editColumn('date_of_birth', function ($user) {
                if (!$user->date_of_birth)
                    return '<span class="text-warning">' . __('value.not_available') . '</span>';
                $format = 'Y-m-d';
                if (app()->getLocale() == 'vi')
                    $format = 'd/m/Y';
                elseif (app()->getLocale() == 'ja')
                    $format = 'Y/m/d';
                return $user->date_of_birth->format($format);
            })
            ->editColumn('gender', function ($user) {
                if (!$user->gender)
                    return '<span class="text-warning">' . __('value.not_available') . '</span>';
                return match ($user->gender) {
                    'male' => __('value.gender.male'),
                    'female' => __('value.gender.female'),
                    'other' => __('value.gender.other'),
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

    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('role')
            ->when($this->request->get('gender'), function ($query, $gender) {
                $query->where('gender', $gender);
            })
            ->when($this->request->get('role_id'), function ($query, $role_id) {
                $query->where('role_id', $role_id);
            })
            ->when($this->request->get('status'), function ($query, $status) {
                $query->where('status', $status);
            });
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', null, [
                'gender' => '$("#genderFilterValue").val()',
                'role_id' => '$("#roleFilterValue").val()',
                'status' => '$("#statusFilterValue").val()',
            ])
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
            Column::make('fullname')->title(__('label.full_name'))->addClass('text-nowrap')->width(300),
            Column::make('date_of_birth')->title(__('label.date_of_birth'))->addClass('text-nowrap'),
            Column::make('gender')->title(__('label.gender'))->addClass('text-nowrap'),
            Column::make('email')->title(__('label.email'))->addClass('text-nowrap'),
            Column::make('phone')->title(__('label.phone'))->defaultContent('<span class="text-warning">' . __('value.not_available') . '</span>')->addClass('text-nowrap'),
            Column::make('address')->title(__('label.address'))->defaultContent('<span class="text-warning">' . __('value.not_available') . '</span>')->width(500),
            Column::make('role_id')->title(__('label.role'))->addClass('text-nowrap'),
            Column::make('status')->title(__('label.status'))->addClass('text-nowrap'),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_' . date('YmdHis');
    }
}
