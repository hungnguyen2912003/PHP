@extends('admin.layouts.app-layout')

@section('title', __('title.create_user'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.create_user') }}
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
                        <span>{{ __('breadcrumb.user_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.create_user') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="common-form" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.profile_information') }}
                        </h3>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.full_name') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" id="fullname" name="fullname"
                                            placeholder="{{ __('placeholder.full_name') }}" type="text"
                                            value="{{ old('fullname') }}" />
                                        <label for="fullname"><i
                                                class="ri-user-line"></i>{{ __('placeholder.full_name') }}</label>
                                    </div>
                                    @error('fullname')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.email') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" id="email" name="email"
                                            placeholder="{{ __('placeholder.email') }}" type="email"
                                            value="{{ old('email') }}" />
                                        <label for="email"><i
                                                class="ri-mail-line"></i>{{ __('placeholder.email') }}</label>
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.role') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <select class="form-select form-control" id="role" name="role">
                                            <option value="">{{ __('placeholder.role') }}</option>
                                            @foreach(['admin', 'staff'] as $roleName)
                                                <option value="{{ $roleName }}" {{ old('role') == $roleName ? 'selected' : '' }}>
                                                    {{ __('value.role.' . $roleName) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="role">{{ __('placeholder.role') }}</label>
                                    </div>
                                    @error('role')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                        data-processing-text="{{ __('button.processing') }}">
                                        <span id="btnText">{{ __('button.add') }}</span>
                                        <span id="btnLoading" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-danger fw-normal text-white">
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