@extends('layouts.main')

@section('content')

    <main>
        <section class="news-page">
            <div class="news-page__main">
                <div class="news-page__container main-container">
                    <div class="news-page__content">
                        <h1 class="news-page__title main-title">
                            @yield('title')
                        </h1>
                    </div>
                </div>
            </div>
            <div class="news-page__inner">
                <div class="news-page__wrapper">
                    <article class="news-page__article">
                        <div class="news-page__info">
                            @yield('wrap')
                        </div>
                    </article>
                </div>
            </div>
        </section>

    </main>

@endsection
