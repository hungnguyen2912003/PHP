@php $roleName = optional($user->role)->name; @endphp
@if ($roleName === 'Admin')
    <span class="badge bg-primary">{{ __('value.role.admin') }}</span>
@elseif ($roleName === 'User')
    <span class="badge bg-info">{{ __('value.role.user') }}</span>
@elseif ($roleName === 'Staff')
    <span class="badge bg-success">{{ __('value.role.staff') }}</span>
@else
    {{ $roleName }}
@endif