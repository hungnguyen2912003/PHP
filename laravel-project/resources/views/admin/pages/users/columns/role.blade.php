@php $roleLabel = strtolower($user->role); @endphp
@if ($roleLabel === 'admin')
    <span class="badge bg-primary">{{ __('value.role.admin') }}</span>
@elseif ($roleLabel === 'user')
    <span class="badge bg-info">{{ __('value.role.user') }}</span>
@elseif ($roleLabel === 'staff')
    <span class="badge bg-success">{{ __('value.role.staff') }}</span>
@else
    {{ $user->role }}
@endif