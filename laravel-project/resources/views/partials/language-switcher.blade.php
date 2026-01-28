<div class="lang-switcher-auth position-absolute top-0 end-0 p-3 d-flex align-items-center gap-3">
    {{-- Dark/Light Toggle --}}
    <div class="light-dark">
        <button class="switch-toggle p-0 bg-transparent lh-0 border-0 d-flex align-items-center justify-content-center" id="switch-toggle" style="width: 40px; height: 40px;">
            <span class="dark"><i class="ri-moon-line fs-22"></i></span>
            <span class="light"><i class="ri-sun-line fs-22"></i></span>
        </button>
    </div>

    @php
        $locales = [
            'en' => ['name' => __('messages.lang_en'), 'flag' => 'usa.png'],
            'ja' => ['name' => __('messages.lang_ja'), 'flag' => 'japan.png'],
            'vi' => ['name' => __('messages.lang_vi'), 'flag' => 'vietnam.png'],
        ];
        $currentLocale = App::getLocale();
        // Re-evaluate current name based on new keys
        $locales = [
            'en' => ['name' => __('messages.lang_en'), 'flag' => 'usa.png'],
            'ja' => ['name' => __('messages.lang_ja'), 'flag' => 'japan.png'],
            'vi' => ['name' => __('messages.lang_vi'), 'flag' => 'vietnam.png'],
        ];
        $currentFlag = $locales[$currentLocale]['flag'] ?? 'usa.png';
        $currentName = $locales[$currentLocale]['name'] ?? 'English';
    @endphp

    <div class="dropdown">
        {{-- Button (minimal) --}}
        <button class="lang-trigger" data-bs-toggle="dropdown" aria-expanded="false" type="button">
            <img src="{{ asset('assets/images/' . $currentFlag) }}" alt="{{ $currentName }}">
            <span>{{ $currentName }}</span>
            <i class="ri-arrow-down-s-line"></i>
        </button>

        {{-- Menu --}}
        <div class="dropdown-menu lang-menu dropdown-menu-end mt-2">
            <div class="lang-head">
                {{ __('messages.choose_language') }}
            </div>

            <div class="lang-items" data-simplebar>
                @foreach ($locales as $key => $data)
                    <a href="{{ route('change-language', $key) }}"
                       class="lang-item {{ $currentLocale === $key ? 'is-active' : '' }}">
                        <img src="{{ asset('assets/images/' . $data['flag']) }}" alt="{{ $data['name'] }}">
                        <span class="lang-name">{{ $data['name'] }}</span>

                        @if ($currentLocale === $key)
                            <i class="ri-check-line"></i>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

<style>
/* Kill bootstrap caret */
.lang-switcher-auth .dropdown-toggle::after { display: none !important; }

/* ===== Trigger button (clean) ===== */
.lang-switcher-auth .lang-trigger {
    display: inline-flex;
    align-items: center;
    gap: 10px;

    background: rgba(255,255,255,.78);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);

    border: 1px solid rgba(15, 23, 42, 0.10);
    padding: 8px 12px;
    border-radius: 12px;

    font-size: 14px;
    font-weight: 600;
    color: #0f172a;

    transition: 160ms ease;
}

.lang-switcher-auth .lang-trigger:hover {
    background: rgba(255,255,255,.92);
    border-color: rgba(15, 23, 42, 0.16);
    transform: translateY(-1px);
}

.lang-switcher-auth .lang-trigger:focus {
    outline: none;
    border-color: rgba(59, 130, 246, .55);
    box-shadow: 0 0 0 4px rgba(59, 130, 246, .16);
}

.lang-switcher-auth .lang-trigger img {
    width: 18px;
    height: 18px;
    border-radius: 999px;
    object-fit: cover;
}

.lang-switcher-auth .lang-trigger i {
    font-size: 16px;
    color: rgba(15, 23, 42, 0.55);
}

/* ===== Menu ===== */
.lang-switcher-auth .lang-menu {
    width: 240px;
    padding: 10px;
    border-radius: 14px;

    background: rgba(255,255,255,.92);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);

    border: 1px solid rgba(15, 23, 42, 0.10);
    box-shadow: 0 18px 40px rgba(2, 6, 23, 0.12);
}

.lang-switcher-auth .lang-head {
    padding: 8px 10px 10px;
    font-size: 12px;
    font-weight: 700;
    letter-spacing: .2px;
    text-transform: uppercase;
    color: rgba(15, 23, 42, 0.55);
}

.lang-switcher-auth .lang-items {
    max-height: 240px;
    overflow: auto;
    padding-top: 6px;
}

/* ===== Items (FLAT STYLE) ===== */
.lang-switcher-auth .lang-item {
    display: flex;
    align-items: center;
    gap: 10px;

    padding: 11px 12px;

    text-decoration: none;
    color: #0f172a;
    font-weight: 600;
    font-size: 14px;

    transition: background .12s ease, color .12s ease;
}

/* Divider giữa các item */
.lang-switcher-auth .lang-item {
    border-bottom: 1px solid #f1f3f5;
}

/* Bỏ đường kẻ ở item cuối */
.lang-switcher-auth .lang-item:last-child {
    border-bottom: none;
}

.lang-switcher-auth .lang-item img {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.lang-switcher-auth .lang-item .lang-name {
    flex: 1;
}

.lang-switcher-auth .lang-item:hover {
    background: #f8fafc;
}

.lang-switcher-auth .lang-item.is-active {
    background: #eef2ff;
    color: #1d4ed8;
    font-weight: 700;
}

.lang-switcher-auth .lang-item.is-active i {
    color: #1d4ed8;
    font-size: 18px;
}


/* Avoid bootstrap active flash */
.lang-switcher-auth .dropdown-item:active {
    background: transparent !important;
    color: inherit !important;
}
</style>
