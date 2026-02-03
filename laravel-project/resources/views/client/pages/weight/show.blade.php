@extends('client.layouts.app-layout')

@section('title', __('title.weight_details'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.weight_details') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('client.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <a class="text-decoration-none" href="{{ route('client.weight.index') }}">
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.weight_management') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.weight_details') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="card p-20 rounded-10 mb-4">
            <h3 class="mb-20">
                {{ __('section.weight_info') }}
            </h3>
            <div class="row g-3">
                <div class="col-lg-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="label fs-16 mb-2">{{ __('label.weight') }} (kg)</label>
                            <div class="form-control py-3">
                                <i class="material-symbols-outlined fs-16 me-1 align-middle">weight</i>
                                {{ $weight->weight }} kg
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="label fs-16 mb-2">{{ __('label.recorded_at') }}</label>
                            <div class="form-control py-3">
                                <i class="ri-calendar-line me-1 align-middle"></i>
                                {{ $weight->recorded_at->format('d/m/Y H:i:s') }}
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="label fs-16 mb-2">{{ __('label.notes') }}</label>
                            <div class="form-control" style="min-height: 150px;">
                                <i class="ri-sticky-note-line me-1 align-middle"></i>
                                {!! nl2br(e($weight->notes)) ?: '<span class="text-muted">' . __('value.not_available') . '</span>' !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <label class="label fs-16 mb-2">{{ __('label.attachment') }}</label>
                    <div class="border rounded-3 p-3 h-100 d-flex flex-column align-items-center justify-content-center">
                        @if ($weight->attachment_url)
                            <img src="{{ asset($weight->attachment_url) }}" alt="Attachment" class="img-fluid rounded shadow-sm"
                                style="max-height: 250px; object-fit: contain;">
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="ri-image-line fs-1" style="font-size: 4rem;"></i>
                                <p class="mt-2">{{ __('value.not_available') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-12">
                    <div class="d-flex gap-2 justify-content-center mt-4">
                        <a href="{{ route('client.weight.edit', $weight->id) }}"
                            class="btn btn-primary fw-normal text-white">
                            <i class="ri-edit-line"></i> {{ __('button.edit') }}
                        </a>
                        <a href="{{ route('client.weight.index') }}" class="btn btn-danger fw-normal text-white">
                            {{ __('button.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection