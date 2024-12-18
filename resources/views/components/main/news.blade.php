<section class="news section-margin dark:bg-gray-800">
    <div class="news__container main-container">
        <div class="news__body">
            <h1 class="news__title section-title dark:text-gray-50">
                {{ __('Последние новости') }}
            </h1>

            <div class="line-heading"></div>

            <div class="mb-6 text-lg">Announcements and updates on game servers, merchandise drops, and any
                major news from Doombringerz. Behind-the-scenes content, Q&A with Doombringerz, etc.</div>

            <ul class="news__row">

                @foreach ($articles as $article)
                    @php
                        $title = 'title_' . app()->getLocale();
                    @endphp
                    <a style="background-image: url('{{ $article->image_url }}');"
                        href="{{ route('news.show', $article) }}"
                        class="news__row-block
                        @if ($loop->iteration == 1) news__row-block_large
                        @elseif($loop->iteration == 3)
                            news__row-block_full @endif">
                        <div class="news__row-info">
                            <div class="news__row-info-heading">
                                {{ getmonthname($article->created_at->format('m')) }}
                                {{ $article->created_at->format('d') }}, {{ $article->created_at->format('Y') }}
                            </div>
                            <div class="news__row-info-descr">
                                <p class="!text-gray-50">
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
