<style>
    .active-language {
        background-color: #f8f9fa;
    }
    body[data-theme="dark"] .active-language {
        background-color: #334155 !important;
    }
    body[data-theme="dark"] .active-language .text-secondary {
        color: #ffffff !important;
    }
</style>
<header class="header-area bg-white mb-4 rounded-10 border border-white" id="header-area">
    <div class="row align-items-center">
        <div class="col-md-6">
            <div class="left-header-content">
                <ul
                    class="d-flex align-items-center ps-0 mb-0 list-unstyled justify-content-center justify-content-md-start">
                    <li class="d-xl-none">
                        <button class="header-burger-menu bg-transparent p-0 border-0 position-relative top-3"
                            id="header-burger-menu">
                            <span class="border-1 d-block for-dark-burger"
                                style="border-bottom: 1px solid #475569; height: 1px; width: 25px;">
                            </span>
                            <span class="border-1 d-block for-dark-burger"
                                style="border-bottom: 1px solid #475569; height: 1px; width: 25px; margin: 6px 0;">
                            </span>
                            <span class="border-1 d-block for-dark-burger"
                                style="border-bottom: 1px solid #475569; height: 1px; width: 25px;">
                            </span>
                        </button>
                    </li>
                    <li>
                        <form class="src-form position-relative">
                            <input class="form-control" placeholder="{{ __('admin/layouts/header.search_placeholder') }}"
                                type="text" />
                            <div
                                class="src-btn position-absolute top-50 start-0 translate-middle-y bg-transparent p-0 border-0">
                                <span class="material-symbols-outlined">
                                    search
                                </span>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="right-header-content mt-3 mt-md-0">
                <ul
                    class="d-flex align-items-center justify-content-center justify-content-md-end ps-0 mb-0 list-unstyled">
                    <li class="header-right-item language-item">
                        <div class="dropdown notifications language">
                            <button aria-expanded="false"
                                class="btn btn-secondary dropdown-toggle border-0 p-0 position-relative"
                                data-bs-toggle="dropdown" type="button">
                                <span class="material-symbols-outlined" style="font-size: 19px;">
                                    translate
                                </span>
                            </button>
                            <div class="dropdown-menu dropdown-lg p-0 border-0 dropdown-menu-end">
                                <span class="fw-medium fs-16 text-secondary d-block title"
                                    style="padding-top: 20px; padding-bottom: 20px;">
                                    {{ __('common.lang.title') }}
                                </span>
                                <div class="max-h-275" data-simplebar="">
                                    @php
                                        $locales = [
                                            'en' => ['name' => __('common.lang.en'), 'flag' => 'usa.png'],
                                            'ja' => ['name' => __('common.lang.ja'), 'flag' => 'japan.png'],
                                            'vi' => ['name' => __('common.lang.vi'), 'flag' => 'vietnam.png'],
                                        ];
                                        $currentLocale = App::getLocale();
                                    @endphp
                                    @foreach ($locales as $key => $data)
                                        <div class="notification-menu">
                                            <a class="dropdown-item {{ $currentLocale === $key ? 'active-language' : '' }}"
                                                href="{{ route('change-language', $key) }}">
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        <img alt="{{ $data['name'] }}" class="wh-30 rounded-circle"
                                                            src="{{ asset('assets/images/' . $data['flag']) }}" />
                                                    </div>
                                                    <div class="flex-grow-1 ms-10">
                                                        <span class="text-secondary fw-medium fs-15">
                                                            {{ $data['name'] }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="header-right-item light-dark-item">
                        <div class="light-dark">
                            <button class="switch-toggle dark-btn p-0 bg-transparent lh-0 border-0" id="switch-toggle">
                                <span class="dark"><i class="material-symbols-outlined">dark_mode</i></span>
                                <span class="light"><i class="material-symbols-outlined">light_mode</i></span>
                            </button>
                        </div>
                    </li>
                    @auth
                        @php
                            $user = Auth::user();
                        @endphp
                        <li class="header-right-item border-0">
                            <div class="dropdown admin-profile">
                                <div class="d-xxl-flex align-items-center bg-transparent border-0 text-start p-0 cursor dropdown-toggle"
                                    data-bs-toggle="dropdown">
                                    <div class="flex-shrink-0 position-relative">
                                        <img alt="admin" class="rounded-circle admin-img-width-for-mobile"
                                            src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}"
                                            style="width: 40px; height: 40px;" />
                                        <span
                                            class="d-block bg-success-60 border-2 border-white rounded-circle position-absolute end-0 bottom-0"
                                            style="width: 11px; height: 11px;">
                                        </span>
                                    </div>
                                </div>
                                <div class="dropdown-menu border-0 bg-white dropdown-menu-end" style="min-width: 260px;">
                                    <div class="d-flex align-items-center info">
                                        <div class="flex-shrink-0">
                                            <img alt="admin" class="rounded-circle admin-img-width-for-mobile"
                                                src="{{ $user->avatar_url ? asset($user->avatar_url) : asset('assets/images/user.png') }}"
                                                style="width: 40px; height: 40px;" />
                                        </div>
                                        <div class="flex-grow-1 ms-10">
                                            <h3 class="fw-medium fs-17 mb-0">
                                                {{ $user->fullname }}
                                            </h3>
                                            <span class="fs-15 fw-medium">{{ __('common.info.role.title') }}:</span>
                                            @if($user->role)
                                                {{ __('common.info.role.' . strtolower($user->role->name)) }}
                                            @endif
                                        </div>
                                    </div>
                                    <ul class="admin-link mb-0 list-unstyled">
                                        <li>
                                            <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                href="{{ route('admin.profile.index') }}">
                                                <i class="material-symbols-outlined">person</i>
                                                <span class="ms-2">{{ __('admin/layouts/header.dropdown.my_profile') }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item admin-item-link d-flex align-items-center text-body"
                                                href="">
                                                <i class="material-symbols-outlined">settings</i>
                                                <span class="ms-2">{{ __('admin/layouts/header.dropdown.settings') }}</span>
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('admin.logout') }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                        class="dropdown-item admin-item-link d-flex align-items-center text-body">
                                                    <i class="material-symbols-outlined">logout</i>
                                                    <span class="ms-2">{{ __('admin/layouts/header.dropdown.logout') }}</span>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    @endauth
                    @guest
                        <li class="header-right-item">
                            <a href="{{ route('login') }}"
                                class="btn btn-primary text-white btn-sm rounded-pill px-3 me-2">{{ __('admin.dashboard.login') }}</a>
                            <a href="{{ route('register') }}"
                                class="btn btn-info text-white btn-sm rounded-pill px-3">{{ __('admin.dashboard.register') }}</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </div>
</header>