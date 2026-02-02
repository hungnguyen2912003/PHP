@extends('admin.layouts.auth-layout')

@section('title', __('auth.login.title'))

@section('content')
    <div class="text-center mb-4 mt-5">
        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px">
            {{ __('auth.login.title') }}
        </h3>
        <h4 class="text-muted small mb-4">
            {{ __('auth.login.subtitle') }}
        </h4>
    </div>
    <form action="{{ route('admin.login.post') }}" method="POST" id="loginForm">
        @csrf
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('auth.username.label') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-floating">
                <input
                    class="form-control @error('login') is-invalid @enderror"
                    id="login"
                    placeholder="{{ __('auth.username.placeholder') }}"
                    type="text"
                    name="login"
                />
                <label for="login">
                    <i class="ri-user-line"></i>
                    {{ __('auth.username.placeholder') }}
                </label>
            </div>
            @error('login')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('auth.password.label') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-group" id="password-show-hide">
                <div class="password-wrapper position-relative password-container form-floating">
                    <input
                        class="form-control text-secondary password @error('password') is-invalid @enderror"
                        placeholder="{{ __('auth.password.placeholder') }}"
                        type="password"
                        name="password"
                        id="password"
                    />
                    <label for="password">
                        <i class="ri-lock-line"></i>
                        {{ __('auth.password.placeholder') }}
                    </label>
                    <i
                        aria-hidden="true"
                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                        style="color: #a9a9c8; font-size: 22px; right: 15px; z-index: 10"
                    ></i>
                </div>
            </div>
            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                <div class="form-check">
                    <input
                        class="form-check-input"
                        id="flexCheckDefault"
                        type="checkbox"
                        value=""
                    />
                    <label class="form-check-label fs-16" for="flexCheckDefault">
                        {{ __('auth.login.remember') }}
                    </label>
                </div>
                <a
                    class="fs-16 text-primary fw-normal text-decoration-none"
                    href="{{ route('admin.forgot-password') }}"
                >
                    {{ __('auth.login.forgot') }}
                </a>
            </div>
        </div>
        <div class="mb-4">
            <button
                class="btn btn-primary fw-normal text-white w-100"
                id="submitBtn"
                data-processing-text="{{ __('common.processing') }}"
                style="padding-top: 18px; padding-bottom: 18px"
                type="submit"
            >
                <span id="btnText">{{ __('auth.login.submit') }}</span>
                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
            </button>
        </div>
    </form>
@endsection
