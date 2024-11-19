<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="js">
<head>
    <meta charset="utf-8">
    @hasSection('title')
        <title>@yield('title') • {{ config('options.title', 'WoW') }}</title>
    @else
        <title>WoW</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/backend.css">
    <link rel="stylesheet" href="/assets/css/dashlite.css">
    <link rel="stylesheet" href="/assets/css/theme.css">

    @if(session()->has('theme') && session()->get('theme') == 'dark')
        <link rel="stylesheet" href="/assets/css/backend-dark.css?ver=2">
    @else
        <link rel="stylesheet" href="/assets/css/theme.css">
    @endif

    <link rel="shortcut icon" href="/favicon.png">

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/js/ckeditor/ckeditor.js"></script>

    @stack('head')
</head>

@yield('body')


<!-- JavaScript -->
<script src="/assets/js/bundle.js?ver=1.0.0"></script>
<script src="/assets/js/scripts.js?ver=1.0.0"></script>
<script src="/assets/js/charts/gd-general.js?ver=1.0.0"></script>

@stack('scripts')

</html>
