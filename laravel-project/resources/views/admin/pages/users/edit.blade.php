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

        @include('admin.pages.users.partials.form-edit')
    </div>
@endsection