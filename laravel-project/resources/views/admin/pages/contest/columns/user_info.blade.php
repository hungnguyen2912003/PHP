@php
    $fullname = $row->user->fullname ?? $row->user->username ?? 'User';
    $initial = strtoupper(substr($fullname, 0, 1));
    $bgClass = $row->status == \App\Models\ContestDetail::STATUS_COMPLETED ? 'bg-success' : 'bg-primary';
@endphp

<div class="user-info d-flex align-items-center">
    <div class="img position-relative me-3 text-center d-flex align-items-center justify-content-center">
        <span class="avatar-text rounded-circle {{ $bgClass }} text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            {{ $initial }}
        </span>
    </div>
    <div class="info">
        <span class="d-block text-dark fw-bold mb-0" style="font-size: 14px;">{{ $fullname }}</span>
        <span class="d-block text-muted font-12">{{ $row->user->email ?? '' }}</span>
    </div>
</div>
