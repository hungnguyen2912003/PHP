@extends('admin.layouts.app-layout')

@section('title', __('title.users_list'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ __('title.users_list') }}</h3>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">
                                {{ __('breadcrumb.dashboard') }}
                            </span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>
                            {{ __('breadcrumb.user_management') }}
                        </span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">
                            {{ __('breadcrumb.users_list') }}
                        </span>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="card bg-white rounded-10 border border-white mb-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-20">
                <div class="d-flex align-items-center flex-wrap gap-4">
                    <form class="table-src-form position-relative m-0">
                        <input class="form-control w-344" placeholder="{{ __('placeholder.search') }}" type="text"
                            id="customSearch" />
                        <div
                            class="src-btn position-absolute top-50 start-0 translate-middle-y bg-transparent p-0 border-0">
                            <span class="material-symbols-outlined">
                                search
                            </span>
                        </div>
                    </form>
                    <div class="dropdown select-dropdown without-border">
                        <input type="hidden" id="genderFilterValue" value="">
                        <button aria-expanded="false" class="dropdown-toggle bg-transparent text-secondary fs-15"
                            data-bs-toggle="dropdown" id="genderFilterBtn">
                            {{ __('label.gender') }} ({{ __('label.all') }})
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow rounded-10"
                            data-simplebar="">
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="gender"
                                    data-value="">
                                    {{ __('label.gender') }} ({{ __('label.all') }})
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="gender"
                                    data-value="male">
                                    {{ __('value.gender.male') }}
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="gender"
                                    data-value="female">
                                    {{ __('value.gender.female') }}
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="gender"
                                    data-value="other">
                                    {{ __('value.gender.other') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="dropdown select-dropdown without-border">
                        <input type="hidden" id="roleFilterValue" value="">
                        <button aria-expanded="false" class="dropdown-toggle bg-transparent text-secondary fs-15"
                            data-bs-toggle="dropdown" id="roleFilterBtn">
                            {{ __('label.role') }} ({{ __('label.all') }})
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow rounded-10"
                            data-simplebar="">
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="role"
                                    data-value="">
                                    {{ __('label.role') }} ({{ __('label.all') }})
                                </button>
                            </li>
                            @foreach(['admin', 'staff', 'user'] as $roleName)
                                <li>
                                    <button class="dropdown-item text-secondary filter-option" data-filter="role"
                                        data-value="{{ $roleName }}">
                                        {{ __('value.role.' . $roleName) }}
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="dropdown select-dropdown without-border">
                        <input type="hidden" id="statusFilterValue" value="">
                        <button aria-expanded="false" class="dropdown-toggle bg-transparent text-secondary fs-15"
                            data-bs-toggle="dropdown" id="statusFilterBtn">
                            {{ __('label.status') }} ({{ __('label.all') }})
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end bg-white border-0 box-shadow rounded-10"
                            data-simplebar="">
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="status"
                                    data-value="">
                                    {{ __('label.status') }} ({{ __('label.all') }})
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="status"
                                    data-value="{{ \App\Models\User::STATUS_ACTIVE }}">
                                    {{ __('value.status.active') }}
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="status"
                                    data-value="{{ \App\Models\User::STATUS_PENDING }}">
                                    {{ __('value.status.pending') }}
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="status"
                                    data-value="{{ \App\Models\User::STATUS_BANNED }}">
                                    {{ __('value.status.banned') }}
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item text-secondary filter-option" data-filter="status"
                                    data-value="deleted">
                                    {{ __('value.status.deleted') }}
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <a class="text-decoration-none fs-16 text-primary" href="{{ route('admin.users.create') }}">
                        + {{ __('button.add_user') }}
                    </a>
                </div>
            </div>
            <div class="default-table-area mx-minus-1 style-two table-list">
                <div class="table-responsive">
                    {{ $dataTable->table(['class' => 'table align-middle w-100']) }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Custom Search for DataTable
            const searchInput = document.getElementById('customSearch');
            if (searchInput) {
                searchInput.addEventListener('keyup', function () {
                    window.LaravelDataTables["users-table"].search(this.value).draw();
                });
            }

            // Filter logic
            document.querySelectorAll('.filter-option').forEach(option => {
                option.addEventListener('click', function (e) {
                    e.preventDefault();
                    const filterType = this.getAttribute('data-filter');
                    const value = this.getAttribute('data-value');
                    const text = this.innerText;

                    // Update hidden input and button text
                    if (filterType === 'gender') {
                        document.getElementById('genderFilterValue').value = value;
                        document.getElementById('genderFilterBtn').innerText = text;
                    } else if (filterType === 'role') {
                        document.getElementById('roleFilterValue').value = value;
                        document.getElementById('roleFilterBtn').innerText = text;
                    } else if (filterType === 'status') {
                        document.getElementById('statusFilterValue').value = value;
                        document.getElementById('statusFilterBtn').innerText = text;
                    }

                    // Redraw table
                    window.LaravelDataTables["users-table"].draw();
                });
            });

            // Function to handle delegated clicks
            document.body.addEventListener('click', function (e) {
                if (e.target.closest('.delete-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.delete-btn');
                    const form = button.closest('form');

                    Swal.fire({
                        title: {!! json_encode(__('modal.confirm.delete.title')) !!},
                        text: {!! json_encode(__('modal.confirm.delete.text')) !!},
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: {!! json_encode(__('modal.confirm.delete.btn')) !!},
                        cancelButtonText: {!! json_encode(__('modal.confirm.delete.cancel')) !!}
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }

                if (e.target.closest('.resend-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.resend-btn');
                    const form = button.closest('form');

                    Swal.fire({
                        title: {!! json_encode(__('modal.confirm.resend.title')) !!},
                        text: {!! json_encode(__('modal.confirm.resend.text')) !!},
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: {!! json_encode(__('modal.confirm.resend.btn')) !!},
                        cancelButtonText: {!! json_encode(__('modal.confirm.resend.cancel')) !!},
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        preConfirm: () => {
                            return new Promise((resolve) => {
                                const confirmBtn = Swal.getConfirmButton();
                                confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + {!! json_encode(__('button.processing')) !!};
                                confirmBtn.disabled = true;
                                form.submit();
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush