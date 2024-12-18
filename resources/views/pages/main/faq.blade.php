@extends('layouts.main')
@php
    $question = "question_" .app()->getLocale();
    $answer = "answer_" .app()->getLocale();
@endphp

@section('title', __('Частые вопросы'))

@section('content')

    <main>
        <section class="news-page">

            <div class="news-page__main">
                <div class="news-page__container main-container">
                    <div class="news-page__content">
                        <h1 class="news-page__title main-title">
                            {{ __('Частые вопросы') }}
                        </h1>
                    </div>
                </div>
            </div>
            <div class="news-page__inner dark:bg-gray-800">
                <div class="news-page__wrapper">
                    <div class="news-page__article">
                        <div class="news-page__info">
                            {!! config('options.faq_description_'.app()->getLocale()) !!}
                        </div>
                        <div class="news-page__accs">
                            <ul class="news-page__accs-list">

                                @foreach($faqs as $faq)
                                    <li class="news-page__accs-item">
                                    <div class="news-page__accs-heading">
                                        {{ $faq->$question }}
                                    </div>
                                    <div class="news-page__accs-hidden">
                                        <div class="news-page__accs-content">
                                            <p>{!! $faq->$answer !!}</p>
                                        </div>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>

                    </div>
                </div>
            </div>

        </section>

        @include('partials.main.offer')

    </main>

@endsection
