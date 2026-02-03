<div class="d-flex justify-content-end text-nowrap gap-2">
    @if ($user->status == 'pending')
    <form action="" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="bg-transparent p-0 border-0 hover-text-warning" data-bs-placement="top" data-bs-title="{{ __('button.resend_activation') }}" data-bs-toggle="tooltip">
            <i class="material-symbols-outlined fs-16 fw-normal text-body">
            refresh
            </i>
        </button>
    </form>
    @endif
    <a href="{{ route('admin.users.show', $user->id) }}" class="bg-transparent p-0 border-0 hover-text-primary" data-bs-placement="top" data-bs-title="{{ __('button.view') }}" data-bs-toggle="tooltip">
    <i class="material-symbols-outlined fs-16 fw-normal text-body">
    visibility
    </i>
    </a>
    <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-transparent p-0 border-0 hover-text-success" data-bs-placement="top" data-bs-title="{{ __('button.edit') }}" data-bs-toggle="tooltip">
    <i class="material-symbols-outlined fs-16 fw-normal text-body">
    drive_file_rename_outline
    </i>
    </a>
    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="bg-transparent p-0 border-0 hover-text-danger delete-btn" data-bs-placement="top" data-bs-title="{{ __('button.delete') }}" data-bs-toggle="tooltip">
        <i class="material-symbols-outlined fs-16 fw-normal text-body">
        delete
        </i>
        </button>
    </form>
</div>