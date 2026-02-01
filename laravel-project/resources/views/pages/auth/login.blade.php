@extends('layouts.auth-layout')

@section('title', __('messages.sign_in_title'))

@section('content')
    <div class="container-fluid bg-cover-login">
        <div class="main-content d-flex flex-column p-0">
            <div class="m-lg-auto my-auto w-930 py-4">
                <div class="card bg-white border rounded-10 py-100 px-130 position-relative">
                    <div class="position-absolute top-0 start-0 end-0 p-3">
                        <div class="lang-switcher-auth d-flex justify-content-end align-items-center">
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
                        <a href="{{ url('/') }}"
                        class="position-absolute top-0 start-0 text-decoration-none">
                            <img src="{{ asset('assets/images/logo.png') }}"
                                alt="logo"
                                class="img-fluid"
                                style="max-height: 120px;">
                        </a>
                    </div>
                    <div class="p-md-5 p-4 p-lg-0">
                        <div class="text-center mb-4 mt-5">
                             <h3 class="fs-26 fw-medium" style="margin-bottom: 6px;">
                                {{ __('messages.sign_in_title') }}
                            </h3>
                            <p class="fs-16 text-secondary lh-1-8">
                                {{ __('messages.dont_have_account') }}
                                <a class="text-primary text-decoration-none" href="{{ route('register') }}">
                                    {{ __('messages.sign_up_link') }}
                                </a>
                            </p>
                        </div>
                        <form action="{{ route('login.post') }}" method="POST" id="loginForm">
                            @csrf
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">
                                    {{ __('messages.username_email_label') }} <span class="text-danger">*</span>
                                </label>
                                <div class="form-floating">
                                    <input class="form-control @error('login') is-invalid @enderror" id="login"
                                        placeholder="{{ __('messages.enter_username_email') }}" type="text" name="login" />
                                    <label for="login">
                                        <i class="ri-user-line"></i>
                                        {{ __('messages.enter_username_email') }}
                                    </label>
                                </div>
                                @error('login')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20">
                                <label class="label fs-16 mb-2">
                                    {{ __('messages.password_label') }} <span class="text-danger">*</span>
                                </label>
                                <div class="form-group" id="password-show-hide">
                                    <div class="password-wrapper position-relative password-container form-floating">
                                        <input
                                            class="form-control text-secondary password @error('password') is-invalid @enderror"
                                            placeholder="{{ __('messages.enter_password') }}" type="password" name="password"
                                            id="password" />
                                        <label for="password">
                                            <i class="ri-lock-line"></i>
                                            {{ __('messages.enter_password') }}
                                        </label>
                                        <i aria-hidden="true"
                                            class="ri-eye-off-line password-toggle-icon translate-middle-y top-50 position-absolute cursor text-secondary"
                                            style="color: #A9A9C8; font-size: 22px; right: 15px; z-index: 10;">
                                        </i>
                                    </div>
                                </div>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-20">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-1">
                                    <div class="form-check">
                                        <input class="form-check-input" id="flexCheckDefault" type="checkbox" value="" />
                                        <label class="form-check-label fs-16" for="flexCheckDefault">
                                            {{ __('messages.remember_me') }}
                                        </label>
                                    </div>
                                    <a class="fs-16 text-primary fw-normal text-decoration-none"
                                        href="{{ route('forgot-password') }}">
                                        {{ __('messages.forgot_password_link') }}
                                    </a>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button class="btn btn-primary fw-normal text-white w-100" id="submitBtn" data-processing-text="{{ __('messages.processing') }}"
                                    style="padding-top: 18px; padding-bottom: 18px;" type="submit">
                                    <span id="btnText">{{ __('messages.sign_in_link') }}</span>
                                    <span id="btnLoading" class="spinner-border spinner-border-sm ml-2 d-none"></span>
                                </button>
                            </div>
                            <div class="position-relative text-center z-1 mb-12">
                                <span class="fs-16 bg-white px-4 text-secondary card d-inline-block border-0">
                                    {{ __('messages.or_sign_in_with') }}
                                </span>
                                <span class="d-block border-bottom border-2 position-absolute w-100 z-n1"
                                    style="top: 13px;">
                                </span>
                            </div>
                            <ul class="p-0 mb-0 list-unstyled d-flex justify-content-center" style="gap: 10px;">
                                <li>
                                    <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16"
                                        href="https://www.facebook.com/"
                                        style="width: 30px; height: 30px; line-height: 30px; background-color: #3a559f;"
                                        target="_blank">
                                        <i class="ri-facebook-fill">
                                        </i>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16"
                                        href="https://www.twitter.com/"
                                        style="width: 30px; height: 30px; line-height: 30px; background-color: #0f1419;"
                                        target="_blank">
                                        <i class="ri-twitter-x-line">
                                        </i>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16"
                                        href="https://www.google.com/"
                                        style="width: 30px; height: 30px; line-height: 30px; background-color: #e02f2f;"
                                        target="_blank">
                                        <i class="ri-google-fill">
                                        </i>
                                    </a>
                                </li>
                                <li>
                                    <a class="d-inline-block rounded-circle text-decoration-none text-center text-white transition-y fs-16"
                                        href="https://www.linkedin.com/"
                                        style="width: 30px; height: 30px; line-height: 30px; background-color: #007ab9;"
                                        target="_blank">
                                        <i class="ri-linkedin-fill">
                                        </i>
                                    </a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
