<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title')</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('admin/modules/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/modules/weather-icon/css/weather-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/modules/weather-icon/css/weather-icons-wind.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/modules/summernote/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/modules/select2/dist/css/select2.min.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/components.css') }}">
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <!-- Navbar -->
            @include('admin.layouts.navbar')

            <!-- Sidebar -->
            @include('admin.layouts.sidebar')

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    @yield('content')
                </section>
            </div>
        </div>

        <!-- General JS Scripts -->
        <script src="{{ asset('admin/modules/jquery.min.js') }}"></script>
        <script src="{{ asset('admin/modules/popper.js') }}"></script>
        <script src="{{ asset('admin/modules/tooltip.js') }}"></script>
        <script src="{{ asset('admin/modules/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('admin/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
        <script src="{{ asset('admin/modules/moment.min.js') }}"></script>
        <script src="{{ asset('admin/js/stisla.js') }}"></script>
        <script src="{{ asset('admin/modules/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
        @include('sweetalert::alert')

        <!-- JS Libraies -->
        <script src="{{ asset('admin/modules/simple-weather/jquery.simpleWeather.min.js') }}"></script>
        <script src="{{ asset('admin/modules/chart.min.js') }}"></script>
        <script src="{{ asset('admin/modules/jqvmap/dist/jquery.vmap.min.js') }}"></script>
        <script src="{{ asset('admin/modules/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
        <script src="{{ asset('admin/modules/summernote/summernote-bs4.js') }}"></script>
        <script src="{{ asset('admin/modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
        <script src="{{ asset('admin/modules/select2/dist/js/select2.full.min.js') }}"></script>

        <!-- Page Specific JS File -->
        <script src="{{ asset('admin/js/page/index-0.js') }}"></script>

        <!-- Template JS File -->
        <script src="{{ asset('admin/js/scripts.js') }}"></script>
        <script src="{{ asset('admin/js/custom.js') }}"></script>

        <script>
            $(document).ready(function() {
                $.uploadPreview({
                    input_field: "#image-upload",
                    preview_box: "#image-preview",
                    label_field: "#image-label",
                    no_label: false,
                    success_callback: null,
                });
            });
        </script>

        @stack('scripts')
</body>

</html>