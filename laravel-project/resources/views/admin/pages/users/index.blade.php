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
                <form class="table-src-form position-relative m-0">
                    <input class="form-control w-344" placeholder="{{ __('placeholder.search') }}" type="text" id="customSearch"/>
                    <div class="src-btn position-absolute top-50 start-0 translate-middle-y bg-transparent p-0 border-0">
                        <span class="material-symbols-outlined">
                        search
                        </span>
                    </div>
                </form>
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
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">

                <form id="importForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-semibold d-flex align-items-center gap-2" id="importModalLabel">
                            <i class="ri-upload-cloud-2-line text-primary fs-4"></i>
                            {{ __('modal.confirm.import.title') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-3">
                        <div>
                            <label class="form-label fw-medium text-muted small text-uppercase">
                                {{ __('modal.confirm.import.file') }}
                            </label>
                            <input type="file"
                                name="file"
                                class="import-file-filepond"
                                accept=".xlsx,.xls,.csv"
                                required>
                        </div>

                    </div>
                    <div class="modal-footer border-0 pt-4 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary text-white px-4 rounded-3" data-bs-dismiss="modal">
                            {{ __('modal.confirm.import.cancel') }}
                        </button>
                        <button type="submit" id="importSubmitBtn" class="btn btn-primary text-white px-4 rounded-3 shadow-sm">
                            {{ __('modal.confirm.import.btn') }}
                        </button>
                    </div>

                </form>
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

            const importModal = new bootstrap.Modal(document.getElementById('importModal'));
            const importForm = document.getElementById('importForm');

            // Initialize FilePond
            if (typeof FilePond !== 'undefined') {
                FilePond.registerPlugin(FilePondPluginImagePreview);
                const pond = FilePond.create(document.querySelector('.import-file-filepond'), {
                    allowImagePreview: false,
                    storeAsFile: true,
                    labelIdle: `{!! __('placeholder.drag_drop_file') !!}`,
                    acceptedFileTypes: ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'text/csv']
                });
                
                // Reset FilePond when modal is hidden
                document.getElementById('importModal').addEventListener('hidden.bs.modal', function () {
                    pond.removeFiles();
                    
                    // Reset submit button state
                    const submitBtn = document.getElementById('importSubmitBtn');
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = {!! json_encode(__('modal.confirm.import.btn')) !!};
                });

                // Handle form submission loading state
                importForm.addEventListener('submit', function () {
                    const submitBtn = document.getElementById('importSubmitBtn');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' + {!! json_encode(__('button.processing')) !!};
                });
            }

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

                if (e.target.closest('.import-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.import-btn');
                    const userId = button.getAttribute('data-user-id');
                    
                    // Update form action URL
                    importForm.action = `/admin/users/import/${userId}`;
                    
                    // Open modal
                    importModal.show();
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