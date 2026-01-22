<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
		<!-- PAGE TITLE HERE -->
	<title>@yield('title')</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('assets/client/main/images/favicon.png') }}">
	
	<link href="{{ asset('assets/client/main/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
	<link rel="stylesheet" href="{{ asset('assets/client/main/vendor/nouislider/nouislider.min.css') }}">
	<!-- Style css -->
    <link href="{{ asset('assets/client/main/css/style.css') }}" rel="stylesheet">
	
</head>
<body>
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            @include('client.partials.nav-header')
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            @include('client.partials.header')
		</div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
            @include('client.partials.sidebar')
        </div>
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
                @yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
		
				
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            @include('client.partials.footer')
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{ asset('assets/client/main/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('assets/client/main/vendor/chart.js/Chart.bundle.min.js') }}"></script>
	<script src="{{ asset('assets/client/main/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
	
	<!-- Apex Chart -->
	<script src="{{ asset('assets/client/main/vendor/apexchart/apexchart.js') }}"></script>
	<script src="{{ asset('assets/client/main/vendor/nouislider/nouislider.min.js') }}"></script>
	<script src="{{ asset('assets/client/main/vendor/wnumb/wNumb.js') }}"></script>
	
	<!-- Dashboard 1 -->
	<script src="{{ asset('assets/client/main/js/dashboard/dashboard-1.js') }}"></script>

    <script src="{{ asset('assets/client/main/js/custom.min.js') }}"></script>
	<script src="{{ asset('assets/client/main/js/dlabnav-init.js') }}"></script>
	<script src="{{ asset('assets/client/main/js/demo.js') }}"></script>
    <script src="{{ asset('assets/client/main/js/styleSwitcher.js') }}"></script>
	
</body>
</html>