@extends('admin.layouts.app-layout')

@section('title', __('button.ranking') . ' - ' . $contest->name)

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ $contest->name }} - {{ __('button.ranking') }}</h3>
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item"><a class="text-decoration-none" href="{{ route('admin.contests.index') }}"><span class="text-body fs-14 hover">{{ __('label.contest_management') }}</span></a></li>
                <li class="breadcrumb-item active" aria-current="page"><span class="text-secondary">{{ __('button.ranking') }}</span></li>
            </ol>
        </div>

        <div class="row">
            <!-- Temporary Rank Column -->
            <div class="col-lg-6 mb-4">
                <div class="card bg-white rounded-10 border border-white h-100 mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-20">
                        <div>
                            <h5 class="mb-1 text-primary">
                                <i class="material-symbols-outlined fs-20 me-1 align-middle">pending_actions</i>
                                {{ __('label.temporary_rank') }}
                            </h5>
                            <p class="text-muted small mb-0">{{ __('label.temporary_rank_desc') }}</p>
                        </div>
                    </div>
                    <div class="default-table-area mx-minus-1 style-two table-list">
                        <div class="table-responsive">
                            <table class="table align-middle w-100" id="temporary-ranking-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('label.stt') }}</th>
                                        <th>{{ __('label.participants') }}</th>
                                        <th>{{ __('label.start_at') }}</th>
                                        <th>{{ __('label.end_at') }}</th>
                                        <th class="text-end pe-3">{{ __('label.total_steps') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Rank Column -->
            <div class="col-lg-6 mb-4">
                <div class="card bg-white rounded-10 border border-white h-100 mb-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-20">
                        <div>
                            <h5 class="mb-1 text-success">
                                <i class="material-symbols-outlined fs-20 me-1 align-middle">emoji_events</i>
                                {{ __('label.final_rank') }}
                            </h5>
                            <p class="text-muted small mb-0">{{ __('label.final_rank_desc', ['limit' => $contest->win_limit]) }}</p>
                        </div>
                    </div>
                    <div class="default-table-area mx-minus-1 style-two table-list">
                        <div class="table-responsive">
                            <table class="table align-middle w-100" id="final-ranking-table">
                                <thead>
                                    <tr>
                                        <th>{{ __('label.stt') }}</th>
                                        <th>{{ __('label.participants') }}</th>
                                        <th>{{ __('label.start_at') }}</th>
                                        <th>{{ __('label.end_at') }}</th>
                                        <th class="text-end pe-3">{{ __('label.total_steps') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
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
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, width: '10%', className: 'text-center fw-bold text-primary ps-3' },
                { data: 'user_info', name: 'user.full_name', orderable: false, width: '30%' },
                { data: 'start_at', name: 'start_at', searchable: false, orderable: false, width: '20%', className: 'text-center text-nowrap' },
                { data: 'end_at', name: 'end_at', searchable: false, orderable: false, width: '20%', className: 'text-center text-nowrap' },
                { data: 'total_steps', name: 'total_steps', searchable: false, orderable: false, width: '20%', className: 'text-end pe-3 text-nowrap' }
            ],
            language: { url: d_url },
            dom: 'Brt',
            order: [[]]
        });

        // Final Ranking Table
        $('#final-ranking-table').DataTable({
            processing: true,
            serverSide: true,
            paging: false,
            info: false,
            ajax: '{!! route('admin.contests.ranking-data', ['id' => $contest->id, 'type' => 'final']) !!}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, width: '10%', className: 'text-center fw-bold text-success ps-3' },
                { data: 'user_info', name: 'user.full_name', orderable: false, width: '30%' },
                { data: 'start_at', name: 'start_at', searchable: false, orderable: false, width: '20%', className: 'text-center text-nowrap' },
                { data: 'end_at', name: 'end_at', searchable: false, orderable: false, width: '20%', className: 'text-center text-nowrap' },
                { data: 'total_steps', name: 'total_steps', searchable: false, orderable: false, width: '20%', className: 'text-end pe-3 text-nowrap' }
            ],
            language: { url: d_url },
            dom: 'Brt',
            order: [[]]
        });
    });
</script>
@endpush
