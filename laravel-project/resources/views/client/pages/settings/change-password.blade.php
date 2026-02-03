@extends('client.layouts.app-layout')

@section('title', __('title.change_password'))

@section('content')

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">{{ __('title.change_password') }}</h3></h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a class="d-flex align-items-center text-decoration-none" href="index.html">
                    <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                    <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                    </a>
                </li>
                <li aria-current="page" class="breadcrumb-item active">
                    <span class="text-secondary">{{ __('breadcrumb.settings.change_password') }}</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="card bg-white border border-white rounded-10 p-20 mb-4">
        <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="{{ route('client.setting.account') }}">{{ __('title.account') }}</a>
            </li>
            <li>
                <a class="btn btn-primary border-primary bg-primary text-white fs-16 fw-normal px-3 px-lg-4" href="{{ route('client.setting.change-password') }}">{{ __('title.change_password') }}</a>
            </li>
        </ul>
        <form action="{{ route('client.setting.change-password.update') }}" method="POST" id="password-show-hide">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">{{ __('label.current_password') }}</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="current_password" class="form-control text-secondary password @error('current_password') is-invalid @enderror" placeholder="{{ __('placeholder.current_password') }}" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('current_password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">{{ __('label.new_password') }}</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="new_password" class="form-control text-secondary password @error('new_password') is-invalid @enderror" placeholder="{{ __('placeholder.new_password') }}" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('new_password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">{{ __('label.new_password_confirmation') }}</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="new_password_confirmation" class="form-control text-secondary password @error('new_password_confirmation') is-invalid @enderror" placeholder="{{ __('placeholder.new_password_confirmation') }}" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('new_password_confirmation')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary fw-normal text-white" type="submit">{{ __('button.update') }}</button>
                        <a href="{{ route('client.setting.account') }}" class="btn btn-danger fw-normal text-white">{{ __('button.cancel') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
