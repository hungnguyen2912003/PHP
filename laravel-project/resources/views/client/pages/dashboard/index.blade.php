@extends('client.layouts.app-layout')

@section('title', __('title.dashboard'))


@section('content')
<div class="main-content-container overflow-hidden">
    <div class="row">
        <!-- Main Charts -->
        {{-- <div class="col-lg-6 col-xxl-6 col-xxxl-6">
            <div class="card p-20 rounded-10 border mb-4 summary-card" style="background-color: white; border-color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ __('label.weight') }}</h3>
                    <div class="chart-filter-toggle" data-chart="weight">
                        <button class="chart-filter-item active" data-filter="days">{{ __('label.days') }}</button>
                        <button class="chart-filter-item" data-filter="weeks">{{ __('label.weeks') }}</button>
                        <button class="chart-filter-item" data-filter="months">{{ __('label.months') }}</button>
                    </div>
                </div>
                <div id="weight_chart"></div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6 col-xxxl-6">
            <div class="card p-20 rounded-10 border mb-4 summary-card" style="background-color: white; border-color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ __('label.height') }}</h3>
                    <div class="chart-filter-toggle" data-chart="height">
                        <button class="chart-filter-item active" data-filter="days">{{ __('label.days') }}</button>
                        <button class="chart-filter-item" data-filter="weeks">{{ __('label.weeks') }}</button>
                        <button class="chart-filter-item" data-filter="months">{{ __('label.months') }}</button>
                    </div>
                </div>
                <div id="height_chart"></div>
            </div>
        </div>

        <div class="col-xl-12 col-xxl-12 col-xxxl-12">
            <div class="card p-20 rounded-10 border mb-4 summary-card" style="background-color: white; border-color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ ucfirst(now()->translatedFormat(__('label.dashboard_date_format'))) }}</h3>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-4 rounded-4 border h-100 d-flex flex-column justify-content-center summary-data-card" style="background-color: white; border-color: #e9eef7;">
                            <div class="text-center">
                                <div class="text-primary fw-semibold mb-2">{{ __('label.weight_avg') }}</div>
                                @if($avgWeight > 0)
                                    <div class="fs-3 fw-bold text-dark">{{ $avgWeight }} kg</div>
                                @else
                                    <div class="fs-6 fw-bold text-warning">{{ __('value.not_available') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 rounded-4 border h-100 d-flex flex-column justify-content-center summary-data-card" style="background-color: white; border-color: #e9eef7;">
                            <div class="text-center">
                                <div class="text-primary fw-semibold mb-2">BMI</div>
                                @if($bmi > 0)
                                    <div class="fs-3 fw-bold" style="color: {{ $bmiColor }}">{{ $bmi }}</div>
                                @else
                                    <div class="fs-6 fw-bold text-warning">{{ __('value.not_available') }}</div>
                                @endif
                            </div>
                            
                            <div class="bmi-indicator-container mt-4">
                                <div class="bmi-labels-top d-flex justify-content-between mb-1">
                                    <span style="left: 25%">18.5</span>
                                    <span style="left: 50%">25</span>
                                    <span style="left: 75%">30</span>
                                </div>
                                
                                <div class="bmi-bar">
                                    <div class="bmi-segment segment-underweight"></div>
                                    <div class="bmi-segment segment-normal"></div>
                                    <div class="bmi-segment segment-overweight"></div>
                                    <div class="bmi-segment segment-obese"></div>
                                    <div class="bmi-dot" style="left: {{ $bmiPercentage }}%"></div>
                                </div>
                                
                                <div class="bmi-labels-bottom d-flex justify-content-between mt-2">
                                    <span class="text-secondary">{{ __('label.bmi_underweight') }}</span>
                                    <span class="text-secondary">{{ __('label.bmi_normal') }}</span>
                                    <span class="text-secondary">{{ __('label.bmi_overweight') }}</span>
                                    <span class="text-secondary">{{ __('label.bmi_obese') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="p-4 rounded-4 border h-100 d-flex flex-column justify-content-center summary-data-card" style="background-color: white; border-color: #e9eef7;">
                            <div class="text-center">
                                <div class="text-primary fw-semibold mb-2">{{ __('label.height_avg') }}</div>
                                @if($avgHeight > 0)
                                    <div class="fs-3 fw-bold text-dark">{{ $avgHeight }} cm</div>
                                @else
                                    <div class="fs-6 fw-bold text-warning">{{ __('value.not_available') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>

@endsection
