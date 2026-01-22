<!DOCTYPE html>
<html lang="zxx">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <!-- Links Of CSS File -->
        <link href="{{ asset('assets/admin/auth/css/sidebar-menu.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/simplebar.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/prism.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/quill.snow.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/remixicon.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/swiper-bundle.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/jsvectormap.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/admin/auth/css/style.css') }}" rel="stylesheet"/>
        <!-- Title -->
        <title>
            @yield('title')
        </title>
    </head>
    <body class="bg-body-bg">
        <div class="container-fluid">
            @yield('content')
        </div>
        <!-- Link Of JS File -->
        <script src="{{ asset('assets/admin/auth/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/sidebar-menu.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/quill.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/data-table.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/prism.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/clipboard.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/echarts.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/swiper-bundle.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/fullcalendar.main.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/jsvectormap.min.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/world-merc.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/custom/apexcharts.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/custom/echarts.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/custom/maps.js') }}"></script>
        <script src="{{ asset('assets/admin/auth/js/custom/custom.js') }}"></script>
        <script>
            (function(){function c(){var b=a.contentDocument||a.contentWindow.document;if(b){var d=b.createElement('script');d.innerHTML="window.__CF$cv$params={r:'9bc2a239bfc60d0e',t:'MTc2ODExNTgzOA=='};var a=document.createElement('script');a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";b.getElementsByTagName('head')[0].appendChild(d)}}if(document.body){var a=document.createElement('iframe');a.height=1;a.width=1;a.style.position='absolute';a.style.top=0;a.style.left=0;a.style.border='none';a.style.visibility='hidden';document.body.appendChild(a);if('loading'!==document.readyState)c();else if(window.addEventListener)document.addEventListener('DOMContentLoaded',c);else{var e=document.onreadystatechange||function(){};document.onreadystatechange=function(b){e(b);'loading'!==document.readyState&&(document.onreadystatechange=e,c())}}}})();
        </script>
    </body>
</html>