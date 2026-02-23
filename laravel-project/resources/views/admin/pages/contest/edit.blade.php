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
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.contest_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" id="name" name="name"
                                            placeholder="{{ __('placeholder.contest_name') }}" type="text"
                                            value="{{ old('name', $contest->name) }}" required />
                                        <label for="name">{{ __('placeholder.contest_name') }}</label>
                                    </div>
                                    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.type') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" id="type" name="type" type="number"
                                            value="{{ old('type', $contest->type) }}" required />
                                        <label for="type">{{ __('label.type') }}</label>
                                    </div>
                                    @error('type') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.target') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" id="target" name="target" type="number"
                                            value="{{ old('target', $contest->target) }}" required />
                                        <label for="target">{{ __('label.target') }}</label>
                                    </div>
                                    @error('target') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.start_date') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" id="start_date" name="start_date" type="datetime-local"
                                            value="{{ old('start_date', $contest->start_date ? $contest->start_date->format('Y-m-d\TH:i') : '') }}" required />
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
                                        <input class="form-control" id="end_date" name="end_date" type="datetime-local"
                                            value="{{ old('end_date', $contest->end_date ? $contest->end_date->format('Y-m-d\TH:i') : '') }}" required />
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
                                        <select class="form-select form-control" id="status" name="status" required>
                                            <option value="inprogress" {{ old('status', $contest->status) == 'inprogress' ? 'selected' : '' }}>{{ __('value.status.inprogress') }}</option>
                                            <option value="completed" {{ old('status', $contest->status) == 'completed' ? 'selected' : '' }}>{{ __('value.status.completed') }}</option>
                                            <option value="cancelled" {{ old('status', $contest->status) == 'cancelled' ? 'selected' : '' }}>{{ __('value.status.cancelled') }}</option>
                                        </select>
                                        <label for="status">{{ __('label.status') }}</label>
                                    </div>
                                    @error('status') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('label.image') }}</label>
                                    @if($contest->image_url)
                                        <div class="mb-2">
                                            <img src="{{ asset($contest->image_url) }}" alt="Contest Image" width="150" class="img-thumbnail rounded">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control" name="image" accept="image/*">
                                    @error('image') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('label.description') }}</label>
                                    <textarea class="form-control" name="description" rows="4">{{ old('description', $contest->description) }}</textarea>
                                    @error('description') <div class="text-danger mt-1">{{ $message }}</div> @enderror
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
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/common.js') }}"></script>
@endpush
