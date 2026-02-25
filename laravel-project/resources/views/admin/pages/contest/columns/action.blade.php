<div class="d-flex justify-content-end text-nowrap gap-2">
    <a href="{{ route('admin.contests.ranking', $row->id) }}" class="bg-transparent p-0 border-0 hover-text-warning"
        data-bs-placement="top" data-bs-title="{{ __('button.ranking') }}" data-bs-toggle="tooltip">
        <i class="material-symbols-outlined fs-16 fw-normal text-body">leaderboard</i>
    </a>
    <a href="{{ route('admin.contests.show', $row->id) }}" class="bg-transparent p-0 border-0 hover-text-primary"
        data-bs-placement="top" data-bs-title="{{ __('button.view') }}" data-bs-toggle="tooltip">
        <i class="material-symbols-outlined fs-16 fw-normal text-body">visibility</i>
    </a>
    <a href="{{ route('admin.contests.edit', $row->id) }}" class="bg-transparent p-0 border-0 hover-text-success"
        data-bs-placement="top" data-bs-title="{{ __('button.edit') }}" data-bs-toggle="tooltip">
        <i class="material-symbols-outlined fs-16 fw-normal text-body">drive_file_rename_outline</i>
    </a>
    <form action="{{ route('admin.contests.destroy', $row->id) }}" method="POST" class="d-inline delete-form">
        @csrf
        @method('DELETE')
        <button type="button" class="bg-transparent p-0 border-0 hover-text-danger delete-btn" data-bs-placement="top"
            data-bs-title="{{ __('button.delete') }}" data-bs-toggle="tooltip">
            <i class="material-symbols-outlined fs-16 fw-normal text-body">delete</i>
        </button>
    </form>
</div>
