<div class="d-flex justify-content-center align-items-center h-100">
    @if($height->attachment_url)
        <a href="{{ asset($height->attachment_url) }}" target="_blank" class="text-decoration-none" data-bs-toggle="tooltip"
            title="{{ __('label.view_attachment') }}">
            <img src="{{ asset($height->attachment_url) }}" alt="Attachment" class="rounded"
                style="height: 50px; width: 50px; object-fit: cover;">
        </a>
    @else
        <span class="text-warning">{{ __('value.not_available') }}</span>
    @endif
</div>