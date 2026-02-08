@extends('client.layouts.auth-layout')

@section('title', __('auth.login_title'))

@section('content')
    <div class="text-center mb-4 mt-5">
        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px">
            {{ __('auth.login_title') }}
        </h3>
        <p class="fs-16 text-secondary lh-1-8">
            {{ __('auth.no_account') }}
            <a class="text-primary text-decoration-none" href="{{ route('client.register') }}">
                {{ __('auth.sign_up') }}
            </a>
        </p>
    </div>
    <form action="{{ route('client.login.post') }}" method="POST" id="common-form">
        @csrf
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('label.username') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-floating">
                <input class="form-control @error('login') is-invalid @enderror" id="login"
                    placeholder="{{ __('placeholder.username_or_email') }}" type="text" name="login" />
                <label for="login">
                    <i class="ri-user-line"></i>
                    {{ __('placeholder.username_or_email') }}
                </label>
            </div>
            @error('login')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('label.password') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-group" id="password-show-hide">
                <div class="password-wrapper position-relative password-container form-floating">
                    <input class="form-control text-secondary password @error('password') is-invalid @enderror"
                        placeholder="{{ __('placeholder.enter_password') }}" type="password" name="password"
                        id="password" />
                    <label for="password">
                        <i class="ri-lock-line"></i>
                        {{ __('placeholder.enter_password') }}
                    </label>
                    <i aria-hidden="true"
                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                        style="color: #a9a9c8; font-size: 22px; right: 15px; z-index: 10"></i>
                </div>
            </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                <div class="form-check">
                    <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="" />
                    <label class="form-check-label fs-16" for="flexCheckDefault">
                        {{ __('auth.remember_me') }}
                    </label>
                </div>
                <a class="fs-16 text-primary fw-normal text-decoration-none" href="{{ route('client.forgot-password') }}">
                    {{ __('auth.forgot_password') }}
                </a>
            </div>
        </div>
        <div class="mb-4">
            <button class="btn btn-primary fw-normal text-white w-100" id="submitBtn"
                data-processing-text="{{ __('notification.processing') }}" style="padding-top: 18px; padding-bottom: 18px"
                type="submit">
                <span id="btnText">{{ __('auth.sign_in') }}</span>
                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
            </button>
        </div>
    </form>
@endsection