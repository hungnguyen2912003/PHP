@php $roleName = optional($user->role)->name; @endphp
@if ($roleName === 'Admin')
    <span class="badge bg-primary">{{ __('messages.role_admin') }}</span>
@elseif ($roleName === 'User')
    <span class="badge bg-info">{{ __('messages.role_user') }}</span>
@elseif ($roleName === 'Staff')
    <span class="badge bg-success">{{ __('messages.role_staff') }}</span>
@else
    {{ $roleName }}
@endif
