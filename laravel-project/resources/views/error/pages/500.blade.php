@extends('error.layouts.error-layout')

@section('title', __('title.error_500'))

@section('content')
    <div class="d-flex flex-column min-vh-100 px-3 pt-5 position-relative">
        <div class="position-absolute top-0 start-50 translate-middle-x mt-5">
            <a href="{{ route('admin.dashboard') }}">
                <img
                    src="{{ asset('assets/images/logo.png') }}"
                    alt="logo"
                    class="img-fluid"
                    style="max-height: 120px"
                />
            </a>
        </div>

        <div class="row justify-content-center my-auto">
            <div class="col-md-8 col-lg-6 col-xl-7">
                <div class="card bg-transparent shadow-none border-0">
                    <div class="card-body">
                        <div class="px-3 py-3 text-center">
                            <h1 class="error-title"><span class="blink-infinite">500</span></h1>
                            <h3 class="text-uppercase">{{ __('error.500.title') }}</h3>
                            <h4 class="">{{ __('error.500.msg') }}</h4>
                            <p class="font-size-15 mx-auto text-muted w-75 mt-4">{{ __('error.500.text') }}</p>
                            
                            @if(config('app.debug') && isset($exception))
                                <div class="mt-4 text-start mx-auto w-75">
                                    <div class="alert alert-danger">
                                        <h5 class="alert-heading">{{ __('error.500.debug_info') }}</h5>
                                        <p class="mb-1">{{ $exception->getMessage() }}</p>
                                        @if(method_exists($exception, 'getFile'))
                                            <hr>
                                            <p class="mb-0 small text-break">{{ $exception->getFile() }}:{{ $exception->getLine() }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <div class="mt-5 text-center">
                                <a class="btn btn-primary waves-effect waves-light" href="javascript:void(0)" onclick="window.history.back()">{{ __('button.go_back') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end row -->

        <div class="mt-auto text-center pb-4">
            <p class="mb-0">
                © <script>document.write(new Date().getFullYear())</script>
                <i class="mdi mdi-heart text-danger"></i>
                by <a href="#" target="_blank">Hung Nguyen</a>
            </p>
        </div>  
    </div>
@endsection
