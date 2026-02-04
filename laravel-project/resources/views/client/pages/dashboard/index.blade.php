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
        </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let weightChart, heightChart;

        // Helper to format date label
        const formatLabel = (date, filter) => {
            if (filter === 'days' && date.includes('-')) {
                const parts = date.split('-');
                if (parts.length === 3) return `${parts[2]}/${parts[1]}`;
            }
            return date;
        };

        // Function to update chart via AJAX
        const updateChart = async (type, filter) => {
            const chartArea = document.querySelector(`#${type}_chart`);
            if (!chartArea) return;

            chartArea.style.opacity = '0.5';

            try {
                const response = await fetch(`{{ route('client.dashboard.chart-data') }}?type=${type}&filter=${filter}`);
                const data = await response.json();
                
                const chart = (type === 'weight') ? weightChart : heightChart;
                if (!chart) return;

                const values = data.map(item => item.value);
                const categories = data.map(item => formatLabel(item.date, filter));

                chart.updateOptions({
                    xaxis: {
                        categories: categories
                    }
                }, true, true);
                
                chart.updateSeries([{
                    name: (type === 'weight') ? '{{ __('label.weight') }}' : '{{ __('label.height') }}',
                    data: values
                }], true);
                
            } catch (error) {
                console.error('Error fetching chart data:', error);
            } finally {
                chartArea.style.opacity = '1';
            }
        };

        // ... preserving filter toggle logic ...
        const filterToggles = document.querySelectorAll('.chart-filter-toggle');
        filterToggles.forEach(toggle => {
            const items = toggle.querySelectorAll('.chart-filter-item');
            items.forEach(item => {
                item.addEventListener('click', function() {
                    if (this.classList.contains('active')) return;
                    
                    items.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                    
                    const type = toggle.dataset.chart;
                    const filter = this.dataset.filter;
                    
                    updateChart(type, filter);
                });
            });
        });

        const weightData = @json($weights);
        const heightData = @json($heights);

        // ... preserving commonOptions ...
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
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
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
            noData: {
                text: '{{ __('value.not_available') }}',
                align: 'center',
                verticalAlign: 'middle',
                style: {
                    color: '#919aa3',
                    fontSize: '16px',
                    fontFamily: 'Outfit'
                }
            }
        };

        const weightOptions = {
            ...commonOptions,
            series: [{
                name: '{{ __('label.weight') }}',
                data: weightData.map(item => item.value)
            }],
            xaxis: {
                type: 'category',
                categories: weightData.map(item => formatLabel(item.date, 'days')),
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
                categories: heightData.map(item => formatLabel(item.date, 'days')),
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
            weightChart = new ApexCharts(document.querySelector("#weight_chart"), weightOptions);
            weightChart.render();
        }

        if (document.querySelector("#height_chart")) {
            heightChart = new ApexCharts(document.querySelector("#height_chart"), heightOptions);
            heightChart.render();
        }
    });
</script>
@endpush
