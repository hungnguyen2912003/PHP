<?php

namespace App\DataTables;

use App\Models\Measurement;
use App\Services\HealthStatusService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UserMeasurementsDataTable extends DataTable
{
    protected string $userId;

    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    public function query(Measurement $model): QueryBuilder
    {
        return $model->newQuery()
            ->with('user')
            ->where('user_id', $this->userId)
            ->when($this->request->get('from_date'), function ($query, $fromDate) {
                return $query->whereDate('recorded_at', '>=', $fromDate);
            })
            ->when($this->request->get('to_date'), function ($query, $toDate) {
                return $query->whereDate('recorded_at', '<=', $toDate);
            })
            ->when(!$this->request->get('order'), function ($query) {
                $query->orderBy('recorded_at', 'desc');
            });
    }

    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('recorded_at', function ($row) {
                return \Carbon\Carbon::parse($row->recorded_at)->format('d/m/Y H:i');
            })
            ->editColumn('weight', fn($row) => $this->formatBadge($row->weight, HealthStatusService::bmi($row->bmi)))
            ->editColumn('height', fn($row) => $this->formatBadge($row->height, HealthStatusService::height($row->height)))
            ->editColumn('bmi', fn($row) => $this->formatBadge($row->bmi, HealthStatusService::bmi($row->bmi)))
            ->editColumn('body_fat', fn($row) => $this->formatBadge($row->body_fat, HealthStatusService::bodyFat($row->body_fat, $row->user->gender ?? null)))
            ->editColumn('fat_free_body_weight', fn($row) => $this->formatBadge($row->fat_free_body_weight))
            ->editColumn('muscle_mass', fn($row) => $this->formatBadge($row->muscle_mass, HealthStatusService::muscleMass($row->muscle_mass, $row->weight)))
            ->editColumn('skeletal_muscle_mass', fn($row) => $this->formatBadge($row->skeletal_muscle_mass, HealthStatusService::skeletalMuscle($row->skeletal_muscle_mass)))
            ->editColumn('subcutaneous_fat', fn($row) => $this->formatBadge($row->subcutaneous_fat, HealthStatusService::subcutaneousFat($row->subcutaneous_fat)))
            ->editColumn('visceral_fat', fn($row) => $this->formatBadge($row->visceral_fat, HealthStatusService::visceralFat($row->visceral_fat)))
            ->editColumn('body_water', fn($row) => $this->formatBadge($row->body_water, HealthStatusService::bodyWater($row->body_water)))
            ->editColumn('protein', fn($row) => $this->formatBadge($row->protein, HealthStatusService::protein($row->protein)))
            ->editColumn('bone_mass', fn($row) => $this->formatBadge($row->bone_mass, HealthStatusService::boneMass($row->bone_mass, $row->weight)))
            ->editColumn('bmr', fn($row) => $this->formatBadge($row->bmr, HealthStatusService::bmr($row->bmr, $row->user->gender ?? null)))
            ->editColumn('waist', fn($row) => $this->formatBadge($row->waist))
            ->editColumn('hip', fn($row) => $this->formatBadge($row->hip))
            ->editColumn('whr', fn($row) => $this->formatBadge($row->whr, HealthStatusService::whr($row->whr, $row->user->gender ?? null)))
            ->editColumn('attachment', function ($row) {
                if ($row->attachment_url) {
                    return '<img src="' . asset($row->attachment_url) . '" alt="Attachment" class="img-thumbnail" style="height: 50px;">';
                }
                return '<span class="text-warning">' . __('value.not_available') . '</span>';
            })
            ->addColumn('action', 'admin.pages.measurements.columns.action')
            ->rawColumns([
                'recorded_at',
                'weight',
                'height',
                'bmi',
                'body_fat',
                'fat_free_body_weight',
                'muscle_mass',
                'skeletal_muscle_mass',
                'subcutaneous_fat',
                'visceral_fat',
                'body_water',
                'protein',
                'bone_mass',
                'bmr',
                'waist',
                'hip',
                'whr',
                'attachment',
                'action'
            ])
            ->setRowId('id')
            ->addIndexColumn();
    }

    private function formatBadge($value, ?int $status = null): string
    {
        if (is_null($value) || $value === '') {
            return '<span class="text-warning">' . __('value.not_available') . '</span>';
        }

        $badgeClass = match ($status) {
            HealthStatusService::LOW => 'bg-info',
            HealthStatusService::NORMAL => 'bg-success',
            HealthStatusService::HIGH => 'bg-danger',
            default => 'bg-secondary',
        };

        return '<span class="badge ' . $badgeClass . ' fs-12">' . number_format((float) $value, 2) . '</span>';
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('user-measurement-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', null, [
                'from_date' => '$("#fromDate").val()',
                'to_date' => '$("#toDate").val()',
            ])
            ->orders([])
            ->selectStyleSingle()
            ->parameters([
                'dom' => 'Brt<"d-flex justify-content-between align-items-center p-20"ip>',
                'buttons' => [],
                'language' => [
                    'url' => asset('lang/' . app()->getLocale() . '/datatable.json')
                ],
                'scrollX' => true,
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
            Column::make('recorded_at')->title(__('label.recorded_at'))->addClass('text-nowrap'),
            Column::make('weight')->title(__('label.weight') . ' (kg)')->addClass('text-nowrap text-center'),
            Column::make('height')->title(__('label.height') . ' (cm)')->addClass('text-nowrap text-center'),
            Column::make('bmi')->title(__('label.bmi'))->addClass('text-nowrap text-center'),
            Column::make('body_fat')->title(__('label.body_fat'))->addClass('text-nowrap text-center'),
            Column::make('fat_free_body_weight')->title(__('label.fat_free_body_weight'))->addClass('text-nowrap text-center'),
            Column::make('muscle_mass')->title(__('label.muscle_mass'))->addClass('text-nowrap text-center'),
            Column::make('skeletal_muscle_mass')->title(__('label.skeletal_muscle_mass'))->addClass('text-nowrap text-center'),
            Column::make('subcutaneous_fat')->title(__('label.subcutaneous_fat'))->addClass('text-nowrap text-center'),
            Column::make('visceral_fat')->title(__('label.visceral_fat'))->addClass('text-nowrap text-center'),
            Column::make('body_water')->title(__('label.body_water'))->addClass('text-nowrap text-center'),
            Column::make('protein')->title(__('label.protein'))->addClass('text-nowrap text-center'),
            Column::make('bone_mass')->title(__('label.bone_mass'))->addClass('text-nowrap text-center'),
            Column::make('bmr')->title(__('label.bmr'))->addClass('text-nowrap text-center'),
            Column::make('waist')->title(__('label.waist'))->addClass('text-nowrap text-center'),
            Column::make('hip')->title(__('label.hip'))->addClass('text-nowrap text-center'),
            Column::make('whr')->title(__('label.whr'))->addClass('text-nowrap text-center'),
            Column::make('attachment')->title(__('label.attachment'))->addClass('text-nowrap text-center')->orderable(false),
            Column::computed('action')
                ->title(__('label.action'))
                ->exportable(false)
                ->printable(false)
                ->width(100)
                ->addClass('text-end text-nowrap'),
        ];
    }
}
