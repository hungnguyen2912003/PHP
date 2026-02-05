@if($weight->attachment_url)
    <a href="{{ asset($weight->attachment_url) }}" target="_blank" class="btn btn-sm btn-primary py-1 px-3 fs-12 text-white"
        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('label.view_attachment') }}">
        <i class="ri-attachment-line"></i>
    </a>
@else
    <span class="text-warning fs-12">{{ __('value.not_available') }}</span>
@endif
