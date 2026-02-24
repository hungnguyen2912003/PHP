@extends('admin.layouts.app-layout')

@section('title', __('title.show_contest'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.show_contest') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a class="d-flex align-items-center text-decoration-none" href="{{ route('admin.dashboard') }}">
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">{{ __('breadcrumb.dashboard') }}</span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('breadcrumb.contest_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.show_contest') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                    <h3 class="mb-20">
                        {{ __('label.contest_information') }}
                    </h3>
                    <div class="row">
                        <div class="col-lg-9">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.contest_name') }} (JA)</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->getTranslation('name', 'ja', false) }}" disabled />
                                            <label>{{ __('placeholder.contest_name') }} (JA)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.contest_name') }} (EN)</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->getTranslation('name', 'en', false) }}" disabled />
                                            <label>{{ __('placeholder.contest_name') }} (EN)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.contest_name') }} (ZH)</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->getTranslation('name', 'zh', false) }}" disabled />
                                            <label>{{ __('placeholder.contest_name') }} (ZH)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.type') }}</label>
                                        <div class="form-floating">
                                            @php
                                                $types = [
                                                    1 => __('value.contest_type.walking'),
                                                    2 => __('value.contest_type.running'),
                                                    3 => __('value.contest_type.cycling'),
                                                    4 => __('value.contest_type.swimming'),
                                                ];
                                            @endphp
                                            <input class="form-control" type="text" value="{{ $types[$contest->type] ?? $contest->type }}" disabled />
                                            <label>{{ __('label.type') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.target') }}</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->target }}" disabled />
                                            <label>{{ __('placeholder.target') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.reward_points') }}</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->reward_points }}" disabled />
                                            <label>{{ __('placeholder.reward_points') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.win_limit') }}</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->win_limit }}" disabled />
                                            <label>{{ __('placeholder.win_limit') }}</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.start_date') }}</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->start_date ? $contest->start_date->format('Y-m-d') : '' }}" disabled />
                                            <label>{{ __('label.start_date') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.end_date') }}</label>
                                        <div class="form-floating">
                                            <input class="form-control" type="text" value="{{ $contest->end_date ? $contest->end_date->format('Y-m-d') : '' }}" disabled />
                                            <label>{{ __('label.end_date') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.status') }}</label>
                                        <div class="form-floating">
                                            @php
                                                $statusKey = match($contest->status) {
                                                    \App\Models\Contest::STATUS_INPROGRESS => 'inprogress',
                                                    \App\Models\Contest::STATUS_COMPLETED => 'completed',
                                                    \App\Models\Contest::STATUS_CANCELLED => 'cancelled',
                                                    default => 'unknown',
                                                };
                                                $translatedStatus = __('value.status.' . $statusKey);
                                            @endphp
                                            <input class="form-control" type="text" value="{{ $translatedStatus }}" disabled />
                                            <label>{{ __('label.status') }}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">{{ __('label.image') }}</label>
                                <div class="border rounded-3 p-3 h-100 d-flex flex-column align-items-center justify-content-center" style="background-color: #e9ecef;">
                                    @if($contest->image_url)
                                        <img src="{{ asset($contest->image_url) }}" alt="Contest Image" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                    @else
                                        <p class="text-secondary mb-0">{{ __('value.not_available') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.description') }} (JA)</label>
                                        <textarea class="form-control" rows="4" disabled>{{ $contest->getTranslation('description', 'ja', false) ?: __('value.not_available') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.description') }} (EN)</label>
                                        <textarea class="form-control" rows="4" disabled>{{ $contest->getTranslation('description', 'en', false) ?: __('value.not_available') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">{{ __('label.description') }} (ZH)</label>
                                        <textarea class="form-control" rows="4" disabled>{{ $contest->getTranslation('description', 'zh', false) ?: __('value.not_available') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mt-4 text-center">
                            <a href="{{ route('admin.contests.edit', $contest->id) }}" class="btn btn-primary fw-normal text-white">
                                {{ __('button.edit') }}
                            </a>
                            <a href="{{ route('admin.contests.index') }}" class="btn btn-secondary fw-normal text-white ms-2">
                                {{ __('button.back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
