<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('user/css/styles.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Header news -->
    @include('user.layouts.header')
    <!-- End Header news -->

    @yield('content')

    <!-- Footer -->
    @include('user.layouts.footer')
    <!-- End Footer -->

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('user/js/index.bundle.js') }}"></script>
</body>

</html>