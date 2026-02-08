<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AdminMeasurementDataTable extends DataTable
{
    public function query(User $model): QueryBuilder
    {
        return $model->newQuery()
            ->whereHas('role', function ($q) {
                $q->where('name', 'User');
            })
            ->with(['measurements'])
            ->withCount('measurements');
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('fullname', function ($row) {
                return $row->fullname;
            })
            ->editColumn('username', function ($row) {
                return '@' . $row->username;
            })
            ->addColumn('bmi', function ($row) {
                $measurements = $row->measurements;

                if (!$measurements || $measurements->isEmpty()) {
                    return '<span class="text-warning">' . __('value.not_available') . '</span>';
                }

                // 1) Group theo ngày và tính daily average (weight + height)
                //    - Loại bỏ record thiếu weight/height
                //    - Loại bỏ ngày bị thiếu 1 trong 2
                $dailyAverages = $measurements
                    ->filter(function ($m) {
                    return !is_null($m->weight) && !is_null($m->height) && $m->height > 0;
                })
                    ->groupBy(function ($m) {
                    return $m->recorded_at->format('Y-m-d');
                })
                    ->map(function ($dayGroup) {
                    $avgWeight = (float) $dayGroup->avg('weight');
                    $avgHeight = (float) $dayGroup->avg('height');

                    // Nếu 1 ngày nào đó vẫn thiếu (do toàn null) thì bỏ
                    if ($avgWeight <= 0 || $avgHeight <= 0) {
                        return null;
                    }

                    return [
                        'weight' => $avgWeight,
                        'height' => $avgHeight, // cm
                    ];
                })
                    ->filter() // remove null days
                    ->values();

                if ($dailyAverages->isEmpty()) {
                    return '<span class="text-warning">' . __('value.not_available') . '</span>';
                }

                // 2) Tính overall average trên các ngày
                //    (avg của collection array => pluck)
                $avgWeight = (float) $dailyAverages->pluck('weight')->avg(); // kg
                $avgHeight = (float) $dailyAverages->pluck('height')->avg(); // cm
    
                if ($avgWeight <= 0 || $avgHeight <= 0) {
                    return '<span class="text-warning">' . __('value.not_available') . '</span>';
                }

                // 3) Tính BMI từ 2 giá trị trung bình
                $h = $avgHeight / 100; // m
                $bmi = round($avgWeight / ($h * $h), 1);

                // BMI status
                [$status, $badgeClass] = (function (float $bmi) {
                    if ($bmi < 18.5) {
                        return [__('label.bmi_underweight'), 'bg-info'];
                    }
                    if ($bmi < 25) {
                        return [__('label.bmi_normal'), 'bg-success'];
                    }
                    if ($bmi < 30) {
                        return [__('label.bmi_overweight'), 'bg-warning text-dark'];
                    }
                    return [__('label.bmi_obese'), 'bg-danger'];
                })($bmi);

                // (optional) show tooltip / hint days counted
                $daysCount = $dailyAverages->count();

                return '
                <div class="d-flex flex-column align-items-center">
                    <span class="fw-bold">' . number_format($bmi, 1) . '</span>
                    <span class="badge ' . $badgeClass . ' fs-12">' . e($status) . '</span>
                    <small class="text-muted" style="font-size:11px;">' . $daysCount . ' days</small>
                </div>
            ';
            })

            ->editColumn('measurements_count', function ($row) {
                return '<span class="badge bg-primary fs-14">' . $row->measurements_count . '</span>';
            })
            ->addColumn('action', 'admin.pages.measurements.columns.user_action')
            ->rawColumns(['bmi', 'measurements_count', 'action'])
            ->setRowId('id')
            ->addIndexColumn();
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('admin-measurement-table')
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
            Column::make('fullname')->title(__('label.full_name'))->searchable(true)->addClass('text-nowrap'),
            Column::make('username')->title(__('label.username'))->searchable(true)->addClass('text-nowrap'),
            Column::computed('bmi')->title(__('label.bmi'))->addClass('text-nowrap text-center'),
            Column::make('measurements_count')->title(__('label.measurement_record'))->searchable(false)->addClass('text-nowrap text-center')->type('string'),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-end text-nowrap'),
        ];
    }

    protected function filename(): string
    {
        return 'Admin_Measurement_' . date('YmdHis');
    }
}
