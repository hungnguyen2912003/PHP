<div class="sidebar-area" id="sidebar-area">
    <div class="logo position-relative d-flex align-items-center justify-content-between">
        <a class="d-block text-decoration-none position-relative" href="{{ route('admin.dashboard') }}">
            <img alt="logo-icon" src="{{ asset('assets/images/logo-sidebar.png') }}" />
            <span class="logo-text text-secondary fw-semibold"><span class="healthi-text">Healthi</span><span
                    class="fy-text">fy</span></span>
        </a>
        <button
            class="sidebar-burger-menu-close bg-transparent py-3 border-0 opacity-0 z-n1 position-absolute top-50 end-0 translate-middle-y"
            id="sidebar-burger-menu-close">
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px; transform: rotate(45deg);">
            </span>
            <span class="border-1 d-block for-dark-burger"
                style="border-bottom: 1px solid #475569; height: 1px; width: 25px; transform: rotate(-45deg);">
            </span>
        </button>
        <button class="sidebar-burger-menu bg-transparent p-0 border-0" id="sidebar-burger-menu">
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
    </div>
    <aside class="layout-menu menu-vertical menu active" data-simplebar="" id="layout-menu">
        <ul class="menu-inner">
            <li class="menu-title small text-uppercase"><span
                    class="menu-title-text">{{ __('section.main_menu') }}</span></li>
            <li class="menu-item {{ request()->routeIs('client.dashboard') ? 'open' : '' }}">
                <a class="menu-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}"
                    href="{{ route('client.dashboard') }}">
                    <span class="material-symbols-outlined menu-icon">ballot</span>
                    <span class="title">{{ __('breadcrumb.dashboard') }}</span>
                </a>
            </li>
            @if(Auth::guard('web')->check())
                <li class="menu-title small text-uppercase"><span
                        class="menu-title-text">{{ __('section.apps') }}</span></li>
                <li class="menu-item {{ request()->routeIs('client.profile.*') ? 'open' : '' }}">
                    <a class="menu-link {{ request()->routeIs('client.profile.*') ? 'active' : '' }}"
                        href="{{ route('client.profile.index') }}">
                        <span class="material-symbols-outlined menu-icon">account_circle</span>
                        <span class="title">{{ __('label.my_profile') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>