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

        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                    <h3 class="mb-20">
                        {{ __('label.contest_information') }}
                    </h3>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>{{ __('label.contest_name') }}:</strong>
                            <p class="text-secondary mb-0">{{ $contest->name }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <strong>{{ __('label.type') }}:</strong>
                            <p class="text-secondary mb-0">{{ $contest->type }}</p>
                        </div>
                        <div class="col-md-3 mb-3">
                            <strong>{{ __('label.target') }}:</strong>
                            <p class="text-secondary mb-0">{{ $contest->target }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('label.start_date') }}:</strong>
                            <p class="text-secondary mb-0">{{ $contest->start_date ? $contest->start_date->format('Y-m-d H:i') : '' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('label.end_date') }}:</strong>
                            <p class="text-secondary mb-0">{{ $contest->end_date ? $contest->end_date->format('Y-m-d H:i') : '' }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <strong>{{ __('label.status') }}:</strong>
                            <p class="text-secondary mb-0">
                                @php
                                    $badges = [
                                        'inprogress' => 'bg-info',
                                        'completed' => 'bg-success',
                                        'cancelled' => 'bg-danger',
                                    ];
                                    $class = $badges[$contest->status] ?? 'bg-secondary';
                                    $translatedStatus = __('value.status.' . $contest->status);
                                @endphp
                                <span class="badge {{ $class }}">{{ $translatedStatus }}</span>
                            </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>{{ __('label.image') }}:</strong>
                            @if($contest->image_url)
                                <div class="mt-2">
                                    <img src="{{ asset($contest->image_url) }}" alt="Contest Image" width="200" class="img-thumbnail rounded">
                                </div>
                            @else
                                <p class="text-secondary mb-0">{{ __('value.not_available') }}</p>
                            @endif
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>{{ __('label.description') }}:</strong>
                            <p class="text-secondary mb-0">{{ $contest->description ?: __('value.not_available') }}</p>
                        </div>

                        <div class="col-12 mt-4 text-center">
                            <a href="{{ route('admin.contests.edit', $contest->id) }}" class="btn btn-primary fw-normal text-white">
                                {{ __('button.edit') }}
                            </a>
                            <a href="{{ route('admin.contests.index') }}" class="btn btn-secondary fw-normal text-white ms-2">
                                {{ __('button.back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
