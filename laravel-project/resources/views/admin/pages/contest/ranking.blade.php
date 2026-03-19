@extends('admin.layouts.app-layout')

@section('title', __('button.ranking') . ' - ' . $contest->name)

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">{{ $contest->name }} - {{ __('button.ranking') }}</h3>
            <ol class="breadcrumb align-items-center mb-0 lh-1">
                <li class="breadcrumb-item">
                    <a
                        class="d-flex align-items-center text-decoration-none"
                        href="{{ route('admin.dashboard') }}"
                    >
                        <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                        <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a class="text-decoration-none" href="{{ route('admin.contests.index') }}">
                        <span class="text-body fs-14 hover">
                            {{ __('label.contest_management') }}
                        </span>
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <span class="text-secondary">{{ __('button.ranking') }}</span>
                </li>
            </ol>
        </div>

        <div class="row">
            <!-- Temporary Rank Column -->
            <div class="col-lg-6 mb-4">
                <div class="card bg-white rounded-10 border border-white h-100 mb-4">
                    <div
                        class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-20"
                    >
                        <div>
                            <h5 class="mb-1 text-primary">
                                <i class="material-symbols-outlined fs-20 me-1 align-middle">
                                    pending_actions
                                </i>
                                {{ __('label.temporary_rank') }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {{ __('label.temporary_rank_desc') }}
                            </p>
                        </div>
                    </div>
                    <div class="default-table-area mx-minus-1 style-two table-list">
                        <div class="table-responsive">
                            <table class="table align-middle w-100" id="temporary-ranking-table">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">{{ __('label.stt') }}</th>
                                        <th class="text-nowrap">{{ __('label.participants') }}</th>
                                        <th class="text-nowrap">{{ __('label.start_at') }}</th>
                                        <th class="text-nowrap">{{ __('label.end_at') }}</th>
                                        <th class="text-center text-nowrap">
                                            {{ __('label.duration') }}
                                        </th>
                                        <th class="text-end pe-3 text-nowrap">
                                            {{ __('label.total_steps') }}
                                        </th>
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
                    <div
                        class="d-flex justify-content-between align-items-center flex-wrap gap-3 p-20"
                    >
                        <div>
                            <h5 class="mb-1 text-success">
                                <i class="material-symbols-outlined fs-20 me-1 align-middle">
                                    emoji_events
                                </i>
                                {{ __('label.final_rank') }}
                            </h5>
                            <p class="text-muted small mb-0">
                                {{ __('label.final_rank_desc') }}
                            </p>
                        </div>
                        @if ($contest->calculate_at)
                            <div id="countdown-container">
                                <span
                                    id="countdown-badge"
                                    class="badge rounded-pill px-3 py-2 fs-13"
                                >
                                    <i class="ri-time-line me-1"></i>
                                    <span id="countdown-text">--:--:--</span>
                                </span>
                            </div>
                        @endif
                    </div>
                    <div class="default-table-area mx-minus-1 style-two table-list">
                        <div class="table-responsive">
                            <table class="table align-middle w-100" id="final-ranking-table">
                                <thead>
                                    <tr>
                                        <th class="text-nowrap">{{ __('label.stt') }}</th>
                                        <th class="text-nowrap">{{ __('label.participants') }}</th>
                                        <th class="text-nowrap">{{ __('label.start_at') }}</th>
                                        <th class="text-nowrap">{{ __('label.end_at') }}</th>
                                        <th class="text-nowrap">{{ __('label.duration') }}</th>
                                        <th class="text-end text-nowrap">
                                            {{ __('label.total_steps') }}
                                        </th>
                                        <th class="text-end pe-3 text-nowrap">
                                            {{ __('label.reward_points') }}
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Action Buttons -->
        <div class="d-flex gap-3 justify-content-center mb-4">
            @if ($contest->status === \App\Models\Contest::STATUS_FINALIZED)
                <a
                    href="{{ route('admin.contests.export-ranking', $contest->id) }}"
                    class="btn btn-primary px-4 py-3 rounded-pill shadow-sm text-white"
                >
                    <i class="ri-download-line me-1"></i>
                    {{ __('button.export') }}
                </a>
            @else
                <button
                    class="btn btn-primary px-4 py-3 rounded-pill shadow-sm text-white"
                    disabled
                >
                    <i class="ri-download-line me-1"></i>
                    {{ __('button.export') }}
                </button>
            @endif
            <a
                href="{{ route('admin.contests.index') }}"
                class="btn btn-secondary px-4 py-3 rounded-pill shadow-sm"
            >
                <i class="ri-arrow-left-line me-1"></i>
                {{ __('button.back') }}
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            const d_locale = '{{ app()->getLocale() }}';
            const d_url = '{{ asset('lang') }}/' + d_locale + '/datatable.json';

            $.extend(true, $.fn.dataTable.defaults, {
                dom: '<"table-responsive"t><"d-flex justify-content-between align-items-center flex-wrap px-4 py-3 border-top"<"text-muted small"i><"mb-0"p>>',
            });

            // Temporary Ranking Table
            $('#temporary-ranking-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                info: true,
                ajax: '{!! route('admin.contests.ranking-data', ['id' => $contest->id, 'type' => 'temporary']) !!}',
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        width: '10%',
                        className: 'text-center fw-bold text-primary ps-3',
                    },
                    { data: 'user_info', name: 'user.full_name', orderable: false, width: '30%' },
                    {
                        data: 'start_at',
                        name: 'start_at',
                        searchable: false,
                        orderable: false,
                        width: '20%',
                        className: 'text-center text-nowrap',
                    },
                    {
                        data: 'end_at',
                        name: 'end_at',
                        searchable: false,
                        orderable: false,
                        width: '20%',
                        className: 'text-center text-nowrap',
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        searchable: false,
                        orderable: false,
                        width: '20%',
                        className: 'text-center text-nowrap',
                    },
                    {
                        data: 'total_steps',
                        name: 'total_steps',
                        searchable: false,
                        orderable: false,
                        width: '20%',
                        className: 'text-end pe-3 text-nowrap',
                    },
                ],
                language: { url: d_url },
                dom: '<"table-responsive"t><"d-flex justify-content-between align-items-center flex-wrap px-4 py-3 border-top"<"text-muted small"i><"mb-0"p>>',
                pageLength: 10,
                order: [[]],
            });

            // Final Ranking Table
            const finalTable = $('#final-ranking-table').DataTable({
                processing: true,
                serverSide: true,
                paging: true,
                info: true,
                ajax: '{!! route('admin.contests.ranking-data', ['id' => $contest->id, 'type' => 'final']) !!}',
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false,
                        width: '8%',
                        className: 'text-center fw-bold text-success ps-3',
                    },
                    { data: 'user_info', name: 'user.full_name', orderable: false, width: '25%' },
                    {
                        data: 'start_at',
                        name: 'start_at',
                        searchable: false,
                        orderable: false,
                        width: '17%',
                        className: 'text-center text-nowrap',
                    },
                    {
                        data: 'end_at',
                        name: 'end_at',
                        searchable: false,
                        orderable: false,
                        width: '17%',
                        className: 'text-center text-nowrap',
                    },
                    {
                        data: 'duration',
                        name: 'duration',
                        searchable: false,
                        orderable: false,
                        width: '13%',
                        className: 'text-center text-nowrap',
                    },
                    {
                        data: 'total_steps',
                        name: 'total_steps',
                        searchable: false,
                        orderable: false,
                        width: '15%',
                        className: 'text-end text-nowrap',
                    },
                    {
                        data: 'reward_points',
                        name: 'reward_points',
                        searchable: false,
                        orderable: false,
                        width: '12%',
                        className: 'text-end pe-3 text-nowrap',
                    },
                ],
                language: { url: d_url },
                dom: '<"table-responsive"t><"d-flex justify-content-between align-items-center flex-wrap px-4 py-3 border-top"<"text-muted small"i><"mb-0"p>>',
                pageLength: 10,
                order: [[]],
            });

            // Real-time Countdown Timer for calculate_at
            @if($contest->calculate_at)
            (function () {
                const calculateAt = new Date('{{ $contest->calculate_at->toIso8601String() }}').getTime();
                const badge = document.getElementById('countdown-badge');
                const text = document.getElementById('countdown-text');
                const isFinalized = {{ $contest->status === \App\Models\Contest::STATUS_FINALIZED ? 'true' : 'false' }};

                function updateCountdown() {
                    const now = Date.now();
                    const diff = calculateAt - now;

                    if (isFinalized) {
                        badge.className = 'badge rounded-pill px-3 py-2 fs-13 bg-success';
                        text.textContent = '{{ __("label.ranking_finalized") }}';
                        return;
                    }

                    if (diff <= 0) {
                        badge.className = 'badge rounded-pill px-3 py-2 fs-13 bg-info text-white';
                        text.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>{{ __("label.calculating_ranking") }}';
                        return;
                    }

                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((diff % (1000 * 60)) / 1000);

                    badge.className = 'badge rounded-pill px-3 py-2 fs-13 bg-warning text-dark';

                    let timeStr = '';
                    if (days > 0) {
                        timeStr = days + 'd ' +
                            String(hours).padStart(2, '0') + ':' +
                            String(minutes).padStart(2, '0') + ':' +
                            String(seconds).padStart(2, '0');
                    } else {
                        timeStr = String(hours).padStart(2, '0') + ':' +
                            String(minutes).padStart(2, '0') + ':' +
                            String(seconds).padStart(2, '0');
                    }

                    text.textContent = timeStr;
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            })();
            @endif
        });
    </script>
@endpush
