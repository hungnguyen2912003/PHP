@if ($user->status == 'active')
    <span class="text-success bg-success bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_active') }}</span>
@elseif ($user->status == 'pending')
    <span class="text-warning bg-warning bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_pending') }}</span>
@elseif ($user->status == 'banned')
    <span class="text-danger bg-danger bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_banned') }}</span>
@else
    <span class="text-secondary bg-secondary bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('messages.status_deleted') }}</span>
@endif
