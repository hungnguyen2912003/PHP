@extends('auth.layouts.auth-layout')

@section('title', 'Forgot Password')

@section('content')
    <div class="main-content d-flex flex-column p-0">
        <div class="m-lg-auto my-auto w-930 py-4">
            <div class="card bg-white border rounded-10 border-white py-100 px-130">
                <div class="p-md-5 p-4 p-lg-0">
                    <div class="text-center mb-4">
                        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
                            Forgot Your Password?
                        </h3>
                        <p class="fs-16 text-body lh-1-8 mx-auto" style="max-width: 490px;">
                            Enter the email address you used when you joined and will send you instructions to reset
                            your password.
                        </p>
                    </div>
                    <form action="{{ route('forgot-password.post') }}" method="POST" id="forgotPasswordForm">
                        @csrf
                        <div class="mb-20">
                            <label class="label fs-16 mb-2">
                                Email Address
                            </label>
                            <div class="form-floating">
                                <input class="form-control" id="email" placeholder="Enter email address *" type="email"
                                    name="email" value="{{ old('email') }}" />
                                <label for="email">
                                    Enter email address *
                                </label>
                            </div>
                        </div>
                        <div class="mb-20">
                            <button class="btn btn-primary fw-normal text-white w-100"
                                style="padding-top: 18px; padding-bottom: 18px;" type="submit">
                                Send
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