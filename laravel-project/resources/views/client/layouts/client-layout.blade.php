<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <title>@yield('title')</title>
        <!-- Links Of CSS File -->
        <link href="{{ asset('assets/client/css/sidebar-menu.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/simplebar.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/prism.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/quill.snow.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/remixicon.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/jsvectormap.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/client/css/style.css') }}" rel="stylesheet"/>
        <!-- Favicon -->
        <!-- Flasher CSS -->
        <link href="{{ asset('vendor/flasher/flasher.min.css') }}" rel="stylesheet">

        <style>
            .password-wrapper .form-control.is-invalid ~ .password-toggle-icon {
                right: 45px !important;
            }
        </style>
    </head>
    <body class="bg-body-bg">
        <!-- Start Sidebar Area -->
        @include('client.partials.sidebar')
        <!-- End Sidebar Area -->
        <!-- Start Main Content Area -->
        <div class="container-fluid">
            <div class="main-content d-flex flex-column">
                <!-- Start Header Area -->
                @include('client.partials.header')
                <!-- End Header Area -->
                <!-- Start Main Content -->
                @yield('content')
                <!-- End Main Content -->
                <div class="flex-grow-1"></div>
                <!-- Start Footer Area -->
                @include('client.partials.footer')
                <!-- End Footer Area -->
            </div>
        </div>
        <!-- Start Main Content Area -->
        <!-- Start Theme Setting Area -->
        {{-- <button aria-controls="offcanvasScrolling" class="btn btn-primary theme-settings-btn p-0 position-fixed z-2 text-center rounded-circle" data-bs-target="#offcanvasScrolling" data-bs-toggle="offcanvas" style="bottom: 24px; right: 24px; width: 56px; height: 56px; line-height: 54px;" type="button">
        <i class="text-white ri-settings-3-fill fs-28" data-bs-placement="left" data-bs-title="Click On Theme Settings" data-bs-toggle="tooltip">
        </i>
        </button> --}}
        <!-- End Theme Setting Area -->
        {{-- <div aria-labelledby="offcanvasScrollingLabel" class="offcanvas offcanvas-end bg-white border-0" data-bs-backdrop="true" data-bs-scroll="true" id="offcanvasScrolling" style="box-shadow: 0 4px 20px #2f8fe812 !important; max-width: 300px;" tabindex="-1">
            <div class="offcanvas-header bg-light p-20">
                <h5 class="offcanvas-title fs-18 fw-medium" id="offcanvasScrollingLabel">
                Configuration Panel
                </h5>
                <button aria-label="Close" class="btn-close" data-bs-dismiss="offcanvas" type="button">
                </button>
            </div>
            <div class="offcanvas-body p-0 overflow-hidden">
                <div class="last-child-none" data-simplebar="" style="max-height: 858px;">
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        RTL Mode
                    </h4>
                    <div class="rtl-btn">
                        <label id="switch">
                        <input class="toggle-switch rtl-switch" id="slider" onchange="toggleTheme()" type="checkbox"/>
                        </label>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        Only Sidebar Dark
                    </h4>
                    <div class="sidebar-light-dark" id="sidebar-light-dark">
                        <input class="toggle-switch sidebar-dark-switch" type="checkbox"/>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        Only Header Dark
                    </h4>
                    <div class="header-light-dark" id="header-light-dark">
                        <input class="toggle-switch header-dark-switch" type="checkbox"/>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        Right Sidebar
                    </h4>
                    <div class="right-sidebar" id="right-sidebar">
                        <input class="toggle-switch right-sidebar-switch" type="checkbox"/>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        Hide Sidebar
                    </h4>
                    <div class="icon-sidebar" id="icon-sidebar">
                        <input class="toggle-switch icon-sidebar-switch" type="checkbox"/>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        Bordered Card
                    </h4>
                    <div class="card-border" id="card-border">
                        <input class="toggle-switch border-switch" type="checkbox"/>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <h4 class="fs-15 fw-medium mb-12">
                        Card Border Radius
                    </h4>
                    <div class="card-radius-square" id="card-radius-square">
                        <input class="toggle-switch border-radius-switch" type="checkbox"/>
                    </div>
                </div>
                <div class="p-20 border-bottom child">
                    <a class="btn btn-primary text-white" href="#">
                    Buy StarCode
                    </a>
                </div>
                </div>
            </div>
        </div> --}}
        <!-- End Theme Setting Area -->
        <!-- Link Of JS File -->
        <script src="{{ asset('assets/client/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/sidebar-menu.js') }}"></script>
        <script src="{{ asset('assets/client/js/quill.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/data-table.js') }}"></script>
        <script src="{{ asset('assets/client/js/prism.js') }}"></script>
        <script src="{{ asset('assets/client/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/fullcalendar.main.js') }}"></script>
        <script src="{{ asset('assets/client/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/client/js/world-merc.js') }}"></script>
        <script src="{{ asset('assets/client/js/custom/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/client/js/custom/echarts.js') }}"></script>
        <script src="{{ asset('assets/client/js/custom/maps.js') }}"></script>
        <script src="{{ asset('assets/client/js/custom/custom.js') }}"></script>
        <script>
            (function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9bc284948f78f7b9',t:'MTc2ODExNDYyNA=='};var a=document.createElement('script');a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();
        </script>
        @stack('scripts')
    </body>
</html>