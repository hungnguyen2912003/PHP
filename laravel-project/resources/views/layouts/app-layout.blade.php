<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <title>@yield('title')</title>
        <!-- Links Of CSS File -->
        <link href="{{ asset('assets/css/sidebar-menu.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/simplebar.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/prism.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/quill.snow.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/remixicon.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/jsvectormap.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/style.css?v=' . time()) }}" rel="stylesheet"/>
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
        @include('partials.sidebar')
        <!-- End Sidebar Area -->
        <div class="container-fluid">
            <div class="main-content d-flex flex-column">
                <!-- Start Header Area -->
                @include('partials.header')
                <!-- End Header Area -->
                <!-- Start Main Content -->
                @yield('content')
                <!-- End Main Content -->
                <div class="flex-grow-1"></div>
                <!-- Start Footer Area -->
                @include('partials.footer')
                <!-- End Footer Area -->
            </div>
        </div>
        <!-- Link Of JS File -->
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>        
        <script src="{{ asset('assets/js/sidebar-menu.js') }}"></script>
        <script src="{{ asset('assets/js/quill.min.js') }}"></script>
        <script src="{{ asset('assets/js/data-table.js') }}"></script>
        <script src="{{ asset('assets/js/prism.js') }}"></script>
        <script src="{{ asset('assets/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/js/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/fullcalendar.main.js') }}"></script>
        <script src="{{ asset('assets/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/js/world-merc.js') }}"></script>
        <script src="{{ asset('assets/js/custom/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/js/custom/echarts.js') }}"></script>
        <script src="{{ asset('assets/js/custom/maps.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('assets/js/custom/custom.js?id=' . time()) }}"></script>
        <script>
            (function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9bc284948f78f7b9',t:'MTc2ODExNDYyNA=='};var a=document.createElement('script');a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();
        </script>
        @stack('scripts')
    </body>
</html>