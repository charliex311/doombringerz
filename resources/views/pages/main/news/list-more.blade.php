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
