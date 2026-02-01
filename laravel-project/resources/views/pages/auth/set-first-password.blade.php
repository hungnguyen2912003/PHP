@extends('layouts.auth-layout')

@section('title', __('messages.set_first_password_title'))

@section('content')
    <div class="text-center mb-4">
        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
            {{ __('messages.set_first_password_heading') }}
        </h3>
        <p class="fs-16 text-body lh-1-8 mx-auto">
            {{ __('messages.set_first_password_desc') }}
        </p>
    </div>
    <form id="setFirstPasswordForm" action="{{ route('activate.password', $token) }}" method="POST">
        @csrf
        <div class="mb-20">
            <label class="label fs-16 mb-2">{{ __('messages.username') }} <span class="text-danger">*</span></label>
            <div class="form-floating">
                <input class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="{{ __('messages.enter_username') }}"
                    type="text" value="{{ $username }}" readonly />
                <label for="username"><i class="ri-user-line mr-2"></i> {{ __('messages.enter_username') }}</label>
            </div>
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">{{ __('messages.email') }} <span class="text-danger">*</span></label>
            <div class="form-floating">
                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="{{ __('messages.enter_email') }}"
                    type="email" value="{{ $email }}" readonly />
                <label for="email"><i class="ri-mail-line mr-2"></i> {{ __('messages.enter_email') }}</label>
            </div>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('messages.password_label') }} <span class="text-danger">*</span>
            </label>
            <div class="form-group" id="password-show-hide">
                <div class="password-wrapper position-relative password-container form-floating">
                    <input class="form-control text-secondary password @error('password') is-invalid @enderror" placeholder="{{ __('messages.enter_password') }}"
                        type="password" name="password" id="password" />
                    <label for="password">{{ __('messages.enter_password') }}</label>
                    <i aria-hidden="true"
                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                        style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                    </i>
                </div>
            </div>
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('messages.confirm_password_label') }} <span class="text-danger">*</span>
            </label>
            <div class="form-group" id="password-show-hide">
                <div class="password-wrapper position-relative password-container form-floating">
                    <input class="form-control text-secondary password @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('messages.confirm_password_label') }}"
                        type="password" name="password_confirmation" id="password_confirmation" />
                    <label for="password_confirmation">{{ __('messages.confirm_password') }}</label>
                    <i aria-hidden="true"
                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                        style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                    </i>
                </div>
            </div>
        </div>
        <div class="mb-20">
            <button class="btn btn-primary fw-normal text-white w-100" id="submitBtn" data-processing-text="{{ __('messages.processing') }}"
                style="padding-top: 18px; padding-bottom: 18px;" type="submit">
                <span id="btnText">{{ __('messages.set_first_password_btn') }}</span>
                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
            </button>
        </div>
        <a class="text-decoration-none fs-16 text-primary d-flex align-items-center gap-1 justify-content-center"
            href="{{ route('login') }}">
            <i class="ri-arrow-left-s-line fs-22 position-relative top-2">
            </i>
            <span>
                {{ __('messages.back_to_sign_in') }}
            </span>
        </a>
    </form>
@endsection
