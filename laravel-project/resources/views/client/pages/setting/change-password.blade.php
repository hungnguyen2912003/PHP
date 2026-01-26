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
                    <span class="text-secondary">Settings</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="card bg-white border border-white rounded-10 p-20 mb-4">
        <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="account-settings.html">Account Settings</a>
            </li>
            <li>
                <a class="btn btn-primary border-primary bg-primary text-white fs-16 fw-normal px-3 px-lg-4" href="change-password.html">Change Password</a>
            </li>
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="connections.html">
                Connections
                </a>
            </li>
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="privacy-policy.html">Privacy Policy</a>
            </li>
            <li>
                <a class="btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal px-3 px-lg-4" href="terms-conditions.html">Terms &amp; Conditions</a>
            </li>
        </ul>
        <form id="password-show-hide">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Old Password</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input class="form-control text-secondary password" placeholder="Enter old password" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">New Password</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input class="form-control text-secondary password" placeholder="Enter new password" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="mb-20">
                        <label class="label fs-16 mb-2">Confirm</label>
                        <div class="form-group">
                            <div class="password-wrapper position-relative password-container">
                                <input class="form-control text-secondary password" placeholder="Enter confirm password" type="password"/>
                                <i aria-hidden="true" class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary" style="color: #A9A9C8; font-size: 22px; right: 15px;">
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary fw-normal text-white" type="button">Updated Profile</button>
                        <button class="btn btn-danger fw-normal text-white" data-bs-dismiss="modal" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
