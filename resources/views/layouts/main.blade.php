<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" x-data="{ darkMode: localStorage.getItem('dark') ? (localStorage.getItem('dark') === 'true') : true }" x-init="(() => { !localStorage.getItem('dark') ? localStorage.setItem('dark', true) : ''}), $watch('darkMode', val => localStorage.setItem('dark', val))" x-bind:class="{ 'dark': darkMode }">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title') • {{ config('options.title', 'WoW') }}</title>
    <meta property="og:title" content="@yield('title') • {{ config('options.title', 'WoW') }}">
    <meta property="robots" content="index,follow">
    <meta property="og:site_name" content="{{ config('options.title', 'WoW') }}">
    <meta property="og:locale" content="{{ app()->getLocale() }}">
    <meta property="og:type" content="website">
    <meta property="og:author" content="{{ config('app.name', 'WoW') }}">
    <meta property="og:url" content="{{ config('app.url', '/') }}">
    <meta property="og:description" content="{{ config('options.meta_decription_' . app()->getLocale(), '') }}">
    <meta name="keywords" content="{{ config('options.meta_keywords_' . app()->getLocale(), '') }}">
    <meta property="og:image" content="{{ config('app.url', '/') }}image_src.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1024">
    <meta property="og:image:height" content="536">
    <meta name="author" content="{{ config('app.name', 'WoW') }}">
    <meta name="viewport" content="width=device-width">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:creator" content="{{ config('options.title', 'WoW') }}">
    <meta property="twitter:description" content="{{ config('options.meta_decription_' . app()->getLocale(), '') }}">

    <base href="{{ config('app.url', '/') }}">

    <link rel="shortcut icon" href="/favicon.png">
    <link rel="apple-touch-icon" sizes="256x256" href="/favicon.png">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css">
    <link rel="stylesheet" href="/css/style.min.css?ver=1.1{{ strtotime('now') }}">

    <link rel="stylesheet" href="/css/addition.css?ver=1.1{{ strtotime('now') }}">
    <link rel="stylesheet" href="/css/protip.min.css?ver=1.1{{ strtotime('now') }}">

    {!! config('options.google_analitics') !!}
    {!! config('options.yandex_metric') !!}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css"
        integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    @stack('head')
</head>

<body class="dark:bg-gray-800 dark:text-gray-50">

    @include('partials.main.fullscreen-loader')
    @include('partials.main.header')

    @include('partials.main.menu')

    @yield('content')

    @include('partials.main.footer')

    @include('partials.main.modals')

    <!-- SCRIPTS -->
    <script src="/js/jquery-3.6.0.min.js"></script>
    <script src="/js/_modals.js"></script>
    <script src="/js/_burger.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script src="/js/common.js?ver=1.1{{ strtotime('now') }}"></script>
    <script src="/js/protip.min.js?ver=1.1{{ strtotime('now') }}"></script>
    <script src="/js/featuresSlider.js"></script>
    <script src="/js/dropdowns.js"></script>

    @include('partials.main.scripts')
    <script src="//unpkg.com/alpinejs" defer></script>

    @stack('scripts')
    <!-- END SCRIPTS -->

    <script>
        $(document).ready(function() {
            $("#fullScreenLoader").hide();
        })
    </script>

</body>

</html>
