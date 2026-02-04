@extends('client.layouts.app-layout')

@section('title', __('title.dashboard'))

@section('content')
<div class="main-content-container overflow-hidden">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <h3>
                                Total Sales
                            </h3>
                            <div class="dropdown select-dropdown without-border">
                                <button aria-expanded="false" class="dropdown-toggle bg-transparent text-secondary fs-15" data-bs-toggle="dropdown">
                                Year 2025
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow rounded-10" data-simplebar="">
                                    <li>
                                        <button class="dropdown-item text-secondary">
                                        Year 2025
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-secondary">
                                        Year 2025
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item text-secondary">
                                        Year 2023
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            </div>
                            <div id="total_sales_chart" style="margin-bottom: -16px; margin-top: -1.5px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-xxl-3 col-xxxl-6">
                        <div class="row">
                            <div class="col-md-6 col-lg-12">
                            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h3 class="mb-10">
                                        Total Orders
                                        </h3>
                                        <h2 class="fs-26 fw-medium mb-0 lh-1">
                                        20,705
                                        </h2>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-primary text-white text-center rounded-circle d-block" style="width: 75px; height: 75px; line-height: 105px;">
                                        <i class="material-symbols-outlined fs-40">
                                        shopping_basket
                                        </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="margin-top: 21px;">
                                    <p class="mb-0 fs-14">
                                        4.75% Increase in orders last week
                                    </p>
                                    <span class="d-flex align-content-center gap-1 bg-success bg-opacity-10 border border-success" style="padding: 3px 5px;">
                                    <i class="material-symbols-outlined fs-14 text-success">
                                    trending_up
                                    </i>
                                    <span class="lh-1 fs-14 text-success">
                                    4.75%
                                    </span>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6 col-lg-12">
                            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h3 class="mb-10">
                                        Total Customers
                                        </h3>
                                        <h2 class="fs-26 fw-medium mb-0 lh-1">
                                        84,127
                                        </h2>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-info text-white text-center rounded-circle d-block" style="width: 75px; height: 75px; line-height: 105px;">
                                        <i class="material-symbols-outlined fs-40">
                                        diversity_2
                                        </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="margin-top: 21px;">
                                    <p class="mb-0 fs-14">
                                        Total visitors decreased by 1.25%
                                    </p>
                                    <span class="d-flex align-content-center gap-1 bg-danger bg-opacity-10 border border-danger" style="padding: 3px 5px;">
                                    <i class="material-symbols-outlined fs-14 text-danger">
                                    trending_down
                                    </i>
                                    <span class="lh-1 fs-14 text-danger">
                                    1.25%
                                    </span>
                                    </span>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-xxl-3 col-xxxl-12">
                        <div class="row">
                            <div class="col-md-6 col-xxxl-6 col-xxl-12">
                            <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h3 class="mb-10">
                                        Total Revenue
                                        </h3>
                                        <h2 class="fs-26 fw-medium mb-0 lh-1">
                                        $15,278
                                        </h2>
                                    </div>
                                    <div class="flex-shrink-0 ms-3">
                                        <div class="bg-warning text-white text-center rounded-circle d-block" style="width: 75px; height: 75px; line-height: 116px;">
                                        <i class="material-symbols-outlined fs-50">
                                        attach_money
                                        </i>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center" style="margin-top: 23px;">
                                    <p class="mb-0 fs-14">
                                        Revenue increases this month
                                    </p>
                                    <span class="d-flex align-content-center gap-1 bg-success bg-opacity-10 border border-success" style="padding: 3px 5px;">
                                    <i class="material-symbols-outlined fs-14 text-success">
                                    trending_up
                                    </i>
                                    <span class="lh-1 fs-14 text-success">
                                    3.15%
                                    </span>
                                    </span>
                                </div>
                            </div>
                            </div>
                            <div class="col-md-6 col-xxxl-6 col-xxl-12">
                            <div class="bg-primary-50 p-20 border rounded-10 border-primary-50 mb-4">
                                <h3 class="text-white mb-12">
                                    Sales Overview
                                </h3>
                                <div class="d-flex flex-wrap gap-2 justify-content-between mb-14">
                                    <div>
                                        <span class="fs-14 text-white mb-1 d-block">
                                        Total Sales
                                        </span>
                                        <h2 class="fs-20 fw-medium lh-1 text-white mb-0">
                                        9,586
                                        </h2>
                                    </div>
                                    <div>
                                        <span class="fs-14 text-white mb-1 d-block">
                                        Monthly Sales
                                        </span>
                                        <h2 class="fs-20 fw-medium lh-1 text-white mb-0">
                                        3,507
                                        </h2>
                                    </div>
                                    <div>
                                        <span class="fs-14 text-white mb-1 d-block">
                                        Todayâs Sales
                                        </span>
                                        <h2 class="fs-20 fw-medium lh-1 text-white mb-0">
                                        357
                                        </h2>
                                    </div>
                                </div>
                                <div aria-label="Basic example" aria-valuemax="100" aria-valuemin="0" aria-valuenow="80" class="progress rounded-0 mb-6" role="progressbar" style="height: 3px; background-color: #6258cc;">
                                    <div class="progress-bar rounded-0 bg-white" style="width: 80%; height: 3px;">
                                    </div>
                                </div>
                                <span class="fs-14 text-white d-block" style="margin-bottom: -6px;">
                                20% Increase in last month
                                </span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>

@endsection
