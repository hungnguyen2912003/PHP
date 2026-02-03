@extends('error.layouts.error-layout')

@section('title', __('title.error_500'))

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="text-center mb-5 mt-4">
                <a href="{{ route('client.dashboard') }}" class="d-block auth-logo">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="80" class="auth-logo-dark mx-auto">
                </a>
            </div>

            <div class="text-center">
                <div class="error-code-container mb-4">
                    <h1 class="display-1 fw-bold text-danger mb-0">500</h1>
                    <div class="error-divider mx-auto bg-danger opacity-25"
                        style="height: 4px; width: 60px; border-radius: 2px;"></div>
                </div>

                <h3 class="text-uppercase fw-semibold mb-3">{{ __('error.500.title') }}</h3>
                <h5 class="text-muted fw-normal mb-4">{{ __('error.500.msg') }}</h5>
                <p class="text-muted fs-15 mb-4">{{ __('error.500.text') }}</p>

                @if (config('app.debug') && isset($exception))
                    <div class="mt-4 text-start">
                        <div class="alert alert-danger border-0 bg-danger-subtle p-4 rounded-3">
                            <div class="d-flex align-items-center mb-2">
                                <i class="ri-error-warning-fill fs-24 text-danger me-2"></i>
                                <h6 class="alert-heading fw-bold mb-0">{{ __('error.500.debug_info') }}</h6>
                            </div>
                            <p class="mb-2 fw-medium">{{ $exception->getMessage() }}</p>
                            @if (method_exists($exception, 'getFile'))
                                <hr class="border-danger opacity-10">
                                <p class="mb-0 small text-break font-monospace opacity-75">
                                    <i class="ri-file-code-line align-middle me-1"></i>
                                    {{ $exception->getFile() }}:{{ $exception->getLine() }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="mt-5">
                    <a href="javascript:void(0)" onclick="window.history.back()"
                        class="btn btn-primary btn-lg rounded-pill px-5 waves-effect waves-light">
                        <i class="ri-arrow-left-line align-bottom me-1"></i> {{ __('button.go_back') }}
                    </a>
                </div>
            </div>

            <div class="mt-5 text-center px-4">
                <p class="mb-0 text-muted">
                    ©
                    <script>document.write(new Date().getFullYear())</script>
                    Hung Nguyen
                </p>
            </div>
        </div>
    </div>

    <style>
        .bg-danger-subtle {
            background-color: rgba(234, 73, 97, 0.1) !important;
        }

        .error-code-container h1 {
            font-size: 8rem;
            letter-spacing: -2px;
            line-height: 1;
            background: linear-gradient(135deg, var(--bs-danger) 0%, #ff6b6b 100%);
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