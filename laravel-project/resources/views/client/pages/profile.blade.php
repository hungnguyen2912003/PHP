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
                </div>
            </div>
            <div class="card border-0 rounded-10 p-20 pb-0 rounded-top-0 profile-info" style="background-color: transparent !important;">
                <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
                    <div class="d-flex align-items-end">
                        <div class="flex-shrink-0 position-relative">
                            <form id="avatarForm" action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="avatar-upload">
                                    <div class="avatar-edit" data-bs-placement="top" data-bs-title="Change Avatar" data-bs-toggle="tooltip">
                                        <input type="file" name="avatar_url_file" id="avatarInput" accept="image/*" onchange="document.getElementById('avatarForm').submit();">
                                        <label for="avatarInput"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url({{ $user->avatar_url ? asset($user->avatar_url) : asset('images/user.png') }});">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="flex-grow-1 ms-20 mb-45" style="max-width: 600px;">
                            <h3 class="mb-1">{{ $user->fullname }}</h3>
                            <div class="fs-15 text-wrap">
                                <span class="text-secondary">Bio:</span> {{ $user->bio ?? 'No bio available' }}
                            </div>
                        </div>
                    </div>                    
                    <div class="d-flex align-items-center mb-sm-4 gap-2">
                        @if($user->status === 'pending')
                        <button id="resend-activation-btn" 
                                class="btn btn-warning text-white fw-normal fs-16 hover-bg" 
                                style="padding: 12px 15px;"
                                data-user-id="{{ $user->id }}"
                                data-route="{{ route('resend-activation') }}"
                                data-csrf="{{ csrf_token() }}">
                            <i class="ri-error-warning-line"></i> <span id="resend-text">Activate your account</span>
                            <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
                        </button>
                        @endif

                        <a href="{{ route('setting.account') }}" class="btn btn-outline-border-color-70 text-secondary fw-normal fs-16 hover-bg" style="padding: 12px 15px;" >
                            Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-xxl-4 col-xxxl-12">
            <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                <h3 class="mb-20">
                    Profile Information
                </h3>
                <ul class="p-0 mb-0 list-unstyled last-child-none">
                    <li class="mb-10 fs-16">
                        Full Name:
                        <span class="text-secondary">
                            {{ $user->fullname }}
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Date of birth:
                        <span class="text-secondary">
                            @if ($user->date_of_birth)
                                {{ $user->date_of_birth }}
                            @else
                                <span class="text-danger">Unknown</span>
                            @endif
                        </span>
                    </li>
                    <li class="mb-10 fs-16">
                        Gender:
                        <span class="text-secondary">
                            @if ($user->gender)
                                {{ ucfirst($user->gender) }}
                            @else
                                <span class="text-danger">Unknown</span>
                            @endif
                        </span>
                    </li>
                </ul>
            </div>    
        </div>
        <div class="col-lg-4 col-xxl-4 col-xxxl-12">
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
        <div class="col-lg-4 col-xxl-4 col-xxxl-12">
            <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                <h3 class="mb-20">
                    Account Information
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
                        Created Date:
                        <span class="text-secondary">
                            {{ $user->created_at->format('d-m-Y') }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
 
    </div>
</div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/client/js/custom/resend-activation.js') }}"></script>
@endpush