@extends('admin.layouts.auth-layout')

@section('title', __('auth.forgot_password_title'))

@section('content')
    <div class="text-center mb-4">
        <h3 class="fs-26 fw-medium mb-1">
            {{ __('auth.forgot_password_title') }}
        </h3>
        <p class="fs-16 text-body lh-1-8 mx-auto" style="max-width: 490px">
            {{ __('auth.forgot_password_desc') }}
        </p>
    </div>

    <form action="{{ route('admin.forgot-password.post') }}" method="POST" id="common-form">
        @csrf

        <div class="mb-20">
            <label class="label fs-16 mb-2">
                {{ __('label.email') }}
                <span class="text-danger">*</span>
            </label>

            <div class="form-floating">
                <input class="form-control @error('email') is-invalid @enderror" id="email"
                    placeholder="{{ __('placeholder.email') }}" type="email" name="email" value="{{ old('email') }}" />
                <label for="email">
                    <i class="ri-mail-line mr-2"></i>
                    {{ __('placeholder.email') }}
                </label>
            </div>

            @error('email')
                <span class="text-danger mt-2">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-20">
            <button class="btn btn-primary fw-normal text-white w-100" id="submitBtn"
                data-processing-text="{{ __('notification.processing') }}" style="padding-top: 18px; padding-bottom: 18px"
                type="submit">
                <span id="btnText">{{ __('auth.send_reset_link') }}</span>
                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
            </button>
        </div>

        <a class="text-decoration-none fs-16 text-primary d-flex align-items-center gap-1 justify-content-center"
            href="{{ route('admin.login') }}">
            <i class="ri-arrow-left-s-line fs-22 position-relative top-2"></i>
            <span>{{ __('button.back_to_login') }}</span>
        </a>
    </form>
@endsection