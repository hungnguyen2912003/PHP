@extends('client.layouts.client-layout')

@section('title', 'Change Password')

@section('content')

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">Settings</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a class="d-flex align-items-center text-decoration-none" href="index.html">
                    <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                    <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li aria-current="page" class="breadcrumb-item active">
                    <span class="text-secondary">Change Password</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="card bg-white border border-white rounded-10 p-20 mb-4">
        <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="{{ route('setting.account') }}">Account Settings</a>
            </li>
            <li>
                <a class="btn btn-primary border-primary bg-primary text-white fs-16 fw-normal px-3 px-lg-4" href="{{ route('setting.change-password') }}">Change Password</a>
            </li>
        </ul>
        <form action="{{ route('setting.change-password.update') }}" method="POST" id="password-show-hide">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Old Password</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="old_password" class="form-control text-secondary password @error('old_password') is-invalid @enderror" placeholder="Enter old password" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('old_password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">New Password</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="password" class="form-control text-secondary password @error('password') is-invalid @enderror" placeholder="Enter new password" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                        @error('password')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Confirm New Password</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input name="password_confirmation" class="form-control text-secondary password" placeholder="Enter confirm password" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex gap-2 justify-content-center">
                        <button class="btn btn-primary fw-normal text-white" type="submit">Change Password</button>
                        <a href="{{ route('setting.account') }}" class="btn btn-danger fw-normal text-white">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
