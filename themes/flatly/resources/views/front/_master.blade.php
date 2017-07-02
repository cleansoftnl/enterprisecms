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


    <title>{{ $pageTitle or 'Dashboard' }} | {{ get_setting('site_title', 'WebEd') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <meta content="Frontend dashboard" name="description"/>

    {!! \Assets::renderStylesheets() !!}

    @php do_action(BASE_ACTION_HEADER_CSS) @endphp

    <link rel="stylesheet" href="{{ asset('themes/flatly/admin/theme/lte/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/flatly/admin/theme/lte/css/skins/_all-skins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('themes/flatly/admin/css/style.css') }}">
    <link href="themes/flatly/css/animate.min.css" rel="stylesheet">
    <link href="themes/flatly/css/lightbox.css" rel="stylesheet">
    <link href="themes/flatly/css/main.css" rel="stylesheet">
    <link href="themes/flatly/css/responsive.css" rel="stylesheet">

    <script type="text/javascript">
        var BASE_URL = '{{ asset('') }}',
            FILE_MANAGER_URL = '{{ route('admin::elfinder.popup.get') }}';
    </script>

    <link rel="shortcut icon" href="{{ get_setting('favicon', 'favicon.png') }}"/>


<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    {!! \Assets::renderScripts('top') !!}

    @stack('head')

    @yield('head')

    @php do_action('front_header_css') @endphp

    @yield('css')

    @php do_action('front_header_js') @endphp

    @php do_action(BASE_ACTION_HEADER_JS) @endphp
</head>

<body class="{{ $bodyClass or '' }} skin-purple sidebar-mini on-loading @php do_action(BASE_ACTION_BODY_CLASS) @endphp" id="top">

<!-- Loading state -->
<div class="page-spinner-bar">
    <div class="bounce1"></div>
    <div class="bounce2"></div>
    <div class="bounce3"></div>
</div>
<!-- Loading state -->

<div class="wrapper" id="site_wrapper">

    @php do_action('front_before_header_wrapper_content') @endphp

    {{--BEGIN Header--}}
    @include('webed-theme::front._partials.header')
    {{--END Header--}}

    {{--BEGIN Sidebar--}}
    @include('webed-theme::front._partials.sidebar')
    {{--END Sidebar--}}

    <div class="content-wrapper">
        <section class="content-header">
            {{--BEGIN Page title--}}
            @include('webed-theme::front._partials.page-title')
            {{--END Page title--}}
            {{--BEGIN Breadcrumbs--}}
            @include('webed-theme::front._partials.breadcrumbs')
            {{--END Breadcrumbs--}}
        </section>

        <section class="content">
            {{--BEGIN Flash messages--}}
            @include('webed-theme::front._partials.flash-messages')
            {{--END Flash messages--}}

    @php do_action('front_before_main_wrapper_content') @endphp
            {{--BEGIN Content--}}
            @yield('content')
            {{--END Content--}}
        </section>
    </div>

    @php do_action('front_before_footer_wrapper_content') @endphp
    {{--BEGIN Footer--}}
    @include('webed-theme::front._partials.footer')
    {{--END Footer--}}

    {{--BEGIN control sidebar--}}
    @include('webed-theme::front._partials.control-sidebar')
    {{--END control sidebar--}}
    @php do_action('front_bottom_wrapper_content') @endphp
</div>

@php do_action('front_bottom_content') @endphp


{{--Modals--}}
@include('webed-theme::front._partials.modals')

<!--[if lt IE 9]>
<script src="admin/plugins/respond.min.js"></script>
<script src="admin/plugins/excanvas.min.js"></script>
<![endif]-->

{{--BEGIN plugins--}}
<script src="{{ asset('themes/flatly/admin/theme/lte/js/app.js') }}"></script>
<script src="{{ asset('themes/flatly/admin/js/webed-core.js') }}"></script>
<script src="{{ asset('themes/flatly/admin/theme/lte/js/demo.js') }}"></script>
{!! \Assets::renderScripts('bottom') !!}
{{--END plugins--}}

@php do_action(BASE_ACTION_FOOTER_JS) @endphp

<script src="{{ asset('themes/flatly/admin/js/script.js') }}"></script>

@php do_action('front_footer_js') @endphp


@stack('js')

@yield('js')

@stack('js-init')

@yield('js-init')

</body>

</html>
