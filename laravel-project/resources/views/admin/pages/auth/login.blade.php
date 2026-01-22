@extends('admin.layouts.auth-layout')

@section('title', 'Login')

@section('content')
<div class="main-content d-flex flex-column p-0">
    <div class="m-lg-auto my-auto w-930 py-4">
        <div class="card bg-white border rounded-10 border-white py-100 px-130">
            <div class="p-md-5 p-4 p-lg-0">
                <div class="text-center mb-4">
                    <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
                        Sign In
                    </h3>
                    <p class="fs-16 text-secondary lh-1-8">
                        Don't have an account yet?
                        <a class="text-primary text-decoration-none" href="{{ route('admin.register') }}">
                        Sign Up
                        </a>
                    </p>
                </div>
                <form>
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">
                        Email Address
                        </label>
                        <div class="form-floating">
                            <input class="form-control" id="floatingInput1" placeholder="Enter email address *" type="email"/>
                            <label for="floatingInput1">
                            Enter email address *
                            </label>
                        </div>
                    </div>
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">
                        Your Password
                        </label>
                        <div class="form-group" id="password-show-hide">
                            <div class="password-wrapper position-relative password-container">
                                <input class="form-control text-secondary password" placeholder="Enter password *" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                    </div>
                    <div class="mb-20">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                            <div class="form-check">
                                <input class="form-check-input" id="flexCheckDefault" type="checkbox" value=""/>
                                <label class="form-check-label fs-16" for="flexCheckDefault">
                                Remember me
                                </label>
                            </div>
                            <a class="fs-16 text-primary fw-normal text-decoration-none" href="forgot-password.html">
                            Forgot Password?
                            </a>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button class="btn btn-primary fw-normal text-white w-100" style="padding-top: 18px; padding-bottom: 18px;" type="button">
                        Sign In
                        </button>
                    </div>
                    <div class="position-relative text-center z-1 mb-12">
                        <span class="fs-16 bg-white px-4 text-secondary card d-inline-block border-0">
                        or sign in with
                        </span>
                        <span class="d-block border-bottom border-2 position-absolute w-100 z-n1" style="top: 13px;">
                        </span>
                    </div>
                    <ul class="p-0 mb-0 list-unstyled d-flex justify-content-center" style="gap: 10px;">
                        <li>
                            <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16" href="https://www.facebook.com/" style="width: 30px; height: 30px; line-height: 30px; background-color: #3a559f;" target="_blank">
                            <i class="ri-facebook-fill">
                            </i>
                            </a>
                        </li>
                        <li>
                            <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16" href="https://www.twitter.com/" style="width: 30px; height: 30px; line-height: 30px; background-color: #0f1419;" target="_blank">
                            <i class="ri-twitter-x-line">
                            </i>
                            </a>
                        </li>
                        <li>
                            <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16" href="https://www.google.com/" style="width: 30px; height: 30px; line-height: 30px; background-color: #e02f2f;" target="_blank">
                            <i class="ri-google-fill">
                            </i>
                            </a>
                        </li>
                        <li>
                            <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16" href="https://www.linkedin.com/" style="width: 30px; height: 30px; line-height: 30px; background-color: #007ab9;" target="_blank">
                            <i class="ri-linkedin-fill">
                            </i>
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection