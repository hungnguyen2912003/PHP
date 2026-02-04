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
                        Tickets Open
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            2.75K
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-success position-relative" style="margin-right: 5px;">
                            trending_up
                            </i>
                            <span>
                            <span class="text-success">
                            20.05%
                            </span>
                            This Week
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="tickets_open_chart" style="max-width: 180px; margin-right: -5px;">
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
                        Tickets In Progress
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            1.25K
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-success position-relative" style="margin-right: 5px;">
                            trending_up
                            </i>
                            <span>
                            <span class="text-success">
                            5.75%
                            </span>
                            This Week
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="tickets_in_progress_chart" style="max-width: 180px; margin-right: -5px;">
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
                        Tickets Resolved
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            753
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-danger position-relative" style="margin-right: 5px;">
                            trending_down
                            </i>
                            <span>
                            <span class="text-danger">
                            7.25%
                            </span>
                            This Week
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="tickets_resolved_chart" style="max-width: 180px; margin-right: -5px;">
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
                        Tickets Closed
                        </span>
                        <h2 class="fs-26 fw-medium" style="margin-bottom: 33px;">
                            487
                        </h2>
                        <p class="d-flex align-items-center">
                            <i class="material-symbols-outlined fs-18 text-danger position-relative" style="margin-right: 5px;">
                            trending_down
                            </i>
                            <span>
                            <span class="text-danger">
                            4.01%
                            </span>
                            This Week
                            </span>
                        </p>
                    </div>
                    <div class="flex-grow-1 ms-3 position-relative">
                        <div class="position-absolute top-50 end-0 translate-middle-y" id="tickets_closed_chart" style="max-width: 180px; margin-right: -5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
