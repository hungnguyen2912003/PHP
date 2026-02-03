@if ($user->status == 'active')
    <span class="text-success bg-success bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.active') }}</span>
@elseif ($user->status == 'pending')
    <span class="text-warning bg-warning bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.pending') }}</span>
@elseif ($user->status == 'banned')
    <span class="text-danger bg-danger bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.banned') }}</span>
@else
    <span class="text-secondary bg-secondary bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.deleted') }}</span>
@endif