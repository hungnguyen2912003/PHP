@extends('client.layouts.app-layout')

@section('title', __('title.dashboard'))


@section('content')
<div class="main-content-container overflow-hidden">
    <div class="row">
        <!-- Main Charts -->
        <div class="col-lg-6 col-xxl-6 col-xxxl-6">
            <div class="card p-20 rounded-10 border mb-4 summary-card" style="background-color: white; border-color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ __('label.weight') }}</h3>
                </div>
                <div id="weight_chart"></div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6 col-xxxl-6">
            <div class="card p-20 rounded-10 border mb-4 summary-card" style="background-color: white; border-color: white;">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <h3 class="mb-0">{{ __('label.height') }}</h3>
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
        </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const weightData = @json($weights);
        const heightData = @json($heights);

        const sparklineOptions = {
            chart: {
                type: 'area',
                height: 40,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: true
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            fill: {
                opacity: 0.3,
            },
            yaxis: {
                min: 0
            },
            colors: ['#008FFB'],
            tooltip: {
                enabled: false
            }
        };

        // Weight Sparkline
        const weightSparkline = new ApexCharts(document.querySelector("#weight_sparkline"), {
            ...sparklineOptions,
            series: [{
                data: weightData.map(item => item.value)
            }],
        });
        weightSparkline.render();

        // Height Sparkline
        const heightSparkline = new ApexCharts(document.querySelector("#height_sparkline"), {
            ...sparklineOptions,
            series: [{
                data: heightData.map(item => item.value)
            }],
        });
        heightSparkline.render();

        const commonOptions = {
            chart: {
                height: 350,
                type: 'line',
                toolbar: {
                    show: false
                },
                dropShadow: {
                    enabled: true,
                    top: 3,
                    left: 2,
                    blur: 4,
                    opacity: 1,
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -10,
                style: {
                    fontSize: '12px',
                    fontFamily: 'Outfit',
                    colors: ["#304758"]
                },
                background: {
                    enabled: true,
                    foreColor: '#fff',
                    padding: 4,
                    borderRadius: 2,
                    borderWidth: 1,
                    borderColor: '#fff',
                    opacity: 0.9,
                    dropShadow: {
                        enabled: false,
                        top: 1,
                        left: 1,
                        blur: 1,
                        color: '#000',
                        opacity: 0.45
                    }
                },
            },
            stroke: {
                width: 7,
                curve: 'smooth'
            },
            markers: {
                size: 6,
                colors: ["#FFA41B"],
                strokeColors: "#fff",
                strokeWidth: 2,
                hover: {
                    size: 7,
                }
            },
            yaxis: {
                labels: {
                    style: {
                        colors: "#919aa3",
                        fontSize: "12px",
                        fontFamily: 'Outfit',
                    }
                }
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 5,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    gradientToColors: ['#00E396', '#008FFB'],
                    shadeIntensity: 1,
                    type: 'horizontal',
                    opacityFrom: 1,
                    opacityTo: 1,
                    stops: [0, 50, 100]
                }
            },
        };

        const weightOptions = {
            ...commonOptions,
            series: [{
                name: '{{ __('label.weight') }}',
                data: weightData.map(item => item.value)
            }],
            xaxis: {
                type: 'category',
                categories: weightData.map(item => {
                    const parts = item.date.split('-');
                    return `${parts[2]}/${parts[1]}`;
                }),
                labels: {
                    style: {
                        colors: "#919aa3",
                        fontSize: "12px",
                        fontFamily: 'Outfit',
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tooltip: { enabled: false }
            },
            colors: ['#FEB019'],
        };

        const heightOptions = {
            ...commonOptions,
            series: [{
                name: '{{ __('label.height') }}',
                data: heightData.map(item => item.value)
            }],
            xaxis: {
                type: 'category',
                categories: heightData.map(item => {
                    const parts = item.date.split('-');
                    return `${parts[2]}/${parts[1]}`;
                }),
                labels: {
                    style: {
                        colors: "#919aa3",
                        fontSize: "12px",
                        fontFamily: 'Outfit',
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                tooltip: { enabled: false }
            },
            colors: ['#FEB019'],
        };

        if (document.querySelector("#weight_chart")) {
            const weightChart = new ApexCharts(document.querySelector("#weight_chart"), weightOptions);
            weightChart.render();
        }

        if (document.querySelector("#height_chart")) {
            const heightChart = new ApexCharts(document.querySelector("#height_chart"), heightOptions);
            heightChart.render();
        }
    });
</script>
@endpush
