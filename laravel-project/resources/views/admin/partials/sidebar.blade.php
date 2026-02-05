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
            <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'open' : '' }}">
                <a class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <span class="material-symbols-outlined menu-icon">ballot</span>
                    <span class="title">{{ __('breadcrumb.dashboard') }}</span>
                </a>
            </li>
            @if(Auth::guard('admin')->check() && optional(Auth::guard('admin')->user()->role)->name === 'Admin')
                <li class="menu-title small text-uppercase"><span
                        class="menu-title-text">{{ __('section.apps') }}</span></li>
                <li class="menu-item {{ request()->routeIs('admin.users.*') ? 'open' : '' }}">
                    <a class="menu-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <span class="material-symbols-outlined menu-icon">account_circle</span>
                        <span class="title">{{ __('breadcrumb.user_management') }}</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.roles.*') ? 'open' : '' }}">
                    <a class="menu-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}"
                        href="{{ route('admin.roles.index') }}">
                        <span class="material-symbols-outlined menu-icon">shield_person</span>
                        <span class="title">{{ __('breadcrumb.role_management') }}</span>
                    </a>
                </li>
                <li class="menu-title small text-uppercase"><span
                        class="menu-title-text">{{ __('breadcrumb.health_data') }}</span></li>
                <li class="menu-item {{ request()->routeIs('admin.weights.*') ? 'open' : '' }}">
                    <a class="menu-link {{ request()->routeIs('admin.weights.*') ? 'active' : '' }}"
                        href="{{ route('admin.weights.index') }}">
                        <span class="material-symbols-outlined menu-icon">fitness_center</span>
                        <span class="title">{{ __('breadcrumb.weight_list') }}</span>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('admin.heights.*') ? 'open' : '' }}">
                    <a class="menu-link {{ request()->routeIs('admin.heights.*') ? 'active' : '' }}"
                        href="{{ route('admin.heights.index') }}">
                        <span class="material-symbols-outlined menu-icon">height</span>
                        <span class="title">{{ __('breadcrumb.height_list') }}</span>
                    </a>
                </li>
            @endif
        </ul>
    </aside>
</div>