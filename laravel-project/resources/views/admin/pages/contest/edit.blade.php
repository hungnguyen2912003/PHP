@extends('admin.layouts.app-layout')

@section('title', __('title.edit_contest'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.edit_contest') }}
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
                        <span class="text-secondary">{{ __('title.edit_contest') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="common-form" action="{{ route('admin.contests.update', $contest->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('label.contest_information') }}
                        </h3>
                        <div class="row">
                            <div class="col-lg-9">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.contest_name') }} (JA) <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="name_ja" name="name[ja]"
                                                    placeholder="{{ __('placeholder.contest_name') }} (JA)" type="text"
                                                    value="{{ old('name.ja', $contest->getTranslation('name', 'ja', false)) }}" />
                                                <label for="name_ja">{{ __('placeholder.contest_name') }} (JA)</label>
                                            </div>
                                            @error('name.ja') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.contest_name') }} (EN) <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="name_en" name="name[en]"
                                                    placeholder="{{ __('placeholder.contest_name') }} (EN)" type="text"
                                                    value="{{ old('name.en', $contest->getTranslation('name', 'en', false)) }}" />
                                                <label for="name_en">{{ __('placeholder.contest_name') }} (EN)</label>
                                            </div>
                                            @error('name.en') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.contest_name') }} (ZH) <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="name_zh" name="name[zh]"
                                                    placeholder="{{ __('placeholder.contest_name') }} (ZH)" type="text"
                                                    value="{{ old('name.zh', $contest->getTranslation('name', 'zh', false)) }}" />
                                                <label for="name_zh">{{ __('placeholder.contest_name') }} (ZH)</label>
                                            </div>
                                            @error('name.zh') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.type') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <select class="form-select form-control" id="type" name="type">
                                                    <option value="1" {{ old('type', $contest->type) == '1' ? 'selected' : '' }}>{{ __('value.contest_type.walking') }}</option>
                                                    <option value="2" {{ old('type', $contest->type) == '2' ? 'selected' : '' }}>{{ __('value.contest_type.running') }}</option>
                                                    <option value="3" {{ old('type', $contest->type) == '3' ? 'selected' : '' }}>{{ __('value.contest_type.cycling') }}</option>
                                                    <option value="4" {{ old('type', $contest->type) == '4' ? 'selected' : '' }}>{{ __('value.contest_type.swimming') }}</option>
                                                </select>
                                                <label for="type">{{ __('label.type') }}</label>
                                            </div>
                                            @error('type') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.target') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="target" name="target" type="number"
                                                    placeholder="{{ __('placeholder.target') }}"
                                                    value="{{ old('target', $contest->target) }}" />
                                                <label for="target">{{ __('placeholder.target') }}</label>
                                            </div>
                                            @error('target') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.reward_points') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="reward_points" name="reward_points" type="number"
                                                    placeholder="{{ __('placeholder.reward_points') }}"
                                                    value="{{ old('reward_points', $contest->reward_points) }}" />
                                                <label for="reward_points">{{ __('placeholder.reward_points') }}</label>
                                            </div>
                                            @error('reward_points') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.win_limit') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="win_limit" name="win_limit" type="number"
                                                    placeholder="{{ __('placeholder.win_limit') }}"
                                                    value="{{ old('win_limit', $contest->win_limit) }}" />
                                                <label for="win_limit">{{ __('placeholder.win_limit') }}</label>
                                            </div>
                                            @error('win_limit') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.start_date') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="start_date" name="start_date" type="date"
                                                    value="{{ old('start_date', $contest->start_date ? $contest->start_date->format('Y-m-d') : '') }}" />
                                                <label for="start_date">{{ __('label.start_date') }}</label>
                                            </div>
                                            @error('start_date') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.end_date') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <input class="form-control" id="end_date" name="end_date" type="date"
                                                    value="{{ old('end_date', $contest->end_date ? $contest->end_date->format('Y-m-d') : '') }}" />
                                                <label for="end_date">{{ __('label.end_date') }}</label>
                                            </div>
                                            @error('end_date') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">
                                                {{ __('label.status') }} <span class="text-danger">*</span>
                                            </label>
                                            <div class="form-floating">
                                                <select class="form-select form-control" id="status" name="status">
                                                    <option value="{{ \App\Models\Contest::STATUS_INPROGRESS }}" {{ old('status', $contest->status) == \App\Models\Contest::STATUS_INPROGRESS ? 'selected' : '' }}>{{ __('value.status.inprogress') }}</option>
                                                    <option value="{{ \App\Models\Contest::STATUS_COMPLETED }}" {{ old('status', $contest->status) == \App\Models\Contest::STATUS_COMPLETED ? 'selected' : '' }}>{{ __('value.status.completed') }}</option>
                                                    <option value="{{ \App\Models\Contest::STATUS_CANCELLED }}" {{ old('status', $contest->status) == \App\Models\Contest::STATUS_CANCELLED ? 'selected' : '' }}>{{ __('value.status.cancelled') }}</option>
                                                </select>
                                                <label for="status">{{ __('label.status') }}</label>
                                            </div>
                                            @error('status') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('label.image') }}</label>
                                    <div class="border rounded-3 p-3 h-100 d-flex align-items-center justify-content-center">
                                        <div class="w-100">
                                            <input type="file" class="edit-image-filepond" id="image" name="image">
                                            <input type="hidden" name="remove_image" id="remove_image" value="0">
                                            @error('image')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">{{ __('label.description') }} (JA)</label>
                                            <textarea class="form-control" name="description[ja]" placeholder="{{ __('placeholder.description') }} (JA)" rows="4">{{ old('description.ja', $contest->getTranslation('description', 'ja', false)) }}</textarea>
                                            @error('description.ja') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">{{ __('label.description') }} (EN)</label>
                                            <textarea class="form-control" name="description[en]" placeholder="{{ __('placeholder.description') }} (EN)" rows="4">{{ old('description.en', $contest->getTranslation('description', 'en', false)) }}</textarea>
                                            @error('description.en') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="mb-20">
                                            <label class="label fs-16 mb-2">{{ __('label.description') }} (ZH)</label>
                                            <textarea class="form-control" name="description[zh]" placeholder="{{ __('placeholder.description') }} (ZH)" rows="4">{{ old('description.zh', $contest->getTranslation('description', 'zh', false)) }}</textarea>
                                            @error('description.zh') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex gap-2 justify-content-center">
                                            <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                                data-processing-text="{{ __('button.processing') }}">
                                                <span id="btnText">{{ __('button.save') }}</span>
                                                <span id="btnLoading" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                            </button>
                                            <a href="{{ route('admin.contests.index') }}" class="btn btn-danger fw-normal text-white">
                                                {{ __('button.cancel') }}
                                            </a>
                                        </div>
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
            if (typeof FilePond !== 'undefined') {
                if (typeof FilePondPluginImagePreview !== 'undefined') {
                    FilePond.registerPlugin(FilePondPluginImagePreview);
                }
                const inputElement = document.querySelector('.edit-image-filepond');
                if (inputElement) {
                    const pond = FilePond.create(inputElement, {
                    allowImagePreview: true,
                    storeAsFile: true,
                    labelIdle: `{!! __('placeholder.drag_drop_file') !!}`,
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                    files: [
                        @if ($contest->image_url)
                                                {
                                source: '{{ asset($contest->image_url) }}',
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
                    document.getElementById('remove_image').value = '1';
                });

                pond.on('addfile', (error, file) => {
                    document.getElementById('remove_image').value = '0';
                });
            }
        }
        });
    </script>
@endpush