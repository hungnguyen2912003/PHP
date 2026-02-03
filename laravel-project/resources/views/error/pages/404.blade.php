@extends('error.layouts.error-layout')

@section('title', __('title.error_404'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-5 mt-4">
                <a href="{{ route('client.dashboard') }}" class="d-block auth-logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="80" class="auth-logo-dark mx-auto">
                </a>
            </div>

            <div class="text-center">
                <div class="error-code-container mb-4">
                    <h1 class="display-1 fw-bold text-primary mb-0">404</h1>
                    <div class="error-divider mx-auto bg-primary opacity-25"
                        style="height: 4px; width: 60px; border-radius: 2px;"></div>
                </div>

                <h3 class="text-uppercase fw-semibold mb-3">{{ __('error.404.title') }}</h3>
                <p class="text-muted fs-15 mb-4">{{ __('error.404.text') }}</p>

                <div>
                    <a href="javascript:void(0)" onclick="window.history.back()"
                        class="btn btn-primary btn-lg rounded-pill px-5 waves-effect waves-light mt-2">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> {{ __('button.go_back') }}
                    </a>
                </div>
            </div>

            <div class="mt-5 text-center">
                <p class="mb-0 text-muted">
                    ©
                    <script>document.write(new Date().getFullYear())</script>
                    Hung Nguyen
                </p>
            </div>
        </div>
    </div>

    <style>
        .error-code-container h1 {
            font-size: 8rem;
            letter-spacing: -2px;
            line-height: 1;
            background: linear-gradient(135deg, var(--bs-primary) 0%, #4b38b3 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInDown 0.8s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection