@extends('client.layouts.app-layout')

@section('title', __('title.create_height'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.create_height') }}
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
                        <span>{{ __('breadcrumb.height_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.create_height') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="addHeightForm" action="{{ route('client.height.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.height_info') }}
                        </h3>
                        <div class="row">
                            <div class="row g-3">
                                <div class="col-lg-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="label fs-16 mb-2">{{ __('label.height') }} (cm)</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="height" name="height"
                                                    placeholder="{{ __('placeholder.height') }}" type="number" step="0.1"
                                                    value="{{ old('height') }}" />
                                                <label for="height"><i class="ri-ruler-line"></i>{{ __('placeholder.height') }}</label>
                                            </div>
                                            @error('height')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="label fs-16 mb-2">{{ __('label.recorded_at') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="recorded_at" name="recorded_at"
                                                    placeholder="{{ __('placeholder.recorded_at') }}" type="datetime-local"
                                                    value="{{ old('recorded_at', now()->format('Y-m-d\TH:i')) }}" />
                                                <label for="recorded_at"><i
                                                        class="ri-calendar-line"></i>{{ __('placeholder.recorded_at') }}</label>
                                            </div>
                                            @error('recorded_at')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12">
                                            <label class="label fs-16 mb-2">{{ __('label.notes') }}</label>
                                            <div class="form-floating">
                                                <textarea class="form-control" id="notes" name="notes"
                                                    placeholder="{{ __('placeholder.notes') }}"
                                                    style="height: 150px; resize: none;">{{ old('notes') }}</textarea>
                                                <label for="notes"><i
                                                        class="ri-sticky-note-line"></i>{{ __('placeholder.notes') }}</label>
                                            </div>
                                            @error('notes')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <label class="label fs-16 mb-2">{{ __('label.attachment') }}</label>
                                    <div class="border rounded-3 p-3 h-100 d-flex align-items-center">
                                        <div class="w-100">
                                            <input type="file" class="image-filepond" id="attachment" name="attachment">
                                            @error('attachment')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-center mt-2">
                                        <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                            data-processing-text="{{ __('button.sending') }}">
                                            <span id="btnText">{{ __('button.add') }}</span>
                                            <span id="btnLoading"
                                                class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                        </button>
                                        <a href="{{ route('client.height.index') }}"
                                            class="btn btn-danger fw-normal text-white">
                                            {{ __('button.cancel') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/auth.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputElement = document.querySelector('.image-filepond');
            if (inputElement) {
                FilePond.create(inputElement, {
                    allowImagePreview: true,
                    storeAsFile: true,
                    labelIdle: `{!! __('placeholder.drag_drop_file') !!}`,
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                });
            }
        });
    </script>
@endpush