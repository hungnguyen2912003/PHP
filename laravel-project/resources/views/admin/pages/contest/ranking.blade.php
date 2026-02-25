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
            <div class="card-body p-4 pt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="temporary-ranking-table">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Participant</th>
                                <th class="text-end pe-3">Total Steps</th>
                            </tr>
                        </thead>
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
            <div class="card-body p-4 pt-2">
                <div class="table-responsive">
                    <table class="table table-hover align-middle" id="final-ranking-table">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-3">#</th>
                                <th>Participant</th>
                                <th class="text-end pe-3">Total Steps</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        const d_locale = '{{ app()->getLocale() }}';
        const d_url = '{{ asset('lang') }}/' + d_locale + '/datatable.json';

        // Temporary Ranking Table
        $('#temporary-ranking-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            ajax: '{!! route('admin.contests.ranking-data', ['id' => $contest->id, 'type' => 'temporary']) !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, width: '50px', className: 'text-center fw-bold text-primary ps-3' },
                { data: 'user_info', name: 'user.full_name', orderable: false },
                { data: 'total_steps', name: 'total_steps', searchable: false, width: '120px', className: 'text-end pe-3' }
            ],
            language: { url: d_url },
            dom: 'Brt', // Removed 'p' (pagination) and 'i' (info)
            order: [[2, 'desc']] // Sort by total_steps by default
        });

        // Final Ranking Table
        $('#final-ranking-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            ajax: '{!! route('admin.contests.ranking-data', ['id' => $contest->id, 'type' => 'final']) !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, width: '50px', className: 'text-center fw-bold text-success ps-3' },
                { data: 'user_info', name: 'user.full_name', orderable: false },
                { data: 'total_steps', name: 'total_steps', searchable: false, width: '120px', className: 'text-end pe-3' }
            ],
            language: { url: d_url },
            dom: 'Brt', // Removed 'p' (pagination) and 'i' (info)
            order: [] // Ordering handled in controller for final (by end_at)
        });
    });
</script>
@endpush
