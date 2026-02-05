@extends('admin.layouts.app-layout')

@section('title', __('title.update_weight'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.update_weight') }}
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
                        <span>{{ __('breadcrumb.health_data') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <a class="text-decoration-none" href="{{ route('admin.weights.index') }}">
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.weight_list') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.update_weight') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="editWeightForm" action="{{ route('admin.weights.update', $weight->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.weight_info') }} ({{ $weight->user->fullname ?? __('value.unknown') }})
                        </h3>
                        <div class="row">
                            <div class="row g-3">
                                <div class="col-lg-8">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="label fs-16 mb-2">{{ __('label.weight') }} (kg)</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="weight" name="weight"
                                                    placeholder="{{ __('placeholder.weight') }}" type="number" step="0.1"
                                                    value="{{ old('weight', $weight->weight) }}" />
                                                <label for="weight">
                                                    <i class="ri-weight-line"></i>
                                                    {{ __('placeholder.weight') }}
                                                </label>
                                            </div>
                                            @error('weight')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label class="label fs-16 mb-2">{{ __('label.recorded_at') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="recorded_at" name="recorded_at"
                                                    type="datetime-local"
                                                    value="{{ old('recorded_at', $weight->recorded_at->format('Y-m-d\TH:i')) }}" />
                                                <label for="recorded_at">
                                                    <i class="ri-calendar-line"></i>
                                                    {{ __('placeholder.recorded_at') }}
                                                </label>
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
                                                    style="height: 150px; resize: none;">{{ old('notes', $weight->notes) }}</textarea>
                                                <label for="notes">
                                                    <i class="ri-sticky-note-line"></i>
                                                    {{ __('placeholder.notes') }}
                                                </label>
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
                                            <input type="file" class="edit-image-filepond" id="attachment"
                                                name="attachment">
                                            <input type="hidden" name="remove_attachment" id="remove_attachment" value="0">
                                            @error('attachment')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex gap-2 justify-content-center mt-4">
                                        <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn">
                                            <span id="btnText">{{ __('button.update') }}</span>
                                            <span id="btnLoading"
                                                class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                        </button>
                                        <a href="{{ route('admin.weights.index') }}"
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputElement = document.querySelector('.edit-image-filepond');
            if (inputElement) {
                const pond = FilePond.create(inputElement, {
                    allowImagePreview: true,
                    storeAsFile: true,
                    labelIdle: `{!! __('placeholder.drag_drop_file') !!}`,
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                    files: [
                        @if ($weight->attachment_url)
                                {
                                source: '{{ asset($weight->attachment_url) }}',
                                options: {
                                    type: 'local',
                                },
                            }
                        @endif
                        ],
                    server: {
                        load: (source, load, error, progress, abort, headers) => {
                            fetch(source).then(response => response.blob()).then(load);
                        }
                    }
                });

                pond.on('removefile', (error, file) => {
                    document.getElementById('remove_attachment').value = '1';
                });

                pond.on('addfile', (error, file) => {
                    document.getElementById('remove_attachment').value = '0';
                });
            }
        });
    </script>
@endpush
