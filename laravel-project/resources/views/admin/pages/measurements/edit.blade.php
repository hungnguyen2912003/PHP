@extends('admin.layouts.app-layout')

@section('title', __('title.update_measurement'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.update_measurement') }}
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
                        <span>{{ __('breadcrumb.measurement_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>
                            {{ __('breadcrumb.measurement_list') }}
                        </span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.update_measurement') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="common-form" action="{{ route('admin.measurements.update', $measurement->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('label.measurement') }} - {{ $measurement->user?->fullname }}
                        </h3>
                        <div class="row">
                            <div class="row g-3">
                                <div class="col-lg-8">
                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.weight') }} (kg)</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="weight" name="weight"
                                                    placeholder="{{ __('label.weight') }}" type="number" step="0.1"
                                                    value="{{ old('weight', $measurement->weight) }}" />
                                                <label for="weight"><i
                                                        class="ri-scales-3-line"></i>{{ __('label.weight') }}</label>
                                            </div>
                                            @error('weight')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.height') }} (cm)</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="height" name="height"
                                                    placeholder="{{ __('label.height') }}" type="number" step="0.1"
                                                    value="{{ old('height', $measurement->height) }}" />
                                                <label for="height"><i
                                                        class="ri-ruler-line"></i>{{ __('label.height') }}</label>
                                            </div>
                                            @error('height')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.recorded_at') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="recorded_at" name="recorded_at"
                                                    placeholder="{{ __('placeholder.recorded_at') }}" type="datetime-local"
                                                    value="{{ old('recorded_at', \Carbon\Carbon::parse($measurement->recorded_at)->format('Y-m-d\TH:i')) }}" />
                                                <label for="recorded_at"><i
                                                        class="ri-calendar-line"></i>{{ __('placeholder.recorded_at') }}</label>
                                            </div>
                                            @error('recorded_at')
                                                <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- New Metrics -->
                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.bmi') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="bmi" name="bmi"
                                                    placeholder="{{ __('label.bmi') }}" type="number" step="0.01"
                                                    value="{{ old('bmi', $measurement->bmi) }}" />
                                                <label for="bmi"><i
                                                        class="ri-bar-chart-box-line"></i>{{ __('label.bmi') }}</label>
                                            </div>
                                            @error('bmi') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.body_fat') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="body_fat" name="body_fat"
                                                    placeholder="{{ __('label.body_fat') }}" type="number" step="0.1"
                                                    value="{{ old('body_fat', $measurement->body_fat) }}" />
                                                <label for="body_fat"><i
                                                        class="ri-percentage-line"></i>{{ __('label.body_fat') }}</label>
                                            </div>
                                            @error('body_fat') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.fat_free_body_weight') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="fat_free_body_weight"
                                                    name="fat_free_body_weight"
                                                    placeholder="{{ __('label.fat_free_body_weight') }}" type="number"
                                                    step="0.1"
                                                    value="{{ old('fat_free_body_weight', $measurement->fat_free_body_weight) }}" />
                                                <label for="fat_free_body_weight"><i
                                                        class="ri-scales-line"></i>{{ __('label.fat_free_body_weight') }}</label>
                                            </div>
                                            @error('fat_free_body_weight') <div class="text-danger mt-1">{{ $message }}
                                            </div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.muscle_mass') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="muscle_mass" name="muscle_mass"
                                                    placeholder="{{ __('label.muscle_mass') }}" type="number" step="0.1"
                                                    value="{{ old('muscle_mass', $measurement->muscle_mass) }}" />
                                                <label for="muscle_mass"><i
                                                        class="ri-body-scan-line"></i>{{ __('label.muscle_mass') }}</label>
                                            </div>
                                            @error('muscle_mass') <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.skeletal_muscle_mass') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="skeletal_muscle_mass"
                                                    name="skeletal_muscle_mass"
                                                    placeholder="{{ __('label.skeletal_muscle_mass') }}" type="number"
                                                    step="0.1"
                                                    value="{{ old('skeletal_muscle_mass', $measurement->skeletal_muscle_mass) }}" />
                                                <label for="skeletal_muscle_mass"><i
                                                        class="ri-pulse-line"></i>{{ __('label.skeletal_muscle_mass') }}</label>
                                            </div>
                                            @error('skeletal_muscle_mass') <div class="text-danger mt-1">{{ $message }}
                                            </div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.subcutaneous_fat') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="subcutaneous_fat" name="subcutaneous_fat"
                                                    placeholder="{{ __('label.subcutaneous_fat') }}" type="number"
                                                    step="0.1"
                                                    value="{{ old('subcutaneous_fat', $measurement->subcutaneous_fat) }}" />
                                                <label for="subcutaneous_fat"><i
                                                        class="ri-drop-line"></i>{{ __('label.subcutaneous_fat') }}</label>
                                            </div>
                                            @error('subcutaneous_fat') <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.visceral_fat') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="visceral_fat" name="visceral_fat"
                                                    placeholder="{{ __('label.visceral_fat') }}" type="number" step="0.1"
                                                    value="{{ old('visceral_fat', $measurement->visceral_fat) }}" />
                                                <label for="visceral_fat"><i
                                                        class="ri-dashboard-3-line"></i>{{ __('label.visceral_fat') }}</label>
                                            </div>
                                            @error('visceral_fat') <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.body_water') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="body_water" name="body_water"
                                                    placeholder="{{ __('label.body_water') }}" type="number" step="0.1"
                                                    value="{{ old('body_water', $measurement->body_water) }}" />
                                                <label for="body_water"><i
                                                        class="ri-water-flash-line"></i>{{ __('label.body_water') }}</label>
                                            </div>
                                            @error('body_water') <div class="text-danger mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.protein') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="protein" name="protein"
                                                    placeholder="{{ __('label.protein') }}" type="number" step="0.1"
                                                    value="{{ old('protein', $measurement->protein) }}" />
                                                <label for="protein"><i
                                                        class="ri-flask-line"></i>{{ __('label.protein') }}</label>
                                            </div>
                                            @error('protein') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.bone_mass') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="bone_mass" name="bone_mass"
                                                    placeholder="{{ __('label.bone_mass') }}" type="number" step="0.1"
                                                    value="{{ old('bone_mass', $measurement->bone_mass) }}" />
                                                <label for="bone_mass"><i
                                                        class="ri-hand-coin-line"></i>{{ __('label.bone_mass') }}</label>
                                            </div>
                                            @error('bone_mass') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.bmr') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="bmr" name="bmr"
                                                    placeholder="{{ __('label.bmr') }}" type="number" step="1"
                                                    value="{{ old('bmr', $measurement->bmr) }}" />
                                                <label for="bmr"><i class="ri-fire-line"></i>{{ __('label.bmr') }}</label>
                                            </div>
                                            @error('bmr') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.waist') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="waist" name="waist"
                                                    placeholder="{{ __('label.waist') }}" type="number" step="0.1"
                                                    value="{{ old('waist', $measurement->waist) }}" />
                                                <label for="waist"><i
                                                        class="ri-ruler-2-line"></i>{{ __('label.waist') }}</label>
                                            </div>
                                            @error('waist') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.hip') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="hip" name="hip"
                                                    placeholder="{{ __('label.hip') }}" type="number" step="0.1"
                                                    value="{{ old('hip', $measurement->hip) }}" />
                                                <label for="hip"><i
                                                        class="ri-ruler-2-line"></i>{{ __('label.hip') }}</label>
                                            </div>
                                            @error('hip') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="label fs-16 mb-2">{{ __('label.whr') }}</label>
                                            <div class="form-floating">
                                                <input class="form-control" id="whr" name="whr"
                                                    placeholder="{{ __('label.whr') }}" type="number" step="0.01"
                                                    value="{{ old('whr', $measurement->whr) }}" />
                                                <label for="whr"><i
                                                        class="ri-calculator-line"></i>{{ __('label.whr') }}</label>
                                            </div>
                                            @error('whr') <div class="text-danger mt-1">{{ $message }}</div> @enderror
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
                                    <div class="d-flex gap-2 justify-content-center mt-2">
                                        <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                            data-processing-text="{{ __('button.processing') }}">
                                            <span id="btnText">{{ __('button.update') }}</span>
                                            <span id="btnLoading"
                                                class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                        </button>
                                        <a href="{{ route('admin.measurements.index') }}"
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
    <script src="{{ asset('assets/js/custom/common.js') }}"></script>
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
                        @if ($measurement->attachment_url)
                                                {
                                source: '{{ asset($measurement->attachment_url) }}',
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