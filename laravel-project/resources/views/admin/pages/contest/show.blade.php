@extends('admin.layouts.app-layout')

@section('title', __('title.show_contest'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.show_contest') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('breadcrumb.contest_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.show_contest') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="social-profile">
            <div class="card border-0 bg-white rounded-10 mb-4 position-relative">
                <div class="position-relative overflow-hidden rounded-10" style="height: 400px;">
                    <!-- Background blurred layer -->
                    <div class="position-absolute w-100 h-100" 
                         style="background: url('{{ asset($contest->image_url) }}') center/cover no-repeat; 
                                filter: blur(30px); 
                                transform: scale(1.1); 
                                opacity: 0.6;">
                    </div>
                    <!-- Foreground sharp layer -->
                    <div class="position-relative w-100 h-100 d-flex align-items-center justify-content-center">
                        <img alt="contest-cover" 
                             class="h-100 w-100" 
                             src="{{ asset($contest->image_url) }}" 
                             style="object-fit: contain; position: relative; z-index: 1;" />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-xxl-12 col-xxxl-12">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4 text-center shadow-sm">
                    <!-- Trophy Icon Overlay -->
                    <div class="mb-3">
                        <i class="ri-trophy-fill text-warning" style="font-size: 80px;"></i>
                    </div>

                    <!-- Reward Points -->
                    <h2 class="text-primary fw-bold mb-2">
                        {{ $contest->reward_points }} {{ __('label.reward_points') }}
                    </h2>

                    <!-- Target -->
                    <h5 class="text-secondary fw-semibold mb-3">
                        {{ __('label.target') }}: {{ number_format($contest->target) }}
                    </h5>

                    <!-- Stats Row -->
                    <div class="d-flex justify-content-center align-items-center gap-4 mb-3">
                        <div class="text-secondary fs-18">
                            <span class="text-body fw-bold fs-22">{{ $contest->completed_details_count }}/{{ $contest->win_limit }}</span>
                            <span class="ms-1">{{ strtolower(__('label.won')) }}</span>
                        </div>
                        <div class="text-secondary fs-18">
                            <span class="text-body fw-bold fs-22">{{ $contest->details_count }}</span>
                            <span class="ms-1">{{ strtolower(__('label.joined')) }}</span>
                        </div>
                    </div>

                    <!-- Date Range -->
                    <div class="text-secondary d-flex align-items-center justify-content-center border-top pt-3 mb-4">
                        <i class="ri-calendar-line me-2"></i>
                        <span>
                            {{ $contest->start_date ? $contest->start_date->translatedFormat('Y M d') : '' }} - 
                            {{ $contest->end_date ? $contest->end_date->translatedFormat('Y M d') : '' }}
                        </span>
                    </div>

                    <!-- Description Area -->
                    <div class="text-start">
                        <p class="text-body fs-16 mb-2 lh-base" id="contestDescription">
                            {{ $contest->getTranslation('description', app()->getLocale(), false) ?: __('value.not_available') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Participants Table Section -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4 shadow-sm">
                    <h3 class="mb-20">
                        {{ __('label.participants') }}
                    </h3>
                    <div class="default-table-area">
                        <div class="table-responsive">
                            {{ $dataTable->table(['class' => 'table align-middle']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12 text-center mb-5">
                <a href="{{ route('admin.contests.edit', $contest->id) }}" class="btn btn-primary px-4 fw-normal text-white">
                    {{ __('button.edit') }}
                </a>
                <a href="{{ route('admin.contests.index') }}" class="btn btn-secondary px-4 fw-normal text-white ms-2">
                    {{ __('button.back') }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
