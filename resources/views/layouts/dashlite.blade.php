<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="js">
<head>
    <meta charset="utf-8">
    @hasSection('title')
        <title>@yield('title') • {{ config('options.title', 'WoW') }}</title>
    @else
        <title>WoW WizardCP</title>
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/assets/css/cabinet.css?ver=1.145">
    <link rel="stylesheet" href="/assets/css/header.css?ver=1.145">
    <link rel="shortcut icon" href="/favicon.png">
    @stack('styles')

    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    @stack('head')
</head>


<body class="nk-body bg-white npc-default has-aside dark-mode">

@include('partials.cabinet.header-main')

<div class="nk-app-root">
    <div class="nk-main">
        @yield('content')
    </div>
</div>

<script src="/assets/js/bundle.js"></script>
<script src="/assets/js/scripts.js"></script>
<script src="/assets/js/ion.rangeSlider.min.js"></script>
@stack('scripts')
</body>
</html>
