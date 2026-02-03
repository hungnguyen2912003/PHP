@extends('client.layouts.auth-layout')

@section('title', __('auth.register_title'))

@section('content')
    <div class="text-center mb-4 mt-5">
        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px">
            {{ __('auth.register_title') }}
        </h3>
        <p class="fs-16 text-secondary lh-1-8">
            {{ __('auth.already_have_account') }}
            <a class="text-primary text-decoration-none" href="{{ route('client.login') }}">
                {{ __('auth.sign_in_link') }}
            </a>
        </p>
    </div>
    <form action="{{ route('client.register.post') }}" method="POST" id="registerForm">
        @csrf
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('label.full_name') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-floating">
                <input
                    class="form-control @error('fullname') is-invalid @enderror"
                    name="fullname"
                    id="fullname"
                    placeholder="{{ __('placeholder.full_name') }}"
                    type="text"
                    value="{{ old('fullname') }}"
                />
                <label for="fullname">
                    <i class="ri-user-line"></i>
                    {{ __('placeholder.full_name') }}
                </label>
            </div>
            @error('fullname')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('label.username') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-floating">
                <input
                    class="form-control @error('username') is-invalid @enderror"
                    name="username"
                    id="username"
                    placeholder="{{ __('placeholder.username') }}"
                    type="text"
                    value="{{ old('username') }}"
                />
                <label for="username">
                    <i class="ri-user-line"></i>
                    {{ __('placeholder.username') }}
                </label>
            </div>
            @error('username')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('label.email') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-floating">
                <input
                    class="form-control @error('email') is-invalid @enderror"
                    name="email"
                    id="email"
                    placeholder="{{ __('placeholder.email') }}"
                    type="email"
                    value="{{ old('email') }}"
                />
                <label for="email">
                    <i class="ri-mail-line"></i>
                    {{ __('placeholder.email') }}
                </label>
            </div>
            @error('email')
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
                    <input
                        class="form-control text-secondary password @error('password') is-invalid @enderror"
                        name="password"
                        id="password"
                        placeholder="{{ __('placeholder.enter_password') }}"
                        type="password"
                    />
                    <label for="password">
                        <i class="ri-lock-line"></i>
                        {{ __('placeholder.enter_password') }}
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
            <label class="label fs-16 mb-2">
                {{ __('label.new_password_confirmation') }}
                <span class="text-danger">*</span>
            </label>
            <div class="form-group" id="password-show-hide-confirm">
                <div class="password-wrapper position-relative password-container form-floating">
                    <input
                        class="form-control text-secondary password @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="{{ __('placeholder.new_password_confirmation') }}"
                        type="password"
                    />
                    <label for="password_confirmation">
                        <i class="ri-lock-line"></i>
                        {{ __('placeholder.new_password_confirmation') }}
                    </label>
                    <i
                        aria-hidden="true"
                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                        style="color: #a9a9c8; font-size: 22px; right: 15px; z-index: 10"
                    ></i>
                </div>
            </div>
            @error('password_confirmation')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="mb-4">
            <button
                class="btn btn-primary fw-normal text-white w-100"
                id="submitBtn"
                data-processing-text="{{ __('notification.processing') }}"
                style="padding-top: 18px; padding-bottom: 18px"
                type="submit"
            >
                <span id="btnText">{{ __('auth.sign_up') }}</span>
                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
            </button>
        </div>
    </form>
@endsection
