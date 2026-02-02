@php $roleName = optional($user->role)->name; @endphp
@if ($roleName === 'Admin')
    <span class="badge bg-primary">{{ __('admin/pages/users/table.values.role.admin') }}</span>
@elseif ($roleName === 'User')
    <span class="badge bg-info">{{ __('admin/pages/users/table.values.role.user') }}</span>
@elseif ($roleName === 'Staff')
    <span class="badge bg-success">{{ __('admin/pages/users/table.values.role.staff') }}</span>
@else
    {{ $roleName }}
@endif