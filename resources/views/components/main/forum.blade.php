<ul class="item-info__forums forums-list">

    @if(is_array($posts))
    @foreach($posts as $post)
    <li class="forums-list__item">
        <a href="{{ config('options.forum_link', '#') }}/index.php?threads/{{ $post->tid }}" class="forums-list__link">
            <div class="forums-list__avatar">
                <picture>

                <!-- <source srcset="{{ config('options.forum_link', '#') }}/data/avatars/m/0/{{ $post->avatar }}.jpg" type="img/webp"> -->
                   <!-- <img src="{{ config('options.forum_link', '#') }}/data/avatars/m/0/{{ $post->avatar }}.jpg" alt="Image"> -->

                    <source srcset="img/info/ava.webp" type="img/webp">
                    <img src="img/info/ava.jpg" alt="Image">

                </picture>
            </div>
            <div class="forums-list__content">
                <div class="forums-list__title">{{ Str::limit($post->title, 28) }}</div>
                <div class="forums-list__info">
                    <div class="forums-list__date">{{ date('d.m.Y H:i', $post->last_post) }}</div>
                    <div class="forums-list__author">{{ __('Автор') }}: {{ $post->last_poster_name }}</div>
                </div>
            </div>
        </a>
    </li>
    @endforeach
    @endif

</ul>