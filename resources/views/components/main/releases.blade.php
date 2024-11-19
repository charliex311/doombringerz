<section class="timeline">
    <h>{{ __('График релизов') }}</h>
    <div class="line"></div>
    <div class="timeline-items">

    @foreach($releases as $release)
        @php
            $title = "title_" .app()->getLocale();
            $description = "description_" .app()->getLocale();
        @endphp
            <!-- release -->
            <a href="{{ $release->link }}" class="t-item">
                <div class="time-logo"><img src="/storage/{{ $release->image }}">
                    {{--
                    <div class="expansion-d">
                        {!! $release->$description !!}
                    </div>
                    --}}
                </div>
                @php
                    if($release->is_release == 1) {
                        $status = 'on';
                    } else {
                        $status = 'off';
                    }
                @endphp
                <div class="timeline-progress" style="background: url(images/timeline-{{ $status }}.png) top no-repeat;"></div>
                <p>{{ $release->$title }}</p>
                <p1>{{ $release->date }}</p1>
            </a>
            <!--end release-->
    @endforeach

    </div>
</section>