<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>

    <meta charset="utf-8">
    <title>@yield('title')</title>
    <!-- Layout config Js -->
    <script src="{{ asset('assets/client/js/layout.js') }}"></script>
    <!-- Icons CSS -->
    <link rel="stylesheet" href="{{ asset('assets/client/css/starcode2.css') }}">
</head>

<body class="flex items-center justify-center min-h-screen py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

    @yield('content')

    <script src="{{ asset('assets/client/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
    <script src="{{ asset('assets/client/libs/@popperjs/core/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/client/libs/tippy.js/tippy-bundle.umd.min.js') }}"></script>
    <script src="{{ asset('assets/client/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/client/libs/prismjs/prism.js') }}"></script>
    <script src="{{ asset('assets/client/libs/lucide/umd/lucide.js') }}"></script>
    <script src="{{ asset('assets/client/js/starcode.bundle.js') }}"></script>
    <script src="{{ asset('assets/client/js/pages/auth-login.init.js') }}"></script>

</body>

</html>