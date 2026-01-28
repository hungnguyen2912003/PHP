@extends('client.layouts.client-layout')

@section('title', __('messages.profile_page_title'))

@section('content')

    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ __('messages.profile_page_title') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('home') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('messages.profile_breadcrumb_dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('messages.profile_breadcrumb_profile') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('messages.profile_page_title') }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="social-profile">
            <div class="card border-0 bg-white rounded-10 mb-4">
                <div class="position-relative">
                    <img alt="profile-cover" class="rounded-top-3 w-100"
                        src="{{ asset('assets/client/images/profile-big-cover.jpg') }}" />
                    <div class="position-absolute z-1" style="bottom: 20px; right: 20px;">
                    </div>
                </div>
                <div class="card border-0 rounded-10 p-20 pb-0 rounded-top-0 profile-info"
                    style="background-color: transparent !important;">
                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
                        <div class="d-flex align-items-end">
                            <div class="flex-shrink-0 position-relative">
                                <form id="avatarForm" action="{{ route('profile.avatar.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="avatar-upload">
                                        <div class="avatar-edit" data-bs-placement="top"
                                            data-bs-title="{{ __('messages.image_size_hint') }}" data-bs-toggle="tooltip">
                                            <input accept=".png, .jpg, .jpeg" name="avatar_url_file" id="imageUpload"
                                                type="file">
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                style="background-image: url({{ $user->avatar_url ? asset($user->avatar_url) : asset('images/user.png') }});">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="flex-grow-1 ms-20 mb-10" style="max-width: 1000px;">
                                <h3 class="mb-1">{{ $user->fullname }}</h3>
                                <div class="fs-15">
                                    <span class="text-secondary">{{ __('messages.role') }}:</span>
                                    @if ($user->role->name === 'Admin')
                                        {{ __('messages.admin') }}
                                    @elseif ($user->role->name === 'User')
                                        {{ __('messages.user') }}
                                    @endif
                                </div>
                                <div class="fs-15 text-wrap">
                                    <span class="text-secondary">{{ __('messages.bio') }}:</span>
                                    {{ $user->bio ?? __('messages.no_bio') }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-sm-4 gap-2">
                            @if($user->status === 'pending')
                                <form action="{{ route('resend-activation') }}" method="POST" class="d-inline"
                                    id="resendActivationForm">
                                    @csrf
                                    <button id="resend-activation-btn" type="submit"
                                        class="btn btn-warning text-white fw-normal fs-16 hover-bg" style="padding: 12px 15px;">
                                        <i class="ri-error-warning-line"></i> <span
                                            id="btnTextActivation" data-sending-text="{{ __('messages.sending') }}" data-resend-in-text="{{ __('messages.resend_in') }}" data-original-text="{{ __('messages.activate_account') }}">{{ __('messages.activate_account') }}</span>
                                        <span id="btnLoadingActivation"
                                            class="spinner-border spinner-border-sm ml-2 d-none"></span>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('setting.account') }}"
                                class="btn btn-outline-border-color-70 text-secondary fw-normal fs-16 hover-bg"
                                style="padding: 12px 15px;">
                                {{ __('messages.settings') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('messages.profile_information') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('messages.full_name') }}:
                            <span class="text-secondary">
                                {{ $user->fullname }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('messages.date_of_birth') }}:
                            <span class="text-secondary">
                                @if ($user->date_of_birth)
                                    {{ $user->date_of_birth }}
                                @else
                                    <span class="text-danger">{{ __('messages.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('messages.gender') }}:
                            <span class="text-secondary">
                                @if ($user->gender)
                                    @if ($user->gender === 'male')
                                        {{ __('messages.gender_male') }}
                                    @elseif ($user->gender === 'female')
                                        {{ __('messages.gender_female') }}
                                    @else
                                        {{ __('messages.gender_other') }}
                                    @endif
                                @else
                                    <span class="text-danger">{{ __('messages.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('messages.contact_information') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('messages.email') }}:
                            <span class="text-secondary">
                                {{ $user->email }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('messages.phone') }}:
                            <span class="text-secondary">
                                @if ($user->phone)
                                    {{ $user->phone }}
                                @else
                                    <span class="text-danger">{{ __('messages.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('messages.address') }}:
                            <span class="text-secondary">
                                @if ($user->address)
                                    {{ $user->address }}
                                @else
                                    <span class="text-danger">{{ __('messages.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('messages.account_information') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('messages.username') }}:
                            <span class="text-secondary">
                                {{ $user->username }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('messages.status') }}:
                            <span class="text-secondary">
                                @if ($user->status == 'active')
                                    <span class="badge bg-success">{{ __('messages.status_active') }}</span>
                                @elseif ($user->status == 'pending')
                                    <span class="badge bg-warning">{{ __('messages.status_pending') }}</span>
                                @elseif ($user->status == 'banned')
                                    <span class="badge bg-danger">{{ __('messages.status_banned') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('messages.status_deleted') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('messages.created_date') }}:
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
    <script>
        document.getElementById('imageUpload').addEventListener('change', function () {
            document.getElementById('avatarForm').submit();
        });
    </script>
    <script src="{{ asset('assets/js/resend-activation-mail.js') }}"></script>
@endpush