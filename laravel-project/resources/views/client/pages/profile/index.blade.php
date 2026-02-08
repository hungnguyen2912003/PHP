@extends('client.layouts.app-layout')

@section('title', __('title.profile'))

@section('content')

    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ __('title.profile') }}</h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('client.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.profile') }}</span>
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
                                <form id="avatarForm" action="{{ route('client.profile.avatar.update') }}" method="POST"
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
                                    <label class="form-label text-secondary">{{ __('label.role') }}:</label>
                                    @if ($user->role)
                                        @if ($user->role->name === 'Admin')
                                            {{ __('value.role.admin') }}
                                        @elseif ($user->role->name === 'User')
                                            {{ __('value.role.user') }}
                                        @elseif ($user->role->name === 'Staff')
                                            {{ __('value.role.staff') }}
                                        @else
                                            {{ $user->role->name }}
                                        @endif
                                    @else
                                        {{ __('value.role.no_role') }}
                                    @endif
                                </div>
                                <div class="fs-15 text-wrap">
                                    <span class="text-secondary">{{ __('label.bio') }}:</span>
                                    {{ $user->bio ?? __('value.no_bio') }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-sm-4 gap-2">
                            @if($user->status === 'pending')
                                <form action="{{ route('client.resend-activation') }}" method="POST" class="d-inline"
                                    id="resendActivationForm">
                                    @csrf
                                    <button id="resend-activation-btn" type="submit"
                                        class="btn btn-warning text-white fw-normal fs-16 hover-bg" style="padding: 12px 15px;">
                                        <i class="ri-error-warning-line"></i> <span id="btnTextActivation"
                                            data-sending-text="{{ __('button.sending') }}"
                                            data-resend-in-text="{{ __('button.resend_in') }}"
                                            data-original-text="{{ __('button.activate') }}">{{ __('button.activate') }}</span>
                                        <span id="btnLoadingActivation"
                                            class="spinner-border spinner-border-sm ml-2 d-none"></span>
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('client.settings.account') }}"
                                class="btn btn-outline-border-color-70 text-secondary fw-normal fs-16 hover-bg"
                                style="padding: 12px 15px;">
                                {{ __('button.settings') }}
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
                        {{ __('section.profile_information') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('label.full_name') }}:
                            <span class="text-secondary">
                                {{ $user->fullname }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('label.date_of_birth') }}:
                            <span class="text-secondary">
                                @if ($user->date_of_birth)
                                    {{ $user->date_of_birth->format('d-m-Y') }}
                                @else
                                    <span class="text-danger">{{ __('value.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('label.gender') }}:
                            <span class="text-secondary">
                                @if ($user->gender)
                                    @if ($user->gender === 'male')
                                        {{ __('value.gender.male') }}
                                    @elseif ($user->gender === 'female')
                                        {{ __('value.gender.female') }}
                                    @else
                                        {{ __('value.gender.other') }}
                                    @endif
                                @else
                                    <span class="text-danger">{{ __('value.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('section.contact_information') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('label.email') }}:
                            <span class="text-secondary">
                                {{ $user->email }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('label.phone') }}:
                            <span class="text-secondary">
                                @if ($user->phone)
                                    {{ $user->phone }}
                                @else
                                    <span class="text-danger">{{ __('value.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('label.address') }}:
                            <span class="text-secondary">
                                @if ($user->address)
                                    {{ $user->address }}
                                @else
                                    <span class="text-danger">{{ __('value.unknown') }}</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-4 col-xxl-4 col-xxxl-4">
                <div class="card bg-white border border-white rounded-10 p-20 mb-4">
                    <h3 class="mb-20">
                        {{ __('section.account_information') }}
                    </h3>
                    <ul class="p-0 mb-0 list-unstyled last-child-none">
                        <li class="mb-10 fs-16">
                            {{ __('label.username') }}:
                            <span class="text-secondary">
                                {{ $user->username }}
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            <label class="form-label text-secondary">{{ __('label.status') }}:</label>
                            <span class="text-secondary">
                                @if ($user->status == 'active')
                                    <span class="badge bg-success">{{ __('value.status.active') }}</span>
                                @elseif ($user->status == 'pending')
                                    <span class="badge bg-warning">{{ __('value.status.pending') }}</span>
                                @elseif ($user->status == 'banned')
                                    <span class="badge bg-danger">{{ __('value.status.banned') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('value.status.deleted') }}</span>
                                @endif
                            </span>
                        </li>
                        <li class="mb-10 fs-16">
                            {{ __('label.created_date') }}:
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