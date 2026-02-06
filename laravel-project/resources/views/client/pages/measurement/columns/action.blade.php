<div class="d-flex align-items-center justify-content-end gap-2">
    <a href="{{ route('client.measurement.show', $id) }}" class="btn btn-sm btn-icon border-0 p-0 text-body bg-transparent"
        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('button.view') }}">
        <span class="material-symbols-outlined fs-20">visibility</span>
    </a>
    <a href="{{ route('client.measurement.edit', $id) }}" class="btn btn-sm btn-icon border-0 p-0 text-body bg-transparent"
        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('button.edit') }}">
        <span class="material-symbols-outlined fs-20">edit</span>
    </a>
    <form action="{{ route('client.measurement.destroy', $id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-sm btn-icon border-0 p-0 text-body bg-transparent delete-btn"
            data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('button.delete') }}">
            <span class="material-symbols-outlined fs-20">delete</span>
        </button>
    </form>
</div>