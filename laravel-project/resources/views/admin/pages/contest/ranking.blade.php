@extends('admin.layouts.app-layout')

@section('title', __('button.ranking') . ' - ' . $contest->name)

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
    <h3 class="mb-0">{{ $contest->name }} - {{ __('button.ranking') }}</h3>
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{ __('breadcrumb.dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.contests.index') }}">{{ __('label.contest_management') }}</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ __('button.ranking') }}</li>
    </ol>
</div>

<div class="row">
    <!-- Temporary Rank Column -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="mb-0 text-primary">
                    <i class="material-symbols-outlined fs-20 me-1 align-middle">pending_actions</i>
                    {{ __('label.temporary_rank') }}
                </h5>
                <p class="text-muted small mb-0">Participants still in progress.</p>
            </div>
            <div class="card-body p-0 pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Participant</th>
                                <th class="text-end pe-4">Total Steps</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($temporaryRank as $index => $row)
                            <tr>
                                <td class="ps-4 fw-bold text-primary">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 d-flex align-items-center justify-content-center">
                                            <span class="avatar-text rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($row->user->fullname ?? $row->user->username ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark">{{ $row->user->fullname ?? $row->user->username }}</h6>
                                            <small class="text-muted">{{ $row->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-4 fw-bold">{{ number_format($row->total_steps) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    No participants available.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Final Rank Column -->
    <div class="col-lg-6 mb-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white border-bottom-0 pb-0 pt-4 px-4">
                <h5 class="mb-0 text-success">
                    <i class="material-symbols-outlined fs-20 me-1 align-middle">emoji_events</i>
                    {{ __('label.final_rank') }}
                </h5>
                <p class="text-muted small mb-0">Participants who have completed the target (Top {{ $contest->win_limit }}).</p>
            </div>
            <div class="card-body p-0 pt-3">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Participant</th>
                                <th class="text-end pe-4">Total Steps</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($finalRank as $index => $row)
                            <tr>
                                <td class="ps-4 fw-bold text-success">{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm me-3 d-flex align-items-center justify-content-center">
                                            <span class="avatar-text rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                {{ strtoupper(substr($row->user->fullname ?? $row->user->username ?? 'U', 0, 1)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 text-dark">{{ $row->user->fullname ?? $row->user->username }}</h6>
                                            <small class="text-muted">{{ $row->user->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-4 fw-bold">{{ number_format($row->total_steps) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">
                                    No winners yet.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
