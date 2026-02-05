@extends('admin.layouts.app-layout')

@section('title', __('title.role_details'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.role_details') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('breadcrumb.role_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.role_details') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                    <h3 class="mb-20">
                        {{ __('section.role_information') }}
                    </h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">{{ __('label.name') }}</label>
                                <div class="fs-18 fw-medium">{{ __('value.role.' . strtolower($role->name)) }}</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">{{ __('label.total_users') }}</label>
                                <div class="fs-18 fw-medium">{{ $role->users()->count() }}</div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary fw-normal text-white">
                                    {{ __('button.edit') }}
                                </a>
                                <a href="{{ route('admin.roles.index') }}" class="btn btn-danger fw-normal text-white">
                                    {{ __('button.back') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
