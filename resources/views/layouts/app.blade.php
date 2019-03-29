<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/admin.css') }}" rel="stylesheet"> -->
    <!-- <link href="{{ asset('css/login.css') }}" rel="stylesheet"> -->
</head>
<body>
	<header>
		<nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top alert-home">
			<a class="navbar-brand" href="#">
				<img src="{{asset('img/solu.jpg')}}" width="30" height="30" class="d-inline-block align-top" alt="">
				<b class="text-primary">SOLUGRIFOS</b> <small><b> - Plan</b> <b class="text-success">VERDE</b></small>
			</a>
		</nav>
	</header>

	<div id="wrapper" class="wrapper">
		<div id="content" class="">
			@yield('content')
		</div>
	</div>

	<script src="{{ asset('js/app.js') }}"></script>
	@yield('script')
</body>
</html>
