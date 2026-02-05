@extends('admin.layouts.app-layout')

@section('title', __('title.create_role'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.create_role') }}
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
                        <span>{{ __('breadcrumb.role_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.create_role') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="addRoleForm" action="{{ route('admin.roles.store') }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.role_information') }}
                        </h3>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('label.name') }}</label>
                                    <div class="form-floating">
                                        <input class="form-control" id="name" name="name"
                                            placeholder="{{ __('placeholder.role_name') }}" type="text"
                                            value="{{ old('name') }}" />
                                        <label for="name"><i
                                                class="ri-shield-user-line"></i>{{ __('placeholder.role_name') }}</label>
                                    </div>
                                    @error('name')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                        data-processing-text="{{ __('button.sending') }}">
                                        <span id="btnText">{{ __('button.add') }}</span>
                                        <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
                                    </button>
                                    <a href="{{ route('admin.roles.index') }}" class="btn btn-danger fw-normal text-white">
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
    <script src="{{ asset('assets/js/custom/auth.js') }}"></script>
@endpush
