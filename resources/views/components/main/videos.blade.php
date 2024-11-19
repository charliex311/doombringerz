<div class="stream__body">
    <ul class="stream__list">

        @php $count_index = 0; @endphp
        @if (is_array($streams) && !empty($streams))
            @foreach($streams as $stream)
                @if (isset($stream['stream_url']))
                    @php $count_index++; @endphp
                    <div class="video-item">
                        <iframe src="{{ $stream['stream_url'] }}" frameborder="0" allowfullscreen="true" scrolling="no" height="160" width="250"></iframe>
                    </div>
                @endif
            @endforeach
        @endif

        @if ($count_index < 5)
            @if (!empty($videos))
                @foreach($videos as $video)
                    @if ($count_index + $loop->index < 5)
                        <div class="video-item">
                        <iframe width="250" height="160" src="https://www.youtube.com/embed/{{ $video->url }}?autoplay=0"></iframe>
                        </div>
                    @endif
                @endforeach
            @endif
        @endif

    </ul>
</div>