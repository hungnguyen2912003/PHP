@extends('layouts.error-layout')

@section('title', '404')

@section('content')
    <div class="d-flex flex-column min-vh-100 py-5 px-3">
        <div class="row justify-content-center">
            <div class="col-xl-5">
                <div class="text-center text-muted mb-2">
                    <div class="pb-3">
                        <a href="{{ route('home') }}">
                            <span class="logo-lg">
                                <span class="logo-txt fs-24 fw-bold">Laravel App</span>
                            </span>
                        </a>
                        {{-- <p class="text-muted font-size-15 w-75 mx-auto mt-3 mb-0">User Experience &amp; Interface Design Strategy Saas Solution</p> --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center my-auto">
            <div class="col-md-8 col-lg-6 col-xl-7">
                <div class="card bg-transparent shadow-none border-0">
                    <div class="card-body">
                        <div class="px-3 py-3 text-center">
                            <h1 class="error-title"><span class="blink-infinite">404</span></h1>
                            <h3 class="text-uppercase">{{ __('messages.error_404_title') }}</h3>
                            <h4 class=""></h4>
                            <p class="font-size-15 mx-auto text-muted w-75 mt-4">{{ __('messages.error_404_text') }}</p>
                            <div class="mt-5 text-center">
                                <a class="btn btn-primary waves-effect waves-light" href="{{ route('home') }}">{{ __('messages.back_to_home') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- end row -->

        <div class="row">
            <div class="col-xl-12">
                <div class="mt-4 mt-md-5 text-center">
                    <p class="mb-0">© <script>document.write(new Date().getFullYear())</script> <i class="mdi mdi-heart text-danger"></i> by <a href="" target="_blank">Hung Nguyen</a></p>
                </div>
            </div>
        </div> <!-- end row -->
    </div>
@endsection
