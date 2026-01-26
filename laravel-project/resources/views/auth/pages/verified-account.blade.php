@extends('auth.layouts.auth-layout')

@section('title', 'Verified Account')

@section('content')
    <div class="main-content d-flex flex-column p-0">
        <div class="m-lg-auto my-auto w-930 py-4">
            <div class="card bg-white border rounded-10 border-white py-100 px-130">
                <div class="p-md-5 p-4 p-lg-0">
                    <div class="text-center mb-4">
                        <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
                            Welcome To Our Website
                        </h3>
                        <p class="fs-16 text-body lh-1-8 mx-auto">
                            Your account is activated! You can now login to your account.
                        </p>
                    </div>
                    <div>
                        <div class="mb-20">
                            <div class="d-flex justify-content-center align-items-center for-dark-bg-light bg-light rounded-circle mx-auto"
                                style="width: 200px; height: 200px;">
                                <img src="{{ asset('images/hero.png') }}" alt="Verified Account"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                            </div>
                        </div>
                        <h3 class="mb-30 text-center">
                            Your Account Activated
                            <span class="text-success">
                                Successfully!
                            </span>
                        </h3>
                        <div>
                            <a class="btn btn-primary fw-normal text-white w-100" href="{{ route('login') }}"
                                style="padding-top: 18px; padding-bottom: 18px;">
                                Back To Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection