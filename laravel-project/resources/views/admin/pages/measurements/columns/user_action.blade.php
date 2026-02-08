<div class="d-flex align-items-center justify-content-end gap-2">
    <a href="#" class="btn btn-sm btn-icon border-0 p-0 text-body bg-transparent import-btn" data-user-id="{{ $id }}"
        data-user-status="{{ $status }}" data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ __('button.import') }}">
        <span class="material-symbols-outlined fs-20">publish</span>
    </a>
    <a href="{{ route('admin.measurements.user', $id) }}"
        class="btn btn-sm btn-icon border-0 p-0 text-body bg-transparent" data-bs-toggle="tooltip"
        data-bs-placement="top" title="{{ __('button.view') }}">
        <span class="material-symbols-outlined fs-20">visibility</span>
    </a>
</div>