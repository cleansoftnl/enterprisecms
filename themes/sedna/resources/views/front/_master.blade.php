<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <base href="{{ asset('') }}">

    <title>{{ $pageTitle or '' }} - {{ get_setting('site_title', 'WebEd') ?: 'WebEd' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    {!! seo()->render() !!}

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">


    <link rel="apple-touch-icon" href="{{ asset('themes/sedna/apple-touch-icon.png') }}">

    <link rel="stylesheet" href="{{ asset('themes/sedna/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/sedna/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('themes/sedna/css/jquery.fancybox.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/sedna/css/flexslider.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/sedna/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/sedna/css/queries.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/sedna/css/etline-font.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/sedna/bower_components/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    @php do_action('front_header_css') @endphp
    @yield('css')

    @php do_action('front_header_js') @endphp
</head>

<body class="{{ $bodyClass or '' }} @php do_action('front_body_class') @endphp" id="top">

<div class="wrapper" id="site_wrapper">
    @php do_action('front_before_header_wrapper_content') @endphp

    <header class="header" id="header">
@include('webed-theme::front._partials.header')
    </header>

    @include('webed-theme::front._partials.flash-messages')

    @php do_action('front_before_main_wrapper_content') @endphp


@yield('content')


    @php do_action('front_before_footer_wrapper_content') @endphp

@include('webed-theme::front._partials.footer')
    @php do_action('front_bottom_wrapper_content') @endphp
@yield('other-content')
@php do_action('front_bottom_content') @endphp

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<![endif]-->
<script src="{{ asset('themes/sedna/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js') }}"></script>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="{{ asset('themes/sedna/js/vendor/jquery-1.11.2.min.js') }}"><\/script>')</script>
<script src="{{ asset('themes/sedna/js/jquery.fancybox.pack.js') }}"></script>
<script src="{{ asset('themes/sedna/js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('themes/sedna/js/scripts.js') }}"></script>
<script src="{{ asset('themes/sedna/js/jquery.flexslider-min.js') }}"></script>
<script src="{{ asset('themes/sedna/bower_components/classie/classie.js') }}"></script>
<script src="{{ asset('themes/sedna/bower_components/jquery-waypoints/lib/jquery.waypoints.min.js') }}"></script>

@php do_action('front_footer_js') @endphp
@yield('js')
@yield('js-init')

</body>

</html>
