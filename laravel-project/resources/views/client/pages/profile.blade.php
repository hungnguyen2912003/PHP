@extends('client.layouts.client-layout')

@section('title', 'Profile')

@section('content')

<div class="main-content-container overflow-hidden">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
        <h3 class="mb-0">User Profile</h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a class="d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">Dashboard</span>
                    </a>
                </li>
                <li aria-current="page" class="breadcrumb-item active">
                    <span>Profile</span>
                </li>
                <li aria-current="page" class="breadcrumb-item active">
                    <span class="text-secondary">User Profile</span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="social-profile">
        <div class="card border-0 bg-white rounded-10 mb-4">
            <div class="position-relative">
                <img alt="profile-cover" class="rounded-top-3 w-100" src="{{ asset('assets/client/images/profile-big-cover.jpg') }}"/>
                <div class="position-absolute z-1" style="bottom: 20px; right: 20px;">
                    {{-- <button class="btn btn-primary text-white fs-16 fw-normal hover rounded-1" style="padding: 14px 26px;">
                        Edit Cover Photo
                    </button> --}}
                </div>
            </div>
            <div class="card border-0 rounded-10 p-20 pb-0 rounded-top-0 profile-info" style="background-color: transparent !important;">
                <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
                    <div class="d-flex align-items-end">
                        <div class="flex-shrink-0 position-relative">
                            <div class="avatar-upload">
                                <div class="avatar-edit" data-bs-placement="top" data-bs-title="Image Size (190x190)" data-bs-toggle="tooltip">
                                    <input accept=".png, .jpg, .jpeg" id="imageUpload" type="file">
                                    <label for="imageUpload"></label>
                                    </input>
                                </div>
                                <div class="avatar-preview">
                                    <div id="imagePreview" style="background-image: url({{ asset('images/user.png') }});">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-20 mb-45">
                            <h3 class="mb-1">{{ $user->name }}</h3>
                            <span class="fs-16">
                                <a href="mailto:{{ $user->email }}">
                                    {{ $user->email }}
                                </a>
                            </span>
                        </div>
                    </div>                    
                    <div class="d-flex align-items-center mb-sm-4 gap-2">
                        @if($user->status === 'pending')
                        <a href="" class="btn btn-warning text-white fw-normal fs-16 hover-bg" style="padding: 12px 15px;" >
                            <i class="ri-error-warning-line"></i> Activate your account
                        </a>
                        @endif
                        <a href="{{ route('setting.index') }}" class="btn btn-outline-border-color-70 text-secondary fw-normal fs-16 hover-bg" style="padding: 12px 15px;" >
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xxl-4 col-xxxl-12">
            <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                <h3 class="mb-20">
                    Profile Information
                </h3>
                <ul class="p-0 mb-0 list-unstyled last-child-none">
                    <li class="mb-10 fs-16">
                        Full Name:
                        <span class="text-secondary">
                            {{ $user->name }}
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Role:
                        <span class="text-secondary">
                            {{ $user->role->name }}
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Birth Date:
                        <span class="text-secondary">
                            @if ($user->birth_date)
                                {{ $user->birth_date }}
                            @else
                                <span class="text-danger">Unknown</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>    
        </div>
        <div class="col-xxl-4 col-xxxl-12">
            <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                <h3 class="mb-20">
                    Additional Information
                </h3>
                <ul class="p-0 mb-0 list-unstyled last-child-none">
                    <li class="mb-10 fs-16">
                        Username:
                        <span class="text-secondary">
                        {{ $user->username }}
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Status:
                        <span class="text-secondary">
                            @if ($user->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @elseif ($user->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif ($user->status == 'banned')
                                <span class="badge bg-danger">Banned</span>
                            @else
                                <span class="badge bg-secondary">Deleted</span>
                            @endif
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Join Date:
                        <span class="text-secondary">
                            {{ $user->created_at->format('d-m-Y') }}
                        </span>
                    </li>
                </ul>
            </div>
        </div> 
        <div class="col-xxl-4 col-xxxl-12">
            <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                <h3 class="mb-20">
                    Contact Information
                </h3>
                <ul class="p-0 mb-0 list-unstyled last-child-none">
                    <li class="mb-10 fs-16">
                        Email:
                        <span class="text-secondary">
                        {{ $user->email }}
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Phone:
                        <span class="text-secondary">
                            @if ($user->phone)
                                {{ $user->phone }}
                            @else
                                <span class="text-danger">Unknown</span>
                            @endif
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Address:
                        <span class="text-secondary">
                            @if ($user->address)
                                {{ $user->address }}
                            @else
                                <span class="text-danger">Unknown</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection