@extends('layouts.app-layout')

@section('title', __('messages.add_new_user'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('messages.add_new_user') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('dashboard') }}">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">{{ __('messages.menu_dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('messages.user_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('messages.add_new_user') }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        
        <form id="addUserForm" action="{{ route('user.store.post') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        <h3 class="mb-20">
                            {{ __('messages.profile_information') }}
                        </h3>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('messages.full_name') }}</label>
                                    <div class="form-floating">
                                        <input class="form-control" id="fullname" name="fullname" placeholder="{{ __('messages.enter_full_name') }}" type="text" value="{{ old('fullname') }}"/>
                                        <label for="fullname"><i class="ri-user-line"></i>{{ __('messages.enter_full_name') }}</label>
                                    </div>
                                    @error('fullname')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('messages.email') }}</label>
                                    <div class="form-floating">
                                        <input class="form-control" id="email" name="email" placeholder="{{ __('messages.enter_email') }}" type="email" value="{{ old('email') }}"/>
                                        <label for="email"><i class="ri-mail-line"></i>{{ __('messages.enter_email') }}</label>
                                    </div>
                                    @error('email')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-20">
                                    <label class="label fs-16 mb-2">{{ __('messages.role') }}</label>
                                    <div class="form-floating">
                                        <select class="form-select form-control" id="role_id" name="role_id">
                                            <option value="">{{ __('messages.select_role') }}</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ __('messages.role_' . strtolower($role->name)) }}</option>
                                            @endforeach
                                        </select>
                                        <label for="role_id">{{ __('messages.select_role') }}</label>
                                    </div>
                                    @error('role_id')
                                        <div class="text-danger mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="d-flex gap-2 justify-content-center">
                                    <button class="btn btn-primary fw-normal text-white" type="submit" id="submitBtn" data-processing-text="{{ __('messages.processing') }}">
                                        <span id="btnText">{{ __('messages.add_user_btn') }}</span>
                                        <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
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

@push('scripts')
    <script src="{{ asset('assets/js/custom/auth.js') }}"></script>
@endpush