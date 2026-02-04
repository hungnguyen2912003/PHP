@extends('admin.layouts.app-layout')

@section('title', __('title.dashboard'))

@section('content')
<div class="main-content-container overflow-hidden">
    <div class="row">
        <div class="col-xxl-3 col-md-6 col-xxxl-6">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <span class="fs-18 d-block lh-1" style="margin-bottom: 9px;">
                            {{ __('label.total_users') }}
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            {{ number_format($stats['total_users']) }}
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-success position-relative" style="margin-right: 5px;">
                            group
                            </i>
                            <span>
                                {{ __('breadcrumb.users_list') }}
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="total_users_chart" style="max-width: 180px; margin-right: -5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6 col-xxxl-6">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <span class="fs-18 d-block lh-1" style="margin-bottom: 9px;">
                            {{ __('label.new_users') }}
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            {{ number_format($stats['new_users_month']) }}
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-success position-relative" style="margin-right: 5px;">
                            trending_up
                            </i>
                            <span>
                            <span class="text-success">
                                {{ __('label.this_month') }}
                            </span>
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="new_users_chart" style="max-width: 180px; margin-right: -5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6 col-xxxl-6">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <span class="fs-18 d-block lh-1" style="margin-bottom: 9px;">
                            {{ __('label.pending_users') }}
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            {{ number_format($stats['pending_users']) }}
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-warning position-relative" style="margin-right: 5px;">
                            hourglass_empty
                            </i>
                            <span>
                                {{ __('label.pending_users') }}
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="pending_users_chart" style="max-width: 180px; margin-right: -5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-md-6 col-xxxl-6">
            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <span class="fs-18 d-block lh-1" style="margin-bottom: 9px;">
                            {{ __('label.banned_users') }}
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            {{ number_format($stats['banned_users']) }}
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-danger position-relative" style="margin-right: 5px;">
                            block
                            </i>
                            <span>
                                {{ __('label.banned_users') }}
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="banned_users_chart" style="max-width: 180px; margin-right: -5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commonOptions = {
            chart: {
                type: 'area',
                height: 80,
                sparkline: {
                    enabled: true
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                }
            },
            stroke: {
                curve: 'smooth',
                width: 2,
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.5,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            tooltip: {
                fixed: {
                    enabled: false
                },
                x: {
                    show: false
                },
                y: {
                    title: {
                        formatter: function(seriesName) {
                            return ''
                        }
                    }
                },
                marker: {
                    show: false
                }
            }
        };

        const charts = [
            { id: '#total_users_chart', color: '#7366ff', data: @json($trends['total_users']) },
            { id: '#new_users_chart', color: '#51bb25', data: @json($trends['new_users']) },
            { id: '#pending_users_chart', color: '#f8d62b', data: @json($trends['pending_users']) },
            { id: '#banned_users_chart', color: '#fb4432', data: @json($trends['banned_users']) }
        ];

        charts.forEach(chart => {
            const options = {
                ...commonOptions,
                series: [{
                    data: chart.data
                }],
                colors: [chart.color],
            };
            if (document.querySelector(chart.id)) {
                new ApexCharts(document.querySelector(chart.id), options).render();
            }
        });
    });
</script>
@endpush
@endsection
