<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Links Of CSS File -->
    <link href="{{ asset('assets/auth/css/sidebar-menu.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/simplebar.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/prism.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/quill.snow.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/remixicon.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/swiper-bundle.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/jsvectormap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/auth/css/style.css') }}" rel="stylesheet" />
    <!-- Title -->
    <title>
        @yield('title')
    </title>
    <style>
        .password-wrapper .form-control.is-invalid ~ .password-toggle-icon {
            right: 45px !important;
        }
    </style>
</head>

<body class="bg-body-bg">
    <div class="container-fluid">
        @yield('content')
    </div>
    <!-- Link Of JS File -->
    <script src="{{ asset('assets/js/jquery-4.0.0.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/sidebar-menu.js') }}"></script>
    <script src="{{ asset('assets/auth/js/quill.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/data-table.js') }}"></script>
    <script src="{{ asset('assets/auth/js/prism.js') }}"></script>
    <script src="{{ asset('assets/auth/js/clipboard.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/fullcalendar.main.js') }}"></script>
    <script src="{{ asset('assets/auth/js/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/auth/js/world-merc.js') }}"></script>
    <script src="{{ asset('assets/auth/js/custom/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/auth/js/custom/echarts.js') }}"></script>
    <script src="{{ asset('assets/auth/js/custom/maps.js') }}"></script>
    <script src="{{ asset('assets/auth/js/custom/custom.js') }}"></script>
    <script src="{{ asset('assets/js/mycustom.js') }}"></script>
    <script src="{{ asset('assets/js/toastr.min.js') }}"></script>

</body>

</html>