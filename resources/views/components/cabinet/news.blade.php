<div id="carouselExConInd" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        @foreach($articles as $article)
            <li data-target="#carouselExConInd" data-slide-to="{{ $loop->index }}" class="@if ($loop->first) active @endif"></li>
        @endforeach
    </ol>
    <div class="carousel-inner mb-3" style="max-height: 250px;border-radius: 10px">
        @foreach($articles as $article)
            <div class="carousel-item @if ($loop->first) active @endif" style="max-height: 250px">
                <img src="{{ $article->image_url }}" class="d-block w-100" alt="carousel">
                <div class="carousel-caption d-none d-md-block">
                    <a href="{{ $article->url }}"><h5 class="text-uppercase">{{ $article->title }}</h5></a>
                    <p>{{ $article->created_at->format('d.m.Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselExConInd" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Назад</span>
    </a>
    <a class="carousel-control-next" href="#carouselExConInd" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Вперед</span>
    </a>
</div>
