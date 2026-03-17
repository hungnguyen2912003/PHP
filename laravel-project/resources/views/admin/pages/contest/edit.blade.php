@extends('admin.layouts.app-layout')

@section('title', __('title.edit_contest'))

@section('content')
    <div class="main-content-container overflow-hidden">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 mt-1">
            <h3 class="mb-0">
                {{ __('title.edit_contest') }}
            </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb align-items-center mb-0 lh-1">
                    <li class="breadcrumb-item">
                        <a
                            class="d-flex align-items-center text-decoration-none"
                            href="{{ route('admin.dashboard') }}"
                        >
                            <i class="ri-home-8-line fs-15 text-primary me-1"></i>
                            <span class="text-body fs-14 hover">
                                {{ __('breadcrumb.dashboard') }}
                            </span>
                        </a>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span>{{ __('breadcrumb.contest_management') }}</span>
                    </li>
                    <li aria-current="page" class="breadcrumb-item active">
                        <span class="text-secondary">{{ __('title.edit_contest') }}</span>
                    </li>
                </ol>
            </nav>
        </div>

        <form
            id="common-form"
            action="{{ route('admin.contests.update', $contest->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card bg-white p-20 rounded-10 border border-white mb-4">
                        {{-- Tab Navigation --}}
                        <ul class="ps-0 mb-4 list-unstyled d-flex flex-wrap gap-2 gap-lg-3">
                            <li>
                                <a
                                    class="d-inline-flex align-items-center justify-content-center btn btn-primary border-primary bg-primary text-white fs-16 fw-normal py-2 px-3 px-lg-4 tab-btn active"
                                    style="line-height: 1.5; min-height: 42px"
                                    href="javascript:void(0)"
                                    data-tab="general"
                                >
                                    <i class="ri-settings-3-line me-1"></i>
                                    {{ __('label.general') }}
                                </a>
                            </li>
                            <li>
                                <a
                                    class="d-inline-flex align-items-center justify-content-center btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal py-2 px-3 px-lg-4 tab-btn"
                                    style="line-height: 1.5; min-height: 42px"
                                    href="javascript:void(0)"
                                    data-tab="en"
                                >
                                    <svg
                                        class="me-2"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <circle cx="10" cy="10" r="10" fill="#F2F0F2" />
                                        <mask
                                            id="mask0_2_249"
                                            style="mask-type: alpha"
                                            maskUnits="userSpaceOnUse"
                                            x="0"
                                            y="0"
                                            width="20"
                                            height="20"
                                        >
                                            <circle cx="10" cy="10" r="10" fill="#FCFCFC" />
                                        </mask>
                                        <g mask="url(#mask0_2_249)">
                                            <rect
                                                x="3.25"
                                                y="17.75"
                                                width="13.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="3.25"
                                                y="17.75"
                                                width="13.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="0.25"
                                                y="12.75"
                                                width="19.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="0.25"
                                                y="12.75"
                                                width="19.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="0.25"
                                                y="7.5"
                                                width="19.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="0.25"
                                                y="7.5"
                                                width="19.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="0.25"
                                                y="2.5"
                                                width="19.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect
                                                x="0.25"
                                                y="2.5"
                                                width="19.75"
                                                height="2.5"
                                                fill="#D90026"
                                            />
                                            <rect width="10.25" height="10" fill="#0052B5" />
                                            <path
                                                d="M8.25 8.375L7.5 8.75L7.75 8L7.25 7.5H8L8.25 6.75L8.625 7.5H9.25L8.75 8L9 8.75L8.25 8.375Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M4.75 8.375L4 8.75L4.25 8L3.75 7.5H4.5L4.75 6.75L5.125 7.5H5.75L5.25 8L5.5 8.75L4.75 8.375Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M1.25 8.375L0.5 8.75L0.75 8L0.25 7.5H1L1.25 6.75L1.625 7.5H2.25L1.75 8L2 8.75L1.25 8.375Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M8.25 5.625L7.5 6L7.75 5.25L7.25 4.75H8L8.25 4L8.625 4.75H9.25L8.75 5.25L9 6L8.25 5.625Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M8.25 2.875L7.5 3.25L7.75 2.5L7.25 2H8L8.25 1.25L8.625 2H9.25L8.75 2.5L9 3.25L8.25 2.875Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M8.25 0.125L7.5 0.5L7.75 -0.25L7.25 -0.75H8L8.25 -1.5L8.625 -0.75H9.25L8.75 -0.25L9 0.5L8.25 0.125Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M4.75 2.875L4 3.25L4.25 2.5L3.75 2H4.5L4.75 1.25L5.125 2H5.75L5.25 2.5L5.5 3.25L4.75 2.875Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M4.75 5.625L4 6L4.25 5.25L3.75 4.75H4.5L4.75 4L5.125 4.75H5.75L5.25 5.25L5.5 6L4.75 5.625Z"
                                                fill="#EFEFEF"
                                            />
                                            <path
                                                d="M1.25 5.625L0.5 6L0.75 5.25L0.25 4.75H1L1.25 4L1.625 4.75H2.25L1.75 5.25L2 6L1.25 5.625Z"
                                                fill="#EFEFEF"
                                            />
                                        </g>
                                    </svg>

                                    {{ __('label.lang_en') }}
                                </a>
                            </li>
                            <li>
                                <a
                                    class="d-inline-flex align-items-center justify-content-center btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal py-2 px-3 px-lg-4 tab-btn"
                                    style="line-height: 1.5; min-height: 42px"
                                    href="javascript:void(0)"
                                    data-tab="ja"
                                >
                                    <svg
                                        class="me-2"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10Z"
                                            fill="#FCFCFC"
                                        />
                                        <path
                                            d="M14.25 10C14.25 12.3472 12.3472 14.25 10 14.25C7.65279 14.25 5.75 12.3472 5.75 10C5.75 7.65279 7.65279 5.75 10 5.75C12.3472 5.75 14.25 7.65279 14.25 10Z"
                                            fill="#D90026"
                                        />
                                    </svg>
                                    {{ __('label.lang_ja') }}
                                </a>
                            </li>
                            <li>
                                <a
                                    class="d-inline-flex align-items-center justify-content-center btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal py-2 px-3 px-lg-4 tab-btn"
                                    style="line-height: 1.5; min-height: 42px"
                                    href="javascript:void(0)"
                                    data-tab="zh"
                                >
                                    <svg
                                        class="me-2"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M10 20C4.47715 20 -2.41411e-07 15.5228 0 10C2.41411e-07 4.47715 4.47715 -2.41411e-07 10 0C15.5228 2.41411e-07 20 4.47715 20 10C20 15.5228 15.5228 20 10 20Z"
                                            fill="#D90026"
                                        />
                                        <path
                                            d="M11.4809 6.24914L10.498 6.14329L11.2239 5.55857L11.0464 4.744L11.7904 5.22186L12.5163 4.63714L12.4104 5.62007L13.0304 6.01828L12.2159 6.19571L11.986 7.099L11.4809 6.24914Z"
                                            fill="#FFDB44"
                                        />
                                        <path
                                            d="M5.5 11.7812L3.0625 13L3.875 10.5625L2.25 8.9375H4.6875L5.5 6.5L6.71875 8.9375H8.75L7.125 10.5625L7.9375 13L5.5 11.7812Z"
                                            fill="#FFDB44"
                                        />
                                        <path
                                            d="M11.4809 13.7591L10.498 13.865L11.2239 14.4497L11.0464 15.2643L11.7904 14.7864L12.5163 15.3711L12.4104 14.3882L13.0304 13.99L12.2159 13.8126L11.986 12.9093L11.4809 13.7591Z"
                                            fill="#FFDB44"
                                        />
                                        <path
                                            d="M13.8535 8.89263L12.942 8.50986L13.8049 8.15737L13.868 7.3261L14.4441 7.99691L15.307 7.64442L14.9242 8.55593L15.4043 9.11494L14.573 9.0518L14.0942 9.8515L13.8535 8.89263Z"
                                            fill="#FFDB44"
                                        />
                                        <path
                                            d="M13.8535 11.6825L12.942 12.0652L13.8049 12.4177L13.868 13.249L14.4441 12.5782L15.307 12.9307L14.9242 12.0192L15.4043 11.4602L14.573 11.5233L14.0942 10.7236L13.8535 11.6825Z"
                                            fill="#FFDB44"
                                        />
                                    </svg>

                                    {{ __('label.lang_zh') }}
                                </a>
                            </li>
                            <li>
                                <a
                                    class="d-inline-flex align-items-center justify-content-center btn btn-primary border-border-color-70 bg-transparent text-secondary fs-16 fw-normal py-2 px-3 px-lg-4 tab-btn"
                                    style="line-height: 1.5; min-height: 42px"
                                    href="javascript:void(0)"
                                    data-tab="vi"
                                >
                                    <svg
                                        class="me-2"
                                        width="20"
                                        height="20"
                                        viewBox="0 0 20 20"
                                        fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <g clip-path="url(#clip0_4_7329)">
                                            <path
                                                d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z"
                                                fill="#D80027"
                                            />
                                            <path
                                                d="M10 5.21729L11.0792 8.53873H14.5716L11.7462 10.5915L12.8254 13.9129L10 11.8602L7.17464 13.9129L8.25386 10.5915L5.42847 8.53873H8.92081L10 5.21729Z"
                                                fill="#FFDA44"
                                            />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_4_7329">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>

                                    {{ __('label.lang_vi') }}
                                </a>
                            </li>
                        </ul>

                        {{-- Tab: General --}}
                        <div class="tab-content-panel" id="tab-general">
                            <h4 class="fw-semibold fs-18 mb-20">
                                {{ __('label.contest_information') }}
                            </h4>
                            <div class="row">
                                <div class="col-lg-9">
                                    <div class="row">
                                        {{-- Row 1: Type, Target --}}
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label class="label fs-16 mb-2">
                                                    {{ __('label.type') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-floating">
                                                    <select
                                                        class="form-select form-control"
                                                        id="type"
                                                        name="type"
                                                    >
                                                        <option
                                                            value="1"
                                                            {{ old('type', $contest->type) == '1' ? 'selected' : '' }}
                                                        >
                                                            {{ __('value.contest_type.walk') }}
                                                        </option>
                                                        <option
                                                            value="2"
                                                            {{ old('type', $contest->type) == '2' ? 'selected' : '' }}
                                                        >
                                                            {{ __('value.contest_type.run') }}
                                                        </option>
                                                        <option
                                                            value="3"
                                                            {{ old('type', $contest->type) == '3' ? 'selected' : '' }}
                                                        >
                                                            {{ __('value.contest_type.sprint') }}
                                                        </option>
                                                    </select>
                                                    <label for="type">
                                                        {{ __('label.type') }}
                                                    </label>
                                                </div>
                                                @error('type')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-20">
                                                <label class="label fs-16 mb-2">
                                                    {{ __('label.target') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-floating">
                                                    <input
                                                        class="form-control"
                                                        id="target"
                                                        name="target"
                                                        type="number"
                                                        placeholder="{{ __('placeholder.target') }}"
                                                        value="{{ old('target', $contest->target) }}"
                                                    />
                                                    <label for="target">
                                                        {{ __('placeholder.target') }}
                                                    </label>
                                                </div>
                                                @error('target')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>

                                        {{-- Row 2: Start Date, End Date, Calculate At --}}
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label class="label fs-16 mb-2">
                                                    {{ __('label.start_date') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-floating">
                                                    <input
                                                        class="form-control"
                                                        id="start_date"
                                                        name="start_date"
                                                        type="date"
                                                        value="{{ old('start_date', $contest->start_date ? $contest->start_date->format('Y-m-d') : '') }}"
                                                    />
                                                    <label for="start_date">
                                                        {{ __('label.start_date') }}
                                                    </label>
                                                </div>
                                                @error('start_date')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label class="label fs-16 mb-2">
                                                    {{ __('label.end_date') }}
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <div class="form-floating">
                                                    <input
                                                        class="form-control"
                                                        id="end_date"
                                                        name="end_date"
                                                        type="date"
                                                        value="{{ old('end_date', $contest->end_date ? $contest->end_date->format('Y-m-d') : '') }}"
                                                    />
                                                    <label for="end_date">
                                                        {{ __('label.end_date') }}
                                                    </label>
                                                </div>
                                                @error('end_date')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="mb-20">
                                                <label class="label fs-16 mb-2">
                                                    {{ __('label.calculate_at') }}
                                                </label>
                                                <div class="form-floating">
                                                    <input
                                                        class="form-control"
                                                        id="calculate_at"
                                                        name="calculate_at"
                                                        type="datetime-local"
                                                        value="{{ old('calculate_at', $contest->calculate_at ? $contest->calculate_at->format('Y-m-d\TH:i') : '') }}"
                                                    />
                                                    <label for="calculate_at">
                                                        {{ __('label.calculate_at') }}
                                                    </label>
                                                </div>
                                                <small class="text-muted">
                                                    {{ __('label.calculate_at_hint') }}
                                                </small>
                                                @error('calculate_at')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.image') }}
                                        </label>
                                        <div
                                            class="border rounded-3 p-3 h-100 d-flex align-items-center"
                                        >
                                            <div class="w-100">
                                                                                                <input
                                                    type="file"
                                                    class="edit-image-filepond"
                                                    id="image"
                                                    name="image"
                                                />
                                                <input
                                                    type="hidden"
                                                    name="remove_image"
                                                    id="remove_image"
                                                    value="0"
                                                />
                                                @error('image')
                                                    <div class="text-danger mt-2">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.reward_points') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-floating">
                                            <input
                                                class="form-control"
                                                id="reward_points"
                                                name="reward_points"
                                                type="number"
                                                placeholder="{{ __('placeholder.reward_points') }}"
                                                value="{{ old('reward_points', $contest->reward_points) }}"
                                            />
                                            <label for="reward_points">
                                                {{ __('placeholder.reward_points') }}
                                            </label>
                                        </div>
                                        @error('reward_points')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.consolation_points') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-floating">
                                            <input
                                                class="form-control"
                                                id="consolation_points"
                                                name="consolation_points"
                                                type="number"
                                                placeholder="{{ __('placeholder.consolation_points') }}"
                                                value="{{ old('consolation_points', $contest->consolation_points) }}"
                                            />
                                            <label for="consolation_points">
                                                {{ __('placeholder.consolation_points') }}
                                            </label>
                                        </div>
                                        @error('consolation_points')
                                            <div class="text-danger mt-1">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted mb-4">{{ __('label.reward_settings_hint') }}</p>

                            <div class="table-responsive">
                                <table class="table table-bordered align-middle" id="reward-settings-table">
                                    <thead class="bg-light">
                                        <tr>
                                            <th width="80" class="text-center">#</th>
                                            <th width="150">{{ __('label.rank') }}</th>
                                            <th>{{ __('label.reward_percent') }}</th>
                                            <th width="100" class="text-center">{{ __('label.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reward-rows">
                                        @forelse(old('rewards', $contest->contestRewardSettings) as $index => $reward)
                                            <tr>
                                                <td class="text-center row-number">{{ $loop->iteration }}</td>
                                                <td>
                                                    <span class="rank-display fw-semibold">{{ $reward['rank'] }}</span>
                                                    <input type="hidden" class="rank-input" name="rewards[{{ $index }}][rank]" value="{{ $reward['rank'] }}" />
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input
                                                            class="form-control"
                                                            type="number"
                                                            name="rewards[{{ $index }}][reward_percent]"
                                                            placeholder="{{ __('placeholder.reward_percent') }}"
                                                            value="{{ old("rewards.{$index}.reward_percent", $reward['reward_percent'] ?? '') }}"
                                                            min="0"
                                                            max="100"
                                                        />
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    @error("rewards.{$index}.reward_percent")
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        type="button"
                                                        class="btn-remove-reward remove-reward-row"
                                                        title="{{ __('button.delete') }}"
                                                    >
                                                        <i class="ri-close-line"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr id="empty-reward-row">
                                                <td colspan="4" class="text-center text-muted py-3">
                                                    {{ __('label.no_reward_data') }}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @error('rewards')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                            <div class="mt-2 text-center">
                                <button
                                    type="button"
                                    class="btn-add-tier"
                                    id="add-reward-row"
                                >
                                    <i class="ri-add-circle-line"></i>
                                    {{ __('button.add_reward_tier') }}
                                </button>
                            </div>
                        </div>

                        {{-- Tab: English --}}
                        <div class="tab-content-panel d-none" id="tab-en">
                            <h4 class="fw-semibold fs-18 mb-20">
                                <svg
                                    class="me-1"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <circle cx="10" cy="10" r="10" fill="#F2F0F2" />
                                    <mask
                                        id="mask0_2_249"
                                        style="mask-type: alpha"
                                        maskUnits="userSpaceOnUse"
                                        x="0"
                                        y="0"
                                        width="20"
                                        height="20"
                                    >
                                        <circle cx="10" cy="10" r="10" fill="#FCFCFC" />
                                    </mask>
                                    <g mask="url(#mask0_2_249)">
                                        <rect
                                            x="3.25"
                                            y="17.75"
                                            width="13.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="3.25"
                                            y="17.75"
                                            width="13.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="0.25"
                                            y="12.75"
                                            width="19.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="0.25"
                                            y="12.75"
                                            width="19.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="0.25"
                                            y="7.5"
                                            width="19.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="0.25"
                                            y="7.5"
                                            width="19.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="0.25"
                                            y="2.5"
                                            width="19.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect
                                            x="0.25"
                                            y="2.5"
                                            width="19.75"
                                            height="2.5"
                                            fill="#D90026"
                                        />
                                        <rect width="10.25" height="10" fill="#0052B5" />
                                        <path
                                            d="M8.25 8.375L7.5 8.75L7.75 8L7.25 7.5H8L8.25 6.75L8.625 7.5H9.25L8.75 8L9 8.75L8.25 8.375Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M4.75 8.375L4 8.75L4.25 8L3.75 7.5H4.5L4.75 6.75L5.125 7.5H5.75L5.25 8L5.5 8.75L4.75 8.375Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M1.25 8.375L0.5 8.75L0.75 8L0.25 7.5H1L1.25 6.75L1.625 7.5H2.25L1.75 8L2 8.75L1.25 8.375Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M8.25 5.625L7.5 6L7.75 5.25L7.25 4.75H8L8.25 4L8.625 4.75H9.25L8.75 5.25L9 6L8.25 5.625Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M8.25 2.875L7.5 3.25L7.75 2.5L7.25 2H8L8.25 1.25L8.625 2H9.25L8.75 2.5L9 3.25L8.25 2.875Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M8.25 0.125L7.5 0.5L7.75 -0.25L7.25 -0.75H8L8.25 -1.5L8.625 -0.75H9.25L8.75 -0.25L9 0.5L8.25 0.125Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M4.75 2.875L4 3.25L4.25 2.5L3.75 2H4.5L4.75 1.25L5.125 2H5.75L5.25 2.5L5.5 3.25L4.75 2.875Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M4.75 5.625L4 6L4.25 5.25L3.75 4.75H4.5L4.75 4L5.125 4.75H5.75L5.25 5.25L5.5 6L4.75 5.625Z"
                                            fill="#EFEFEF"
                                        />
                                        <path
                                            d="M1.25 5.625L0.5 6L0.75 5.25L0.25 4.75H1L1.25 4L1.625 4.75H2.25L1.75 5.25L2 6L1.25 5.625Z"
                                            fill="#EFEFEF"
                                        />
                                    </g>
                                </svg>
                                {{ __('label.lang_en') }}
                            </h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.contest_name') }}
                                            <span class="text-danger">*</span>
                                        </label>
                                        <div class="form-floating">
                                            <input
                                                class="form-control"
                                                id="name_en"
                                                name="name[en]"
                                                placeholder="{{ __('placeholder.contest_name') }}"
                                                type="text"
                                                value="{{ old('name.en', $contest->name_en) }}"
                                            />
                                            <label for="name_en">
                                                {{ __('placeholder.contest_name') }}
                                            </label>
                                        </div>
                                        @error('name.en')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.description') }}
                                        </label>
                                        <textarea
                                            class="form-control"
                                            name="description[en]"
                                            placeholder="{{ __('placeholder.description') }}"
                                            rows="5"
                                            style="resize: none"
                                        >
{{ old('description.en', $contest->desc_en) }}</textarea
                                        >
                                        @error('description.en')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab: Japanese --}}
                        <div class="tab-content-panel d-none" id="tab-ja">
                            <h4 class="fw-semibold fs-18 mb-20">
                                <svg
                                    class="me-1"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M20 10C20 15.5228 15.5228 20 10 20C4.47715 20 0 15.5228 0 10C0 4.47715 4.47715 0 10 0C15.5228 0 20 4.47715 20 10Z"
                                        fill="#FCFCFC"
                                    />
                                    <path
                                        d="M14.25 10C14.25 12.3472 12.3472 14.25 10 14.25C7.65279 14.25 5.75 12.3472 5.75 10C5.75 7.65279 7.65279 5.75 10 5.75C12.3472 5.75 14.25 7.65279 14.25 10Z"
                                        fill="#D90026"
                                    />
                                </svg>
                                {{ __('label.lang_ja') }}
                            </h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.contest_name') }}
                                        </label>
                                        <div class="form-floating">
                                            <input
                                                class="form-control"
                                                id="name_ja"
                                                name="name[ja]"
                                                placeholder="{{ __('placeholder.contest_name') }}"
                                                type="text"
                                                value="{{ old('name.ja', $contest->name_ja) }}"
                                            />
                                            <label for="name_ja">
                                                {{ __('placeholder.contest_name') }}
                                            </label>
                                        </div>
                                        @error('name.ja')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.description') }}
                                        </label>
                                        <textarea
                                            class="form-control"
                                            name="description[ja]"
                                            placeholder="{{ __('placeholder.description') }}"
                                            rows="5"
                                            style="resize: none"
                                        >
{{ old('description.ja', $contest->desc_ja) }}</textarea
                                        >
                                        @error('description.ja')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab: Chinese --}}
                        <div class="tab-content-panel d-none" id="tab-zh">
                            <h4 class="fw-semibold fs-18 mb-20">
                                <svg
                                    class="me-1"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        d="M10 20C4.47715 20 -2.41411e-07 15.5228 0 10C2.41411e-07 4.47715 4.47715 -2.41411e-07 10 0C15.5228 2.41411e-07 20 4.47715 20 10C20 15.5228 15.5228 20 10 20Z"
                                        fill="#D90026"
                                    />
                                    <path
                                        d="M11.4809 6.24914L10.498 6.14329L11.2239 5.55857L11.0464 4.744L11.7904 5.22186L12.5163 4.63714L12.4104 5.62007L13.0304 6.01828L12.2159 6.19571L11.986 7.099L11.4809 6.24914Z"
                                        fill="#FFDB44"
                                    />
                                    <path
                                        d="M5.5 11.7812L3.0625 13L3.875 10.5625L2.25 8.9375H4.6875L5.5 6.5L6.71875 8.9375H8.75L7.125 10.5625L7.9375 13L5.5 11.7812Z"
                                        fill="#FFDB44"
                                    />
                                    <path
                                        d="M11.4809 13.7591L10.498 13.865L11.2239 14.4497L11.0464 15.2643L11.7904 14.7864L12.5163 15.3711L12.4104 14.3882L13.0304 13.99L12.2159 13.8126L11.986 12.9093L11.4809 13.7591Z"
                                        fill="#FFDB44"
                                    />
                                    <path
                                        d="M13.8535 8.89263L12.942 8.50986L13.8049 8.15737L13.868 7.3261L14.4441 7.99691L15.307 7.64442L14.9242 8.55593L15.4043 9.11494L14.573 9.0518L14.0942 9.8515L13.8535 8.89263Z"
                                        fill="#FFDB44"
                                    />
                                    <path
                                        d="M13.8535 11.6825L12.942 12.0652L13.8049 12.4177L13.868 13.249L14.4441 12.5782L15.307 12.9307L14.9242 12.0192L15.4043 11.4602L14.573 11.5233L14.0942 10.7236L13.8535 11.6825Z"
                                        fill="#FFDB44"
                                    />
                                </svg>
                                {{ __('label.lang_zh') }}
                            </h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.contest_name') }}
                                        </label>
                                        <div class="form-floating">
                                            <input
                                                class="form-control"
                                                id="name_zh"
                                                name="name[zh]"
                                                placeholder="{{ __('placeholder.contest_name') }}"
                                                type="text"
                                                value="{{ old('name.zh', $contest->name_zh) }}"
                                            />
                                            <label for="name_zh">
                                                {{ __('placeholder.contest_name') }}
                                            </label>
                                        </div>
                                        @error('name.zh')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.description') }}
                                        </label>
                                        <textarea
                                            class="form-control"
                                            name="description[zh]"
                                            placeholder="{{ __('placeholder.description') }}"
                                            rows="5"
                                            style="resize: none"
                                        >
{{ old('description.zh', $contest->desc_zh) }}</textarea
                                        >
                                        @error('description.zh')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tab: Vietnamese --}}
                        <div class="tab-content-panel d-none" id="tab-vi">
                            <h4 class="fw-semibold fs-18 mb-20">
                                <svg
                                    class="me-1"
                                    width="20"
                                    height="20"
                                    viewBox="0 0 20 20"
                                    fill="none"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <g clip-path="url(#clip0_4_7329)">
                                        <path
                                            d="M10 20C15.5228 20 20 15.5228 20 10C20 4.47715 15.5228 0 10 0C4.47715 0 0 4.47715 0 10C0 15.5228 4.47715 20 10 20Z"
                                            fill="#D80027"
                                        />
                                        <path
                                            d="M10 5.21729L11.0792 8.53873H14.5716L11.7462 10.5915L12.8254 13.9129L10 11.8602L7.17464 13.9129L8.25386 10.5915L5.42847 8.53873H8.92081L10 5.21729Z"
                                            fill="#FFDA44"
                                        />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_4_7329">
                                            <rect width="20" height="20" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                {{ __('label.lang_vi') }}
                            </h4>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.contest_name') }}
                                        </label>
                                        <div class="form-floating">
                                            <input
                                                class="form-control"
                                                id="name_vi"
                                                name="name[vi]"
                                                placeholder="{{ __('placeholder.contest_name') }}"
                                                type="text"
                                                value="{{ old('name.vi', $contest->name_vi) }}"
                                            />
                                            <label for="name_vi">
                                                {{ __('placeholder.contest_name') }}
                                            </label>
                                        </div>
                                        @error('name.vi')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-20">
                                        <label class="label fs-16 mb-2">
                                            {{ __('label.description') }}
                                        </label>
                                        <textarea
                                            class="form-control"
                                            name="description[vi]"
                                            placeholder="{{ __('placeholder.description') }}"
                                            rows="5"
                                            style="resize: none"
                                        >
{{ old('description.vi', $contest->desc_vi) }}</textarea
                                        >
                                        @error('description.vi')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Submit buttons --}}
                        <div class="d-flex gap-2 justify-content-center mt-4">
                            <button
                                class="btn btn-primary fw-normal text-white"
                                type="submit"
                                id="submitBtn"
                                data-processing-text="{{ __('button.processing') }}"
                            >
                                <span id="btnText">{{ __('button.save') }}</span>
                                <span
                                    id="btnLoading"
                                    class="spinner-border spinner-border-sm ms-2 d-none"
                                ></span>
                            </button>
                            <a
                                href="{{ route('admin.contests.index') }}"
                                class="btn btn-danger fw-normal text-white"
                            >
                                {{ __('button.cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/custom/common.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const inputElement = document.querySelector('.edit-image-filepond');
            if (inputElement) {
                if (typeof FilePondPluginImagePreview !== 'undefined') {
                    FilePond.registerPlugin(FilePondPluginImagePreview);
                }
                const pond = FilePond.create(inputElement, {
                    allowImagePreview: true,
                    storeAsFile: true,
                    labelIdle: `{!! __('placeholder.drag_drop_file') !!}`,
                    acceptedFileTypes: ['image/png', 'image/jpg', 'image/jpeg'],
                    files: [
                        @if ($contest->image_url)
                            {
                                source: '{{ asset($contest->image_url) }}',
                                options: { type: 'local' },
                            }
                        @endif
                    ],
                    server: {
                        load: (source, load, error, progress, abort, headers) => {
                            fetch(source)
                                .then(response => response.blob())
                                .then(blob => {
                                    const filename = source.split('/').pop().split('?')[0];
                                    load(new File([blob], filename, { type: blob.type }));
                                });
                        },
                    },
                });

                pond.on('removefile', (error, file) => {
                    document.getElementById('remove_image').value = '1';
                });

                pond.on('addfile', (error, file) => {
                    document.getElementById('remove_image').value = '0';
                });

                document.getElementById('common-form').addEventListener('submit', function () {
                    const files = pond.getFiles();
                    if (files.length && files[0].origin === FilePond.FileOrigin.LOCAL) {
                        this.querySelectorAll('input[name="image"]').forEach(el => el.disabled = true);
                    }
                });
            }

            // Tab switching
            const tabBtns = document.querySelectorAll('.tab-btn');
            const tabPanels = document.querySelectorAll('.tab-content-panel');

            tabBtns.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const targetTab = this.getAttribute('data-tab');

                    // Update button styles
                    tabBtns.forEach(function (b) {
                        b.classList.remove('active', 'bg-primary', 'text-white', 'border-primary');
                        b.classList.add('bg-transparent', 'text-secondary', 'border-border-color-70');
                    });
                    this.classList.add('active', 'bg-primary', 'text-white', 'border-primary');
                    this.classList.remove('bg-transparent', 'text-secondary', 'border-border-color-70');

                    // Show/hide panels
                    tabPanels.forEach(function (panel) {
                        panel.classList.add('d-none');
                    });
                    document.getElementById('tab-' + targetTab).classList.remove('d-none');
                });
            });

            // Auto-switch to tab with validation error
            @if($errors->any())
                const errorKeys = @json($errors->keys());
                const langTabs = ['en', 'ja', 'zh', 'vi'];
                let errorTab = null;

                // Priority 1: Check general fields first
                const generalFields = ['type', 'target', 'reward_points', 'start_date', 'end_date', 'calculate_at', 'image', 'rewards'];
                for (const key of errorKeys) {
                    if (generalFields.includes(key) || key.startsWith('rewards.')) {
                        errorTab = 'general';
                        break;
                    }
                }

                // Priority 2: If no general errors, check language fields
                if (!errorTab) {
                    for (const key of errorKeys) {
                        for (const lang of langTabs) {
                            if (key.includes('.' + lang) || key.endsWith('.' + lang)) {
                                errorTab = lang;
                                break;
                            }
                        }
                        if (errorTab) break;
                    }
                }

                if (errorTab) {
                    const targetBtn = document.querySelector('.tab-btn[data-tab="' + errorTab + '"]');
                    if (targetBtn) targetBtn.click();
                }
            @endif

            // Reward settings: add row
            let rewardRowIndex = document.querySelectorAll('#reward-rows tr:not(#empty-reward-row)').length;

            document.getElementById('add-reward-row').addEventListener('click', function () {
                const tbody = document.getElementById('reward-rows');
                // Remove empty state row if exists
                const emptyRow = document.getElementById('empty-reward-row');
                if (emptyRow) emptyRow.remove();

                const nextRank = document.querySelectorAll('#reward-rows tr').length + 1;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="text-center row-number">${nextRank}</td>
                    <td>
                        <span class="rank-display fw-semibold">${nextRank}</span>
                        <input type="hidden" class="rank-input" name="rewards[${rewardRowIndex}][rank]" value="${nextRank}" />
                    </td>
                    <td>
                        <div class="input-group">
                            <input
                                class="form-control"
                                type="number"
                                name="rewards[${rewardRowIndex}][reward_percent]"
                                placeholder="{{ __('placeholder.reward_percent') }}"
                                min="0"
                                max="100"
                            />
                            <span class="input-group-text">%</span>
                        </div>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn-remove-reward remove-reward-row" title="{{ __('button.delete') }}">
                            <i class="ri-close-line"></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(tr);
                rewardRowIndex++;
            });

            // Reward settings: remove row (delegated)
            document.getElementById('reward-rows').addEventListener('click', function (e) {
                const btn = e.target.closest('.remove-reward-row');
                if (btn) {
                    btn.closest('tr').remove();
                    resequenceRewardRows();
                    // Show empty state if no rows left
                    if (document.querySelectorAll('#reward-rows tr').length === 0) {
                        const emptyTr = document.createElement('tr');
                        emptyTr.id = 'empty-reward-row';
                        emptyTr.innerHTML = `<td colspan="4" class="text-center text-muted py-3">{{ __('label.no_reward_data') }}</td>`;
                        document.getElementById('reward-rows').appendChild(emptyTr);
                    }
                }
            });

            // Re-sequence all row numbers, rank values, and input names after add/delete
            function resequenceRewardRows() {
                const rows = document.querySelectorAll('#reward-rows tr:not(#empty-reward-row)');
                rows.forEach(function (row, index) {
                    const rank = index + 1;
                    // Update row number
                    const rowNum = row.querySelector('.row-number');
                    if (rowNum) rowNum.textContent = rank;
                    // Update rank display text
                    const rankDisplay = row.querySelector('.rank-display');
                    if (rankDisplay) rankDisplay.textContent = rank;
                    // Update rank hidden input value
                    const rankInput = row.querySelector('.rank-input');
                    if (rankInput) {
                        rankInput.value = rank;
                        rankInput.name = `rewards[${index}][rank]`;
                    }
                    // Update reward_percent input name
                    const percentInput = row.querySelector('input[name*="reward_percent"]');
                    if (percentInput) {
                        percentInput.name = `rewards[${index}][reward_percent]`;
                    }
                });
                rewardRowIndex = rows.length;
            }
        });
    </script>
@endpush
