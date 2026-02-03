@if($weight->attachment_url)
    <a href="{{ asset($weight->attachment_url) }}" target="_blank" class="text-decoration-none" data-bs-toggle="tooltip" title="{{ __('label.view_attachment') }}">
        <i class="material-symbols-outlined fs-20">image</i>
    </a>
@else
    <span class="text-warning">{{ __('value.not_available') }}</span>
@endif
