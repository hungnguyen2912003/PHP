@extends('admin.layouts.app-layout')

@section('title', __('title.measurement_list') . ' - ' . $user->fullname)

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ __('title.measurement_list') }} - {{ $user->fullname }}</h3>

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
                        <a href="{{ route('admin.measurements.index') }}" class="text-decoration-none hover">
                            <span>
                                {{ __('breadcrumb.measurement_management') }}
                            </span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>
                            {{ __('breadcrumb.measurement_list') }}
                        </span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active text-secondary">
                        <span>
                            {{ $user->fullname }}
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
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 text-nowrap fs-14">{{ __('label.from') }}</label>
                        <input type="date" class="form-control" id="fromDate">
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 text-nowrap fs-14">{{ __('label.to') }}</label>
                        <input type="date" class="form-control" id="toDate">
                    </div>
                </div>
                <div class="d-flex gap-3">
                    <a class="text-decoration-none fs-16 text-primary" href="{{ route('admin.measurements.index') }}">
                        {{ __('button.back') }}
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
                    window.LaravelDataTables["user-measurement-table"].search(this.value).draw();
                });
            }

            // Date Filter trigger
            const fromDateInput = document.getElementById('fromDate');
            const toDateInput = document.getElementById('toDate');

            if (fromDateInput) {
                fromDateInput.addEventListener('change', function () {
                    window.LaravelDataTables["user-measurement-table"].draw();
                });
            }

            if (toDateInput) {
                toDateInput.addEventListener('change', function () {
                    window.LaravelDataTables["user-measurement-table"].draw();
                });
            }

            // Function to handle delete button click (delegated)
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
            });
        });
    </script>
@endpush