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
    <title>{{ App\Setting::get('website_title') }}</title>

    <!-- Fonts -->
    <link href="{{ asset('store/stylesheets/font.css') }}" rel='stylesheet' type='text/css'>

    <!-- Styles -->
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link href="{{ asset('store/stylesheets/font-awesome.min.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/jquery.camera.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/jquery.fancybox-buttons.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/cs.animate.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/application.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/swatch.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/jquery.owl.carousel.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/jquery.bxslider.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/bootstrap.min.3x.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/cs.bootstrap.3x.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/cs.global.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/cs.style.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/cs.media.3x.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/spr.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/addthis.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/store.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="{{ asset('store/stylesheets/custom.css') }}" rel="stylesheet" type="text/css" media="all">
    <link href="https://unpkg.com/nanogallery2@3.0.5/dist/css/nanogallery2.woff.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="https://unpkg.com/nanogallery2@3.0.5/dist/css/nanogallery2.min.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
    <script src="https://kit.fontawesome.com/yourcode.js" crossorigin="anonymous"></script>
    @stack('css')

    <!-- JavaScript -->
    <script src="{{ asset('store/javascripts/jquery-1.9.1.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.imagesloaded.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/bootstrap.min.3x.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.easing.1.3.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.camera.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/cookies.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/modernizr.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/application.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.owl.carousel.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.bxslider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/skrollr.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.fancybox-buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/jquery.zoom.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/cs.script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('store/javascripts/lodash.custom.min.js') }}" type="text/javascript"></script>
    <script src="https://www.google.com/recaptcha/api.js?onload=renderCaptcha&render=explicit"></script>
    <script src="https://unpkg.com/nanogallery2@3.0.5/dist/jquery.nanogallery2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
</head>

<body {{ !Request::routeIs('store') ? 'itemscope="" itemtype="http://schema.org/WebPage"' : '' }} class="{{ $bodyClass }} notouch">

    <!-- Header -->
    @include('store.parts._header')

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    @include('store.parts._footer')

<script src="{{ asset('store/javascripts/cs.global.js') }}" type="text/javascript"></script>
<script>
    var renderCaptcha = function() {
        uvelStore.renderCaptcha('{{ config('app.recaptcha_key') }}');
    }
</script>
@stack('scripts')
@stack('scoped-scripts')
</body>
</html>
