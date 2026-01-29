@extends('layouts.app-layout')

@section('title', __('messages.update_profile'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('messages.update_user') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('dashboard') }}">
                        <i class="ri-home-8-line fs-15 text-primary me-1">
                        </i>
                        <span class="text-body fs-14 hover">
                        {{ __('messages.menu_dashboard') }}
                        </span>
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('user.index') }}">
                        <span class="text-body fs-14 hover">
                        {{ __('messages.user_management') }}
                        </span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">
                        {{ __('messages.update_user') }}
                        </span>
                    </li>
                </ol>
            </nav>
        </div>
        
        <form action="{{ route('user.edit.post', $user->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-lg-4">
                <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                    <label class="label fs-16">
                    {{ __('messages.user_image') }}
                    </label>
                    <div class="text-center">
                        <img src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;" alt="user">
                    </div>
                </div>
                <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                    <div class="row">
                        <h3 class="mb-20">
                            {{ __('messages.account_information') }}
                        </h3>
                        <div class="col-lg-12">
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">
                                {{ __('messages.username') }}
                                </label>
                                <div class="form-floating">
                                    <input class="form-control" value="{{ $user->username }}" disabled type="text"/>
                                    <label>
                                    {{ __('messages.username') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">
                                {{ __('messages.password') }}
                                </label>
                                <div class="form-floating">
                                    <input class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('messages.enter_new_password') }}" type="password"/>
                                    <label>
                                    {{ __('messages.enter_new_password') }}
                                    </label>
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <small class="text-muted">{{ __('messages.password_min_length') }}</small>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                    <h3 class="mb-20">
                        {{ __('messages.profile_information') }}
                    </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                    {{ __('messages.full_name') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('fullname') is-invalid @enderror" name="fullname" value="{{ old('fullname', $user->fullname) }}" placeholder="{{ __('messages.enter_full_name') }}" type="text"/>
                                        <label>
                                        {{ __('messages.enter_full_name') }}
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
                                    {{ __('messages.gender') }}
                                    </label>
                                    <select class="form-select form-control @error('gender') is-invalid @enderror" name="gender" aria-label="Default select example">
                                        <option value="" selected disabled>{{ __('messages.select_gender') }}</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>{{ __('messages.gender_male') }}</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>{{ __('messages.gender_female') }}</option>
                                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>{{ __('messages.gender_other') }}</option>
                                    </select>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                    {{ __('messages.date_of_birth') }}
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}" type="date"/>
                                        <label>
                                        {{ __('messages.select_date') }}
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
                                    {{ __('messages.email') }} <span class="text-danger">*</span>
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" placeholder="{{ __('messages.enter_email') }}" type="email"/>
                                        <label>
                                        {{ __('messages.enter_email') }}
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
                                    {{ __('messages.phone') }}
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="{{ __('messages.placeholder_phone') }}" type="text"/>
                                        <label>
                                        {{ __('messages.placeholder_phone') }}
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
                                    {{ __('messages.address') }}
                                    </label>
                                    <div class="form-floating">
                                        <input class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address', $user->address) }}" placeholder="{{ __('messages.placeholder_address') }}" type="text"/>
                                        <label>
                                        {{ __('messages.placeholder_address') }}
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
                        {{ __('messages.settings') }}
                    </h3>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                    {{ __('messages.status') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-control @error('status') is-invalid @enderror" name="status">
                                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>{{ __('messages.status_active') }}</option>
                                        <option value="pending" {{ $user->status == 'pending' ? 'selected' : '' }}>{{ __('messages.status_pending') }}</option>
                                        <option value="banned" {{ $user->status == 'banned' ? 'selected' : '' }}>{{ __('messages.status_banned') }}</option>
                                    </select>
                                    @error('status')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">
                                    {{ __('messages.role') }} <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select form-control @error('role_id') is-invalid @enderror" name="role_id">
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                            {{ __('messages.role_' . strtolower($role->name)) ?? $role->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('role_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-primary fw-normal text-white" type="submit">
                                    {{ __('messages.updated_profile_btn') }}
                                    </button>
                                    <a href="{{ route('user.index') }}" class="btn btn-danger fw-normal text-white">
                                    {{ __('messages.cancel_btn') }}
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