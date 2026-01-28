@extends('layouts.app-layout')

@section('title', __('messages.change_password'))

@section('content')

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">{{ __('messages.settings_page_title') }}</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a class="d-flex align-items-center text-decoration-none" href="index.html">
                    <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                    <span class="text-body fs-14 hover">{{ __('messages.profile_breadcrumb_dashboard') }}</span>
                    </a>
                </li>
                <li aria-current="page" class="breadcrumb-item active">
                    <span class="text-secondary">{{ __('messages.change_password') }}</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="card bg-white border border-white rounded-10 p-20 mb-4">
        <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="{{ route('setting.account') }}">{{ __('messages.account_settings') }}</a>
            </li>
            <li>
                <a class="btn btn-primary border-primary bg-primary text-white fs-16 fw-normal px-3 px-lg-4" href="{{ route('setting.change-password') }}">{{ __('messages.change_password') }}</a>
            </li>
        </ul>
        <form action="{{ route('setting.change-password.update') }}" method="POST" id="password-show-hide">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">{{ __('messages.old_password') }}</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="old_password" class="form-control text-secondary password @error('old_password') is-invalid @enderror" placeholder="{{ __('messages.enter_old_password') }}" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('old_password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">{{ __('messages.new_password') }}</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="password" class="form-control text-secondary password @error('password') is-invalid @enderror" placeholder="{{ __('messages.enter_new_password') }}" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">{{ __('messages.confirm_new_password') }}</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="password_confirmation" class="form-control text-secondary password" placeholder="{{ __('messages.enter_confirm_password') }}" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary fw-normal text-white" type="submit">{{ __('messages.change_password_btn') }}</button>
                        <a href="{{ route('setting.account') }}" class="btn btn-danger fw-normal text-white">{{ __('messages.cancel_btn') }}</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
