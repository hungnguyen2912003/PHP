@extends('client.layouts.app-layout')

@section('title', __('title.dashboard'))


@section('content')
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }

        .apexcharts-canvas,
        .apexcharts-marker,
        .apexcharts-xaxis-label {
            cursor: pointer !important;
        }
    </style>
    <div class="main-content-container overflow-hidden">
        <div class="card gradient-bg-2 p-4 pb-0 rounded-10 border-0 mb-4">
            <div class="row">
                <div class="col-xxl-6 col-xxxl-12">
                    <div class="pe-xxl-4">
                        <div class="row">
                            <div class="col-xxl-6 col-xxxl-12">
                                <div class="row align-items-stretch">
                                    <div class="col-md-4 d-flex">
                                        <div
                                            class="card p-20 bg-white rounded-10 border border-white mb-4 position-relative z-1 w-100 h-100">
                                            <div class="d-flex align-items-center gap-3 h-100">
                                                <div class="flex-shrink-0">
                                                    <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}"
                                                        alt="avatar" class="rounded-circle border border-2 border-primary"
                                                        style="width: 100px; height: 100px; object-fit: cover;">
                                                </div>
                                                <div class="flex-grow-1">
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-sm-5 fw-bold text-secondary">
                                                            {{ __('label.full_name') }}:
                                                        </div>
                                                        <div class="col-sm-7 {{ !$user->fullname ? 'text-warning' : '' }}">
                                                            {{ $user->fullname ?: __('value.not_available') }}
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 mb-2">
                                                        <div class="col-sm-5 fw-bold text-secondary">
                                                            {{ __('label.gender') }}:
                                                        </div>
                                                        <div class="col-sm-7 {{ !$user->gender ? 'text-warning' : '' }}">
                                                            {{ $user->gender ? __('value.gender.' . $user->gender) : __('value.not_available') }}
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-sm-5 fw-bold text-secondary">
                                                            {{ __('label.date_of_birth') }}:
                                                        </div>
                                                        <div
                                                            class="col-sm-7 {{ !$user->date_of_birth ? 'text-warning' : '' }}">
                                                            {{ $user->date_of_birth ? \Carbon\Carbon::parse($user->date_of_birth)->format('d/m/Y') : __('value.not_available') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8 d-flex">
                                        <div
                                            class="card p-20 bg-white rounded-10 border border-white mb-4 position-relative z-1 w-100 h-100">
                                            <div class="text-center mb-2">
                                                <span id="summary-date"
                                                    class="badge bg-primary-subtle text-primary px-3 py-2 fs-6 rounded-pill fw-bold">...</span>
                                            </div>
                                            <div class="row g-4">
                                                <div class="col-md-4">
                                                    <div class="p-4 rounded-4 border d-flex flex-column justify-content-center summary-data-card h-100"
                                                        style="background-color: white; border-color: #e9eef7;">
                                                        <div class="text-center">
                                                            <div class="text-primary fw-semibold mb-2">
                                                                {{ __('label.weight_avg') }}
                                                            </div>
                                                            <div class="fs-3 fw-bold text-dark" id="summary-weight">... kg
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="p-4 rounded-4 border d-flex flex-column justify-content-center summary-data-card h-100"
                                                        style="background-color: white; border-color: #e9eef7;">
                                                        <div class="text-center">
                                                            <div class="text-primary fw-semibold mb-2">{{ __('label.bmi') }}
                                                            </div>
                                                            <div class="fs-3 fw-bold" id="summary-bmi">...</div>
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
                                                                <div class="bmi-dot" id="bmi-dot" style="left: 0%"></div>
                                                            </div>

                                                            <div
                                                                class="bmi-labels-bottom d-flex justify-content-between mt-2">
                                                                <span
                                                                    class="text-secondary">{{ __('label.bmi_underweight') }}</span>
                                                                <span
                                                                    class="text-secondary">{{ __('label.bmi_normal') }}</span>
                                                                <span
                                                                    class="text-secondary">{{ __('label.bmi_overweight') }}</span>
                                                                <span
                                                                    class="text-secondary">{{ __('label.bmi_obese') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="p-4 rounded-4 border d-flex flex-column justify-content-center summary-data-card h-100"
                                                        style="background-color: white; border-color: #e9eef7;">
                                                        <div class="text-center">
                                                            <div class="text-primary fw-semibold mb-2">
                                                                {{ __('label.height_avg') }}
                                                            </div>
                                                            <div class="fs-3 fw-bold text-dark" id="summary-height">... cm
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xxxl-12">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end mb-3 mt-3">
                            <input type="hidden" id="fromDate">
                            <input type="hidden" id="toDate">
                            <div class="dropdown select-dropdown without-border border-style">
                                <button aria-expanded="false" class="dropdown-toggle bg-transparent text-white fs-15"
                                    data-bs-toggle="dropdown">
                                    {{ __('label.' . $chartData['filter']) }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow rounded-10"
                                    data-simplebar="">
                                    <li>
                                        <a class="dropdown-item text-secondary text-capitalize"
                                            href="{{ route('client.dashboard', ['filter' => 'day']) }}">
                                            {{ __('label.day') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-secondary text-capitalize"
                                            href="{{ route('client.dashboard', ['filter' => 'week']) }}">
                                            {{ __('label.weekly') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-secondary text-capitalize"
                                            href="{{ route('client.dashboard', ['filter' => 'month']) }}">
                                            {{ __('label.monthly') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h3 class="text-white mb-3">
                                    {{ __('label.weight_history') }} (kg)
                                </h3>
                                <div id="weight_history_chart"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h3 class="text-white mb-3">
                                    {{ __('label.height_history') }} (cm)
                                </h3>
                                <div id="height_history_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-white rounded-10 border border-white mb-4">
                <div
                    class="card-header bg-transparent border-0 p-20 pb-0 d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">{{ __('label.measurement_record') }}</h3>
                    <a class="text-decoration-none fs-16 text-primary" href="{{ route('client.measurement.create') }}"
                        id="add-record-btn">
                        + {{ __('title.create_measurement') }}
                    </a>
                </div>
                <div class="card-body p-20">
                    <div class="default-table-area mx-minus-1 style-two table-list mt-0">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table align-middle w-100']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const chartData = @json($chartData);

                function updateSummaryCards(index) {
                    const weight = chartData.weight[index];
                    const height = chartData.height[index];
                    const fullDate = chartData.full_labels[index];
                    const fromDate = chartData.from_dates[index];
                    const toDate = chartData.to_dates[index];

                    const weightEl = document.getElementById('summary-weight');
                    const heightEl = document.getElementById('summary-height');
                    const bmiEl = document.getElementById('summary-bmi');
                    const bmiDot = document.getElementById('bmi-dot');
                    const dateEl = document.getElementById('summary-date');
                    const fromDateInput = document.getElementById('fromDate');
                    const toDateInput = document.getElementById('toDate');
                    const addRecordBtn = document.getElementById('add-record-btn');

                    if (dateEl) dateEl.textContent = fullDate;
                    if (fromDateInput) fromDateInput.value = fromDate;
                    if (toDateInput) toDateInput.value = toDate;

                    if (addRecordBtn) {
                        const baseUrl = "{{ route('client.measurement.create') }}";
                        addRecordBtn.href = `${baseUrl}?date=${fromDate}`;
                    }

                    // Redraw datatable
                    if (window.LaravelDataTables && window.LaravelDataTables["measurement-table"]) {
                        window.LaravelDataTables["measurement-table"].draw();
                    }

                    if (weightEl) weightEl.textContent = weight > 0 ? weight + ' kg' : '... kg';
                    if (heightEl) heightEl.textContent = height > 0 ? height + ' cm' : '...';

                    if (weight > 0 && height > 0) {
                        const bmi = (weight / ((height / 100) ** 2)).toFixed(1);
                        if (bmiEl) bmiEl.textContent = bmi;

                        // Calculate dot position
                        let position = 0;
                        if (bmi < 18.5) {
                            position = (bmi / 18.5) * 25;
                        } else if (bmi < 25) {
                            position = 25 + ((bmi - 18.5) / (25 - 18.5)) * 25;
                        } else if (bmi < 30) {
                            position = 50 + ((bmi - 25) / (30 - 25)) * 25;
                        } else {
                            position = 75 + Math.min(((bmi - 30) / (40 - 30)) * 25, 25);
                        }

                        if (bmiDot) {
                            bmiDot.style.left = position + '%';
                            bmiDot.style.display = 'block';
                        }
                    } else {
                        if (bmiEl) bmiEl.textContent = '...';
                        if (bmiDot) bmiDot.style.display = 'none';
                    }
                }

                function renderHistoryChart(elementId, color, label, data, unit) {
                    const element = document.getElementById(elementId);
                    if (!element) return;

                    const options = {
                        series: [{
                            name: label,
                            data: data
                        }],
                        chart: {
                            height: 280,
                            type: "area",
                            animations: { speed: 500 },
                            toolbar: { show: false },
                            sparkline: { enabled: false },
                            events: {
                                dataPointSelection: function (event, chartContext, config) {
                                    updateSummaryCards(config.dataPointIndex);
                                },
                                xAxisLabelClick: function (event, chartContext, config) {
                                    updateSummaryCards(config.labelIndex);
                                }
                            }
                        },
                        colors: [color],
                        dataLabels: { enabled: false },
                        fill: {
                            type: "gradient",
                            gradient: {
                                shadeIntensity: 1,
                                opacityFrom: 0.5,
                                opacityTo: 0.1,
                                stops: [0, 90, 100]
                            }
                        },
                        xaxis: {
                            categories: chartData.labels,
                            axisBorder: { show: true, color: 'rgba(255, 255, 255, 0.2)' },
                            axisTicks: { show: true, color: 'rgba(255, 255, 255, 0.2)' },
                            labels: {
                                style: {
                                    colors: "#fff",
                                    fontSize: "12px",
                                    fontFamily: 'Outfit',
                                    cssClass: 'cursor-pointer',
                                },
                            }
                        },
                        yaxis: {
                            tickAmount: 4,
                            labels: {
                                style: {
                                    colors: "#fff",
                                    fontSize: "12px",
                                    fontFamily: 'Outfit',
                                },
                                formatter: (val) => val > 0 ? val.toFixed(1) + ' ' + unit : val
                            }
                        },
                        stroke: { curve: "smooth", width: 3 },
                        markers: {
                            size: 4,
                            strokeColors: '#fff',
                            strokeWidth: 2,
                            hover: {
                                size: 7,
                            }
                        },
                        states: {
                            hover: {
                                filter: {
                                    type: 'lighten',
                                    value: 0.15,
                                }
                            },
                            active: {
                                allowMultipleDataPointsSelection: false,
                                filter: {
                                    type: 'none',
                                }
                            }
                        },
                        grid: {
                            show: true,
                            borderColor: 'rgba(255, 255, 255, 0.1)',
                            strokeDashArray: 5,
                            position: 'back',
                        },
                        tooltip: { theme: 'dark' }
                    };

                    new ApexCharts(element, options).render();
                }

                renderHistoryChart('weight_history_chart', '#00cae3', "{{ __('label.weight') }}", chartData.weight, 'kg');
                renderHistoryChart('height_history_chart', '#796df6', "{{ __('label.height') }}", chartData.height, 'cm');

                // Initialize with the most recent data point
                if (chartData.labels.length > 0) {
                    updateSummaryCards(chartData.labels.length - 1);
                }
            });
        </script>
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    @endpush