@if ($user->status == \App\Models\User::STATUS_ACTIVE)
    <span class="text-success bg-success bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.active') }}</span>
@elseif ($user->status == \App\Models\User::STATUS_PENDING)
    <span class="text-warning bg-warning bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.pending') }}</span>
@elseif ($user->status == \App\Models\User::STATUS_BANNED)
    <span class="text-danger bg-danger bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.banned') }}</span>
@else
    <span class="text-secondary bg-secondary bg-opacity-10 fs-15 fw-normal d-inline-block default-badge">{{ __('value.status.deleted') }}</span>
@endif