<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Admin Dashboard</title>
    <link rel="shortcut icon" href="{{ asset('assets/admin/img/favicon.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700&display=swap"rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icons/flags/flags.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
</head>

<body>

    <div class="main-wrapper">

        <div class="header">
            @include('admin.partials.header')
        </div>


        <div class="sidebar" id="sidebar">
            <div class="sidebar-inner slimscroll">
                <div id="sidebar-menu" class="sidebar-menu">
                    @include('admin.partials.sidebar')
                </div>
            </div>
        </div>


        <div class="page-wrapper">
            <div class="content container-fluid">
                @yield('content')
            </div>
            <footer>
                <p>Copyright © 2022 Dreamguys.</p>
            </footer>
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/apexchart/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/apexchart/chart-data.js') }}"></script>
    <script src="{{ asset('assets/admin/js/script.js') }}"></script>
</body>

</html>