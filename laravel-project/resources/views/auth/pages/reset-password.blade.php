@extends('auth.layouts.auth-layout')

@section('title', 'Reset Password')

@section('content')
    <div class="main-content d-flex flex-column p-0">
        <div class="m-lg-auto my-auto w-930 py-4">
            <div class="card bg-white border rounded-10 border-white py-100 px-130">
                <div class="p-md-5 p-4 p-lg-0">
                    <div class="text-center mb-4">
                        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
                            Reset Password?
                        </h3>
                        <p class="fs-16 text-body lh-1-8 mx-auto">
                            Enter your new password and confirm it another time in the field below.
                        </p>
                    </div>
                    <form id="form" action="{{ route('password.update', $token) }}" method="POST">
                        @csrf
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">Username <span class="text-danger">*</span></label>
                            <div class="form-floating">
                                <input class="form-control @error('username') is-invalid @enderror" name="username" id="username" placeholder="Enter your username"
                                    type="text" value="{{ $username }}" readonly />
                                <label for="username">Enter your username</label>
                            </div>
                            @error('username')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">Email Address <span class="text-danger">*</span></label>
                            <div class="form-floating">
                                <input class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter your email address"
                                    type="email" value="{{ $email }}" readonly />
                                <label for="email">Enter your email address</label>
                            </div>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="form-group" id="password-show-hide">
                                <div class="password-wrapper position-relative password-container form-floating">
                                    <input class="form-control text-secondary password @error('password') is-invalid @enderror" placeholder="Enter password *"
                                        type="password" name="password" id="password" />
                                    <label for="password">Enter new password</label>
                                    <i aria-hidden="true"
                                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                                        style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                Confirm Password <span class="text-danger">*</span>
                            </label>
                            <div class="form-group" id="password-show-hide">
                                <div class="password-wrapper position-relative password-container form-floating">
                                    <input class="form-control text-secondary password @error('password_confirmation') is-invalid @enderror" placeholder="Enter password *"
                                        type="password" name="password_confirmation" id="password_confirmation" />
                                    <label for="password_confirmation">Confirm new password</label>
                                    <i aria-hidden="true"
                                        class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                                        style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                                    </i>
                                </div>
                            </div>
                        </div>
                        <div class="mb-20">
                            <button class="btn btn-primary fw-normal text-white w-100" id="submitBtn"
                                style="padding-top: 18px; padding-bottom: 18px;" type="submit">
                                <span id="btnText">Reset Password</span>
                                <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
                            </button>
                        </div>
                        <a class="text-decoration-none fs-16 text-primary d-flex align-items-center gap-1 justify-content-center"
                            href="{{ route('login') }}">
                            <i class="ri-arrow-left-s-line fs-22 position-relative top-2">
                            </i>
                            <span>
                                Back to Sign In
                            </span>
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection