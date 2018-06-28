<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <link rel="canonical" href="/" />
    <meta name="description" content="" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title -->
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('assets/stylesheets/font.css') }}" rel='stylesheet' type='text/css'>

    <!-- Styles -->
	<link href="{{ asset('assets/stylesheets/font-awesome.min.css') }}" rel="stylesheet" type="text/css" media="all"> 
	<link href="{{ asset('assets/stylesheets/jquery.camera.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/jquery.fancybox-buttons.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/cs.animate.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/application.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/swatch.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/jquery.owl.carousel.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/jquery.bxslider.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/bootstrap.min.3x.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/cs.bootstrap.3x.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/cs.global.css') }}" rel="stylesheet" type="text/css" media="all">
	<link href="{{ asset('assets/stylesheets/cs.style.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('assets/stylesheets/cs.media.3x.css') }}" rel="stylesheet" type="text/css" media="all">
    
	<!-- JavaScript -->
	<script src="{{ asset('assets/javascripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.imagesloaded.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/bootstrap.min.3x.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.easing.1.3.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.camera.min.js') }}" type="text/javascript"></script>	
	<script src="{{ asset('assets/javascripts/cookies.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/modernizr.js') }}" type="text/javascript"></script>  
	<script src="{{ asset('assets/javascripts/application.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.owl.carousel.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.bxslider.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/skrollr.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.fancybox-buttons.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/javascripts/jquery.zoom.js') }}" type="text/javascript"></script>	
	<script src="{{ asset('assets/javascripts/cs.script.js') }}" type="text/javascript"></script>
</head>

<body class="templateIndex notouch">

<script src="{{ asset('assets/javascripts/cs.global.js') }}" type="text/javascript"></script>
</body>
</html>