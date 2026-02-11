@extends('admin.layouts.app-layout')

@section('title', __('title.update_user'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.update_user') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1">
                            </i>
                            <span class="text-body fs-14 hover">
                                {{ __('breadcrumb.dashboard') }}
                            </span>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.users.index') }}">
                            <span class="text-body fs-14 hover">
                                {{ __('breadcrumb.user_management') }}
                            </span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">
                            {{ __('title.update_user') }}
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <form id="common-form" action="{{ route('admin.users.update', $user->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-4">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.user_image') }}
                        </h3>
                        <div class="text-center">
                            <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}"
                                class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;"
                                alt="user">
                        </div>
                    </div>
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <div class="row">
                            <h3 class="mb-20">
                                {{ __('section.account_information') }}
                            </h3>
                            <div class="col-lg-12">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.username') }}
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control" value="{{ $user->username }}" disabled type="text" />
                                        <label>
                                            {{ __('label.username') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.password') }}
                                    </label>
                                    <div class="form-group" id="password-show-hide">
                                        <div class="password-wrapper position-relative password-container form-floating">
                                            <input class="form-control password @error('password') is-invalid @enderror"
                                                name="password" placeholder="{{ __('placeholder.password') }}"
                                                type="password" />
                                            <i aria-hidden="true"
                                                class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                                                style="color: #A9A9C8; font-size: 22px; right: 15px;"></i>
                                            <label for="password">
                                                {{ __('placeholder.password') }}
                                            </label>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ __('message.hint.password_min') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.profile_information') }}
                        </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.full_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('fullname') is-invalid @enderror" name="fullname"
                                            value="{{ old('fullname', $user->fullname) }}"
                                            placeholder="{{ __('placeholder.full_name') }}" type="text" />
                                        <label>
                                            {{ __('placeholder.full_name') }}
                                        </label>
                                        @error('fullname')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.gender') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-control @error('gender') is-invalid @enderror"
                                        name="gender" aria-label="Default select example">
                                        <option value="" selected disabled>{{ __('placeholder.gender') }}
                                        </option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                            {{ __('value.gender.male') }}
                                        </option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                            {{ __('value.gender.female') }}
                                        </option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.date_of_birth') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('date_of_birth') is-invalid @enderror"
                                            name="date_of_birth"
                                            value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}"
                                            type="date" />
                                        <label>
                                            {{ __('placeholder.date_of_birth') }}
                                        </label>
                                        @error('date_of_birth')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.email') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email', $user->email) }}"
                                            placeholder="{{ __('placeholder.email') }}" type="email" />
                                        <label>
                                            {{ __('placeholder.email') }}
                                        </label>
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.phone') }}
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('phone') is-invalid @enderror" name="phone"
                                            value="{{ old('phone', $user->phone) }}"
                                            placeholder="{{ __('placeholder.phone') }}" type="text" />
                                        <label>
                                            {{ __('placeholder.phone') }}
                                        </label>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.address') }}
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('address') is-invalid @enderror" name="address"
                                            value="{{ old('address', $user->address) }}"
                                            placeholder="{{ __('placeholder.address') }}" type="text" />
                                        <label>
                                            {{ __('placeholder.address') }}
                                        </label>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('section.settings') }}
                        </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.status') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-control @error('status') is-invalid @enderror"
                                        name="status">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>
                                            {{ __('value.status.active') }}
                                        </option>
                                        <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>
                                            {{ __('value.status.pending') }}
                                        </option>
                                        <option value="banned" {{ $user->status == 'banned' ? 'selected' : '' }}>
                                            {{ __('value.status.banned') }}
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                        {{ __('label.role') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-control @error('role') is-invalid @enderror"
                                        name="role">
                                        @foreach(['admin', 'staff', 'user'] as $roleName)
                                            <option value="{{ $roleName }}" {{ old('role', $user->role) == $roleName ? 'selected' : '' }}>
                                                {{ __('value.role.' . $roleName) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('role')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn"
                                        data-processing-text="{{ __('button.processing') }}">
                                        <span id="btnText">{{ __('button.update') }}</span>
                                        <span id="btnLoading" class="spinner-border spinner-border-sm ms-2 d-none"></span>
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-danger fw-normal text-white">
                                        {{ __('button.cancel') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/common.js') }}"></script>
@endpush