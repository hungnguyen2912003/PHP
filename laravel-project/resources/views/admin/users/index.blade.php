@extends('layouts.app-layout')

@section('title', __('messages.user_management'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('messages.user_management') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="index.html">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">{{ __('messages.menu_dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('messages.user_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('messages.users_list') }}</span>
                    </li>
                </ol>
            </nav>
        </div>
            <div class="card bg-white rounded-10 border border-white mb-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-20">
                    <form class="table-src-form position-relative m-0">
                        <input class="form-control w-344" placeholder="{{ __('messages.search_user') }}" type="text"/>
                        <div class="src-btn position-absolute top-50 start-0 translate-middle-y bg-transparent p-0 border-0">
                            <span class="material-symbols-outlined">
                            search
                            </span>
                        </div>
                    </form>
                    <a class="text-decoration-none fs-16 text-primary" href="add-teacher.html">
                    + {{ __('messages.add_new_user') }}
                    </a>
                </div>
                <div class="default-table-area mx-minus-1 style-two table-students-list">
                    <div class="table-responsive">
                        <table class="table align-middle w-100">
                        <thead>
                            <tr>
                                <th class="fw-medium pe-0" scope="col" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexCheckDefault1" type="checkbox"/>
                                    </div>
                                </th>
                                <th class="fw-medium" scope="col">{{ __('messages.full_name') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.date_of_birth') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.gender') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.email') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.phone') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.address') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.role') }}</th>
                                <th class="fw-medium" scope="col">{{ __('messages.status') }}</th>
                                <th class="fw-medium text-start" scope="col">{{ __('messages.action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="style-two">
                            @foreach($users as $user)
                            <tr>
                                <td class="text-body pe-0" style="width: 50px;">
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexCheckDefault{{ $user->id }}" type="checkbox"/>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <img alt="avatar" class="rounded-circle" src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}" style="width: 35px; height: 35px;"/>
                                        </div>
                                        <div class="flex-grow-1 ms-12 position-relative top-2">
                                            <h3 class="fw-medium mb-0 fs-16">
                                                {{ $user->fullname }}
                                            </h3>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-body">
                                    @if ($user->date_of_birth)
                                        @if (app()->getLocale() == 'vi')
                                            {{ $user->date_of_birth->format('d/m/Y') }}
                                        @elseif (app()->getLocale() == 'ja')
                                            {{ $user->date_of_birth->format('Y/m/d') }}
                                        @else
                                            {{ $user->date_of_birth->format('Y-m-d') }}
                                        @endif
                                    @else
                                        <span class="text-warning">{{ __('messages.not_available') }}</span>
                                    @endif
                                </td>
                                <td class="text-body">
                                    @if ($user->gender == 'male')
                                        {{ __('messages.gender_male') }}
                                    @elseif ($user->gender == 'female')
                                        {{ __('messages.gender_female') }}
                                    @elseif ($user->gender == 'other')
                                        {{ __('messages.gender_other') }}
                                    @else
                                        <span class="text-warning">{{ __('messages.not_available') }}</span>
                                    @endif
                                </td>
                                <td class="text-primary-30">
                                    {{ $user->email }}
                                </td>
                                <td class="text-body">
                                    @if ($user->phone)
                                        {{ $user->phone }}
                                    @else
                                        <span class="text-warning">{{ __('messages.not_available') }}</span>
                                    @endif
                                </td>
                                <td class="text-body">
                                    <span class="d-inline-block text-truncate" style="max-width: 150px;" data-bs-title="{{ $user->address }}">
                                         @if ($user->address)
                                            {{ $user->address }}
                                        @else
                                            <span class="text-warning">{{ __('messages.not_available') }}</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="text-body">
                                    @php $roleName = optional($user->role)->name; @endphp
                                    @if ($roleName === 'Admin')
                                        <span class="badge bg-primary">{{ __('messages.admin') }}</span>
                                    @elseif ($roleName === 'User')
                                        <span class="badge bg-info">{{ __('messages.user') }}</span>
                                    @else
                                        {{ $roleName }}
                                    @endif
                                </td>
                                <td>
                                    @if ($user->status == 'active')
                                        <span class="text-success bg-success bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_active') }}</span>
                                    @elseif ($user->status == 'pending')
                                        <span class="text-warning bg-warning bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_pending') }}</span>
                                    @elseif ($user->status == 'banned')
                                        <span class="text-danger bg-danger bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_banned') }}</span>
                                    @else
                                        <span class="text-secondary bg-secondary bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_deleted') }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start" style="gap: 12px;">
                                        <button class="bg-transparent p-0 border-0" data-bs-placement="top" data-bs-title="{{ __('messages.view') }}" data-bs-toggle="tooltip">
                                        <i class="material-symbols-outlined fs-16 fw-normal text-primary">
                                        visibility
                                        </i>
                                        </button>
                                        <button class="bg-transparent p-0 border-0 hover-text-success" data-bs-placement="top" data-bs-title="{{ __('messages.edit') }}" data-bs-toggle="tooltip">
                                        <i class="material-symbols-outlined fs-16 fw-normal text-body">
                                        drive_file_rename_outline
                                        </i>
                                        </button>
                                        <button class="bg-transparent p-0 border-0 hover-text-danger" data-bs-placement="top" data-bs-title="{{ __('messages.delete') }}" data-bs-toggle="tooltip">
                                        <i class="material-symbols-outlined fs-16 fw-normal text-body">
                                        delete
                                        </i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div class="d-flex justify-content-center justify-content-sm-between align-items-center text-center flex-wrap gap-2 showing-wrap p-20">
                        <span class="fs-15">
                            {{ __('messages.showing_entries', ['first' => $users->firstItem(), 'last' => $users->lastItem(), 'total' => $users->total()]) }}
                        </span>
                        
                        @if ($users->hasPages())
                        <nav aria-label="Page navigation example" class="custom-pagination">
                            {{ $users->links('pagination.custom') }}
                        </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endsection
