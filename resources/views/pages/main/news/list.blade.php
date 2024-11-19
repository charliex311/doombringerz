@extends('layouts.main')
@section('title', __('Новости') . ' - ' . config('options.main_title_'.app()->getLocale(), '') )

@section('content')

    <main class="main-padding news-body">
        <div class="top-wrapper">
            <section class="news news-list section-margin">
                <div class="news__container main-container">
                    <div class="news__body">
                        <h1 class="news-list__title news__title main-title">
                            {{ __('Последние новости') }}
                        </h1>
                        <ul class="news__row">
                            @foreach($articles as $article)
                                @php
                                    $title = "title_" .app()->getLocale();
                                @endphp
                                <a style="background-image: url('{{ $article->image_url }}');" href="{{ route('news.show', $article) }}" class="news__row-block
                                    @if($loop->iteration == 1 && 6)
                                        news__row-block_large
                                    @elseif($loop->iteration == 3)
                                        news__row-block_full
                                    @elseif($loop->iteration == 6)
                                        news__row-block_large news__row-block_full
                                    @endif">
                                    <div class="news__row-info">
                                        <div class="news__row-info-heading">
                                            {{ getmonthname($article->created_at->format('m')) }} {{ $article->created_at->format('d') }}, {{ $article->created_at->format('Y') }}
                                        </div>
                                        <div class="news__row-info-descr">
                                            <p>
                                                {{ $article->$title }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </ul>
                        <a class="news__show-more news__show-more_full">
                            {{ __('Показать больше') }}
                        </a>
                    </div>
                </div>
            </section>

            @include('partials.main.community')

        </div>

        @include('partials.main.offer')

    </main>


@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            let page = 2;
            $('.news__show-more_full').on('click', function (e) {
                $.get('{{ route('news.more') }}?page=' + page, function(html){
                    $(".news__row").append(html);

                    if(html.length < 1) {
                        $('.news__show-more_full').hide();
                    }
                    page++;
                });
            });
        });
    </script>
@endpush
