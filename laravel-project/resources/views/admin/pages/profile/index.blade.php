@extends('admin.layouts.app-layout')

@section('title', __('admin/pages/profile.title'))

@section('content')

    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ __('admin/pages/profile.title') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('common.breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('common.breadcrumb.profile') }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="social-profile">
            <div class="card border-0 bg-white rounded-10 mb-4">
                <div class="position-relative">
                    <img alt="profile-cover" class="rounded-top-3 w-100"
                        src="{{ asset('assets/images/profile-big-cover.jpg') }}" />
                    <div class="position-absolute z-1" style="bottom: 20px; right: 20px;">
                    </div>
                </div>
                <div class="card border-0 rounded-10 p-20 pb-0 rounded-top-0 profile-info"
                    style="background-color: transparent !important;">
                    <div class="d-flex justify-content-between align-items-end flex-wrap gap-3">
                        <div class="d-flex align-items-end">
                            <div class="flex-shrink-0 position-relative">
                                <form id="avatarForm" action="{{ route('admin.profile.avatar.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="avatar-upload">
                                        <div class="avatar-edit" data-bs-placement="top">
                                            <input accept=".png, .jpg, .jpeg" name="avatar_url_file" id="imageUpload"
                                                type="file">
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview"
                                                style="background-image: url({{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }});">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="flex-grow-1 ms-20 mb-10" style="max-width: 1000px;">
                                <h3 class="mb-1">{{ $user->fullname }}</h3>
                                <div class="fs-15">
                                    <span class="text-secondary">{{ __('common.info.role.title') }}:</span>
                                    @if ($user->role)
                                        @if ($user->role->name === 'Admin')
                                            {{ __('common.info.role.admin') }}
                                        @elseif ($user->role->name === 'User')
                                            {{ __('common.info.role.user') }}
                                        @elseif ($user->role->name === 'Staff')
                                            {{ __('common.info.role.staff') }}
                                        @else
                                            {{ $user->role->name }}
                                        @endif
                                    @else
                                        {{ __('common.info.role.no_role') }}
                                    @endif
                                </div>
                                <div class="fs-15 text-wrap">
                                    <span class="text-secondary">{{ __('common.info.bio.title') }}:</span>
                                    {{ $user->bio ?? __('common.info.bio.no_bio') }}
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
                                            id="btnTextActivation" data-sending-text="{{ __('admin/pages/profile.sending') }}" data-resend-in-text="{{ __('admin/pages/profile.resend_in') }}" data-original-text="{{ __('admin/pages/profile.activate_account') }}">{{ __('admin/pages/profile.activate_account') }}</span>
                                        <span id="btnLoadingActivation"
                                            class="spinner-border spinner-border-sm ml-2 d-none"></span>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('admin.settings.account') }}"
                                class="btn btn-outline-border-color-70 text-secondary fw-normal fs-16 hover-bg"
                                style="padding: 12px 15px;">
                                {{ __('common.setting.title') }}
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
                        {{ __('admin/pages/profile.infomation.profile') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('common.info.full_name.title') }}:
                            <span class="text-secondary">
                                {{ $user->fullname }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('common.info.date_of_birth.title') }}:
                            <span class="text-secondary">
                                @if ($user->date_of_birth)
                                    {{ $user->date_of_birth }}
                                @else
                                    <span class="text-danger">{{ __('common.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('common.info.gender.title') }}:
                            <span class="text-secondary">
                                @if ($user->gender)
                                    @if ($user->gender === 'male')
                                        {{ __('common.info.gender.male') }}
                                    @elseif ($user->gender === 'female')
                                        {{ __('common.info.gender.female') }}
                                    @else
                                        {{ __('common.info.gender.other') }}
                                    @endif
                                @else
                                    <span class="text-danger">{{ __('common.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('admin/pages/profile.infomation.contact') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('common.info.email.title') }}:
                            <span class="text-secondary">
                                {{ $user->email }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('common.info.phone.title') }}:
                            <span class="text-secondary">
                                @if ($user->phone)
                                    {{ $user->phone }}
                                @else
                                    <span class="text-danger">{{ __('common.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('common.info.address.title') }}:
                            <span class="text-secondary">
                                @if ($user->address)
                                    {{ $user->address }}
                                @else
                                    <span class="text-danger">{{ __('common.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('admin/pages/profile.infomation.account') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('common.info.username.title') }}:
                            <span class="text-secondary">
                                {{ $user->username }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('common.info.status.title') }}:
                            <span class="text-secondary">
                                @if ($user->status == 'active')
                                    <span class="badge bg-success">{{ __('common.info.status.active') }}</span>
                                @elseif ($user->status == 'pending')
                                    <span class="badge bg-warning">{{ __('common.info.status.pending') }}</span>
                                @elseif ($user->status == 'banned')
                                    <span class="badge bg-danger">{{ __('common.info.status.banned') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('common.info.status.deleted') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('common.info.created_date.title') }}:
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
    <script src="{{ asset('assets/js/custom/resend-activation-mail.js') }}"></script>
@endpush