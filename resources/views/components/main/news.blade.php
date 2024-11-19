<section class="news section-margin">
    <div class="news__container main-container">
        <div class="news__body">
            <h1 class="news__title section-title">
                {{ __('Последние новости') }}
            </h1>
            <ul class="news__row">

                @foreach($articles as $article)
                    @php
                        $title = "title_" .app()->getLocale();
                    @endphp
                    <a style="background-image: url('{{ $article->image_url }}');" href="{{ route('news.show', $article) }}" class="news__row-block
                        @if($loop->iteration == 1)
                            news__row-block_large
                        @elseif($loop->iteration == 3)
                            news__row-block_full
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
            <a href="{{ route('news') }}" class="news__show-more">
                {{ __('Показать больше') }}
            </a>
        </div>
    </div>
</section>
