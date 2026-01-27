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
                        <button id="resend-activation-btn" class="btn btn-warning text-white fw-normal fs-16 hover-bg" style="padding: 12px 15px;" >
                            <i class="ri-error-warning-line"></i> <span id="resend-text">Activate your account</span>
                        </button>
                        @endif

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const resendBtn = document.getElementById('resend-activation-btn');
                                if (!resendBtn) return;

                                const resendText = document.getElementById('resend-text');
                                const cooldownKey = 'activation_resend_cooldown_{{ $user->id }}';
                                let cooldownInterval;

                                function updateTimerDisplay(remainingSeconds) {
                                    const minutes = Math.floor(remainingSeconds / 60);
                                    const seconds = remainingSeconds % 60;
                                    resendText.innerText = `Resend in ${minutes}:${seconds.toString().padStart(2, '0')}`;
                                    resendBtn.disabled = true;
                                }

                                function startTimer(seconds) {
                                    const endTime = Date.now() + seconds * 1000;
                                    localStorage.setItem(cooldownKey, endTime);

                                    clearInterval(cooldownInterval);
                                    updateTimerDisplay(seconds);

                                    cooldownInterval = setInterval(() => {
                                        const remaining = Math.round((endTime - Date.now()) / 1000);
                                        if (remaining <= 0) {
                                            clearInterval(cooldownInterval);
                                            resendText.innerText = 'Activate your account';
                                            resendBtn.disabled = false;
                                            localStorage.removeItem(cooldownKey);
                                        } else {
                                            updateTimerDisplay(remaining);
                                        }
                                    }, 1000);
                                }

                                // Check for existing cooldown on load
                                const storedEndTime = localStorage.getItem(cooldownKey);
                                if (storedEndTime) {
                                    const remaining = Math.round((storedEndTime - Date.now()) / 1000);
                                    if (remaining > 0) {
                                        startTimer(remaining);
                                    } else {
                                        localStorage.removeItem(cooldownKey);
                                    }
                                }

                                resendBtn.addEventListener('click', function() {
                                    resendBtn.disabled = true;
                                    resendText.innerText = 'Sending...';

                                    fetch("{{ route('resend-activation') }}", {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        }
                                    })
                                    .then(response => response.json().then(data => ({ status: response.status, body: data })))
                                    .then(res => {
                                        if (res.status === 200) {
                                            flash('success', res.body.message);
                                            startTimer(300); // 5 minutes
                                        } else if (res.status === 429) {
                                            flash('warning', res.body.message);
                                            startTimer(Math.round(res.body.remaining_seconds));
                                        } else {
                                            flash('error', res.body.message || 'Something went wrong.');
                                            resendBtn.disabled = false;
                                            resendText.innerText = 'Activate your account';
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        resendBtn.disabled = false;
                                        resendText.innerText = 'Activate your account';
                                    });
                                });

                                function flash(type, message) {
                                    // Custom simple flash if library not globally available for JS
                                    if (window.Toastify) {
                                        Toastify({
                                            text: message,
                                            backgroundColor: type === 'success' ? 'green' : (type === 'warning' ? 'orange' : 'red'),
                                        }).showToast();
                                    } else {
                                        alert(message);
                                    }
                                }
                            });
                        </script>
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