@extends('admin.layouts.auth-layout')

@section('title', __('admin/pages/auth.reset.title'))

@section('content')
<div class="text-center mb-4">
    <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
        {{ __('admin/pages/auth.reset.title') }}
    </h3>
    <p class="fs-16 text-body lh-1-8 mx-auto">
        {{ __('admin/pages/auth.reset.description') }}
    </p>
</div>
<form id="resetPasswordForm" action="{{ route('admin.password.update', $token) }}" method="POST">
    @csrf
    <div class="mb-20">
        <label class="label fs-16 mb-2">{{ __('admin/pages/auth.username.label') }} <span class="text-danger">*</span></label>
        <div class="form-floating">
            <input class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="{{ __('admin/pages/auth.username.placeholder') }}"
                type="text" value="{{ $username }}" readonly />
            <label for="username"><i class="ri-user-line mr-2"></i> {{ __('admin/pages/auth.username.placeholder') }}</label>
        </div>
        @error('username')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-20">
        <label class="label fs-16 mb-2">{{ __('admin/pages/auth.email.label') }} <span class="text-danger">*</span></label>
        <div class="form-floating">
            <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="{{ __('admin/pages/auth.email.placeholder') }}"
                type="email" value="{{ $email }}" readonly />
            <label for="email"><i class="ri-mail-line mr-2"></i> {{ __('admin/pages/auth.email.placeholder') }}</label>
        </div>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-20">
        <label class="label fs-16 mb-2">
            {{ __('admin/pages/auth.password.label') }} <span class="text-danger">*</span>
        </label>
        <div class="form-group" id="password-show-hide">
            <div class="password-wrapper position-relative password-container form-floating">
                <input class="form-control text-secondary password @error('password') is-invalid @enderror" placeholder="{{ __('admin/pages/auth.password.placeholder') }}"
                    type="password" name="password" id="password" />
                <label for="password">{{ __('admin/pages/auth.password.placeholder') }}</label>
                <i aria-hidden="true"
                    class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                    style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                </i>
            </div>
        </div>
        @error('password')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-20">
        <label class="label fs-16 mb-2">
            {{ __('admin/pages/auth.password_confirmation.label') }} <span class="text-danger">*</span>
        </label>
        <div class="form-group" id="password-show-hide">
            <div class="password-wrapper position-relative password-container form-floating">
                <input class="form-control text-secondary password @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('admin/pages/auth.password_confirmation.placeholder') }}"
                    type="password" name="password_confirmation" id="password_confirmation" />
                <label for="password_confirmation">{{ __('admin/pages/auth.password_confirmation.placeholder') }}</label>
                <i aria-hidden="true"
                    class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                    style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                </i>
            </div>
        </div>
        @error('password_confirmation')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
    <div class="mb-20">
        <button class="btn btn-primary fw-normal text-white w-100" id="submitBtn" data-processing-text="{{ __('common.processing') }}"
            style="padding-top: 18px; padding-bottom: 18px;" type="submit">
            <span id="btnText">{{ __('admin/pages/auth.reset.submit') }}</span>
            <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
        </button>
    </div>
    <a class="text-decoration-none fs-16 text-primary d-flex align-items-center gap-1 justify-content-center"
        href="{{ route('admin.login') }}">
        <i class="ri-arrow-left-s-line fs-22 position-relative top-2">
        </i>
        <span>
            {{ __('common.back_to_login') }}
        </span>
    </a>
</form>
@endsection
