<section class="features">
    <div class="features__container main-container">
        <div class="features__body">
            <h4 class="features__title section-title">
                {{ __('Особенности проекта') }}
            </h4>
            <div class="features__inner swiper">
                <ul class="features__row swiper-wrapper">

                    @foreach($features as $feature)
                        @php
                            $title = "title_" .app()->getLocale();
                            $description = "description_" .app()->getLocale();
                        @endphp
                    <li class="features__card swiper-slide">
                        <div class="features__card-icon">
                            <img src="{{ $feature->image_url }}" alt="features-card">
                        </div>
                        <div class="features__info">
                            <div class="features__card-name">
                                {{ $feature->$title }}
                            </div>
                            <div class="features__descr">
                                {!! $feature->$description !!}
                            </div>
                        </div>
                    </li>
                    @endforeach

                </ul>
                <div class="features__nav">
                    <div class="features__arrow features__arrow_prev">
                        <img src="/img/features/arrow-left.svg" alt="prev-arrow">
                    </div>
                    <div class="features__arrow features__arrow_next">
                        <img src="/img/features/arrow-right.svg" alt="next-arrow">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
