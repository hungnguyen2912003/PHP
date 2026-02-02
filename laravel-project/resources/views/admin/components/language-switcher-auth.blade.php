<div class="position-absolute top-0 start-0 end-0 p-3">
    <div class="lang-switcher-auth d-flex justify-content-end align-items-center">
        @php
            $locales = [
                'en' => ['name' => __('common.lang.en'), 'flag' => 'usa.png'],
                'ja' => ['name' => __('common.lang.ja'), 'flag' => 'japan.png'],
                'vi' => ['name' => __('common.lang.vi'), 'flag' => 'vietnam.png'],
            ];
            $currentLocale = App::getLocale();
            // Re-evaluate current name based on new keys
            $locales = [
                'en' => ['name' => __('common.lang.en'), 'flag' => 'usa.png'],
                'ja' => ['name' => __('common.lang.ja'), 'flag' => 'japan.png'],
                'vi' => ['name' => __('common.lang.vi'), 'flag' => 'vietnam.png'],
            ];
            $currentFlag = $locales[$currentLocale]['flag'] ?? 'usa.png';
            $currentName = $locales[$currentLocale]['name'] ?? 'English';
        @endphp

        <div class="dropdown">
            {{-- Button (minimal) --}}
            <button
                class="lang-trigger"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                type="button"
            >
                <img
                    src="{{ asset('assets/images/' . $currentFlag) }}"
                    alt="{{ $currentName }}"
                />
                <span>{{ $currentName }}</span>
                <i class="ri-arrow-down-s-line"></i>
            </button>

            {{-- Menu --}}
            <div class="dropdown-menu lang-menu dropdown-menu-end mt-2">
                <div class="lang-head">
                    {{ __('common.lang.title') }}
                </div>

                <div class="lang-items" data-simplebar>
                    @foreach ($locales as $key => $data)
                        <a
                            href="{{ route('change-language', $key) }}"
                            class="lang-item {{ $currentLocale === $key ? 'is-active' : '' }}"
                        >
                            <img
                                src="{{ asset('assets/images/' . $data['flag']) }}"
                                alt="{{ $data['name'] }}"
                            />
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
    <a href="{{ url('/') }}" class="position-absolute top-0 start-0 text-decoration-none">
        <img
            src="{{ asset('assets/images/logo.png') }}"
            alt="logo"
            class="img-fluid"
            style="max-height: 120px"
        />
    </a>
</div>
