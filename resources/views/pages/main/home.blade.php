@extends('layouts.main')

@section('title', config('options.main_title_' . app()->getLocale(), ''))

@section('content')

    <main>
        <div class="sparks-wrapper">
            <picture>
                <source type="image/webp" srcset="/img/bottom-sparks.webp">
                <img src="/img/bottom-sparks.png" alt="sparks">
            </picture>
        </div>

        <section class="home">
            <div
                class="absolute w-full bottom-0 left-0 h-full z-[10] bg-gradient-to-t from-white dark:from-gray-800 transition duration-300">
            </div>
            <div class="home__video">
                <video autoplay="" loop="" muted="">
                    <source src="/img/bg_header.mp4" type="video/mp4">
                    <source src="/img/bg_header.webm" type="video/webm">
                </video>
            </div>
            <div class="home__wrapper">
                <div class="home__container main-container">
                    <div class="home__body">
                        <a href="/" class="home__logo">
                            <picture class="hidden dark:block">
                                <source type="image/png" srcset="/img/logo-light.png">
                                <img src="/img/logo-light.png" alt="logo" class="object-contain h-16 hidden dark:block">
                            </picture>

                            <picture class="dark:hidden">
                                <source type="image/png" srcset="/img/logo-dark.png">
                                <img src="/img/logo-dark.png" alt="logo" class="object-contain h-16 dark:hidden">
                            </picture>
                        </a>
                        <div class="home__info">
                            <h1 class="home__title main-title dark:text-gray-50">
                                {!! config('options.main_title_' . app()->getLocale(), '') !!}
                            </h1>
                            <div class="home__descr dark:text-gray-50">
                                <p>{!! config('options.main_welcome_' . app()->getLocale(), '') !!}</p>
                            </div>
                            <a href="/about" class="btn dark:text-gray-50">
                                <span>About us</span>
                            </a>
                        </div>
                    </div>
                    <div class="servers">
                        <ul class="servers__row">

                            @foreach (getservers() as $server)
                                <li
                                    class="servers__row-item servers__row-item_{{ strtolower(server_status($server->id)) }}">
                                    <div class="servers__row-icon">
                                        <img src="/img/servers/server-{{ strtolower(server_status($server->id)) }}-icon.png"
                                            alt="server-{{ strtolower(server_status($server->id)) }}-icon">
                                    </div>
                                    <div class="servers__info">
                                        <div class="servers__name">
                                            {{ $server->name }}
                                        </div>
                                        <div class="servers__state">
                                            {{ server_status($server->id) }}
                                        </div>
                                    </div>
                                </li>
                            @endforeach

                            {{--
                            <li class="servers__row-item servers__row-item_soon">
                                <div class="servers__row-icon">
                                    <img src="/img/servers/server-soong-icon.png" alt="server-offline-icon">
                                </div>
                                <div class="servers__info">
                                    <div class="servers__name">
                                        Astral
                                    </div>
                                    <div class="servers__state">
                                        Opening soon
                                    </div>
                                </div>
                            </li>
                            <li class="servers__row-item servers__row-item_online">
                                <div class="servers__row-icon">
                                    <img src="/img/servers/server-online-icon.png" alt="server-online-icon">
                                </div>
                                <div class="servers__info">
                                    <div class="servers__name">
                                        Dark Angel
                                    </div>
                                    <div class="servers__state">
                                        5 483 In Game
                                    </div>
                                </div>
                            </li>
                            --}}

                            {{-- <div class="servers__row-item servers__row-item_about">
                                <a href="{{ route('about_servers') }}" class="servers__btn btn">
                                    <span>{{ __('О Серверах') }}</span>
                                </a>
                            </div> --}}
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        <x-main.News />

        @include('partials.main.community')

        <x-main.Features />

        @include('partials.main.offer')

    </main>

@endsection
