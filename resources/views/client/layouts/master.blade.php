<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('css/tree.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
	<link href="{{ asset('css/dropzone.css')}}" rel="stylesheet">

	<!-- <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->

	<script> var CURRENT_FOLDER = 0; </script>
</head>
<body>
	@include('client.partials.header')

	@include('admin.partials.info')

    <div id="wrapper" class="wrapper">
		
		@include('admin.partials.sidebar')

		<div id="content" class="">

			<nav class="navbar navbar-expand-lg navbar-light" style="margin-top: 70px; background-color:#e9ecef">
				<div class="container-fluid">
					<button type="button" id="sidebarCollapse" class="navbar-btn" style="background: #e9ecef;">
					</button>
					<div id="navbarSupportedContent">
						<ul class="nav navbar-nav ml-auto">
							<li class="nav-item">
								<h1> @yield('page') </h1>
							</li>
						</ul>
					</div>
				</div>
			</nav>

			@yield('content')

		</div>
	</div>
	<script src="{{ asset('js/app.js') }}"></script>
	<!-- <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" defer></script> -->
	<!-- <script src="{{ asset('js/dropzone.js') }}"></script>
	<script src="{{ asset('js/coreFolder.js') }}"></script> -->
	<script src="{{ asset('js/displayFolder.js') }}"></script>

	@yield('scripts')
</body>
</html>
