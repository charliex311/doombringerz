@extends('layouts.main')
@php
  $title = "title_" .app()->getLocale();
  $description = "description_" .app()->getLocale();
@endphp

@section('title', $article->$title . ' - ' . config('options.main_title_'.app()->getLocale(), '') )

@section('content')

    <main>
        <section class="news-page">
            <div class="news-page__main">
                <div class="news-page__container main-container">
                    <div class="news-page__content">
                        <h1 class="news-page__title main-title">
                            {{ $article->$title }}
                        </h1>
                        <div class="news-page__date">
                            {{ getmonthname($article->created_at->format('m')) }} {{ $article->created_at->format('d') }}, {{ $article->created_at->format('Y') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="news-page__inner">
                <div class="news-page__wrapper">
                    {!! $article->$description !!}
                </div>
            </div>
        </section>

        @include('partials.main.offer')

    </main>

@endsection
