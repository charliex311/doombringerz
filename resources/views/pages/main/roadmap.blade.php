@extends('layouts.main')

@section('title', config('options.main_title_'.app()->getLocale(), '') )
@php
    $title = "title_" . app()->getLocale();
    $description = "description_" . app()->getLocale();
    $short_description = "short_description_" . app()->getLocale();
@endphp
@section('content')

    <div class="sparks-wrapper">
        <picture>
            <source type="image/webp" srcset="/img/bottom-sparks.webp">
            <img src="/img/bottom-sparks.png" alt="sparks">
        </picture>
    </div>
    <main class="main-padding roadmap-page" style="background-image: url('/img/roadmap-page/bg-roadmap.png');">

        <section class="roadmap">
            <div class="roadmap__container">
                <div class="roadmap__body">
                    <h1 class="roadmap__title main-title main-container">
                        {{ __('Дорожная карта') }}
                    </h1>
                    <div class="roadmap__wrapper roadmap__wrapper--slider swiper">
                        <ul class="roadmap__cards cards swiper-wrapper">

                            <li class="cards__item swiper-slide archive-card-item">
                                <button class="cards__close archive-card__close">
                                    <span></span>
                                    <span></span>
                                </button>
                                <div class="cards__inner">
                                    <div class="cards__icon">
                                        <img class="cards__icon-img" src="/storage/images/xKWcgpZgPzxBBdPNzvwcrMEWBcskVamrAHNKuP1O.png" alt="{{ __('Старые релизы') }}">
                                    </div>
                                    <div class="cards__info">
                                        <div class="cards__name">
                                            {{ __('Показать') }}
                                        </div>
                                        <div class="cards__date">
                                            {{ __('Старые релизы') }}
                                        </div>
                                    </div>
                                </div>
                            </li>

                            @foreach($releases as $release)
                                @php $road_groups = (isset($release) && $release->road_groups !== NULL) ? json_decode($release->road_groups) : []; @endphp

                                <li class="cards__item swiper-slide @if($loop->iteration <= ($releases->count() - 4)){{ 'archive-item' }}@else{{ 'cards__item--active' }}@endif">
                                        <button class="cards__close card__close">
                                            <span></span>
                                            <span></span>
                                        </button>
                                        <div class="cards__inner">
                                            <div class="cards__icon">
                                                <img class="cards__icon-img" src="{{ $release->image_url }}" alt="{{ $release->$title }}">
                                                @if($release->is_release !== 1)
                                                    <div class="cards__locked">
                                                        <img src="/img/sprite/lock-icon.svg" alt="lock-icon">
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="cards__info">
                                                <div class="cards__name">
                                                    {{ $release->$title }}
                                                </div>
                                                <div class="cards__category-name">
                                                    {{ getRoadmapCategoryById($release->category) }}
                                                </div>
                                                <div class="cards__date">
                                                    {{ getmonthname(date('m', strtotime($release->date))) }} {{ date('d', strtotime($release->date)) }}, {{ date('Y', strtotime($release->date)) }}
                                                </div>
                                            </div>
                                            <div class="cards__dropdown">
                                                <ul class="dropdowns">

                                                    @if(!empty($road_groups))
                                                        @foreach($road_groups as $road_group)
                                                            <li class="dropdowns__item">
                                                                <div class="dropdowns__item-selected">
                                                                    <p>
                                                                        {{ getRoadmapGroupById($road_group->id) }}
                                                                        <span>{{ count((array)$road_group->items) }} {{ __('записей') }}</span>
                                                                    </p>
                                                                    <img src="/img/sprite/arrow-down.svg" alt="arrow-down">
                                                                </div>

                                                                <ul class="dropdowns__hidden">
                                                                    <div class="dropdowns__hidden-inner">

                                                                        @if(isset($road_group->items))
                                                                            @foreach($road_group->items as $item)
                                                                                <li class="dropdowns__content roadmap--trigger">
                                                                                    <div class="dropdowns__content-heading">
                                                                                        {{ $item->$title }}
                                                                                    </div>
                                                                                    <div class="dropdowns__content-image">
                                                                                        <img src="{{ getImageUrl($item->image) }}" alt="hidden-content-image">
                                                                                    </div>
                                                                                    <div class="dropdowns__content-date" style="display: none;">
                                                                                        {{ getmonthname(date('m', strtotime($release->date))) }} {{ date('d', strtotime($release->date)) }}, {{ date('Y', strtotime($release->date)) }}
                                                                                    </div>
                                                                                    <div class="dropdowns__content-category" style="display: none;">
                                                                                        {{ getRoadmapGroupById($road_group->id) }}
                                                                                    </div>
                                                                                    <div class="dropdowns__content-text">
                                                                                        <p>{{ $item->$short_description }}</p>
                                                                                    </div>
                                                                                    <div class="dropdowns__content-fulltext" style="display: none;">
                                                                                        <p>{{ $item->$description }}</p>
                                                                                    </div>
                                                                                </li>
                                                                            @endforeach
                                                                        @endif

                                                                    </div>
                                                                </ul>
                                                            </li>
                                                        @endforeach
                                                    @endif

                                                </ul>
                                            </div>
                                        </div>
                                    </li>

                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
        </section>

        @include('partials.main.offer')

    </main>

    <div class="modal modal_roadmap" id="roadmap">
        <div class="modal__container">
            <div class="modal__body">
                <div class="modal__close">
                    <svg>
                        <use href="/img/sprite/sprite.svg#close-icon"></use>
                    </svg>
                </div>
                <div class="modal__grid">
                    <div class="modal__grid-item">
                        <h1 class="modal__heading"></h1>
                        <div class="modal__success-image">
                            <img src="/img/roadmap-page/skills-image.webp" alt="hidden-content-image">
                        </div>
                        <div class="modal__success-date">
                            <p></p>
                        </div>
                        <div class="modal__success-text">
                            <p></p>
                        </div>
                    </div>
                    <div class="modal__grid-item">
                        <div class="modal__alternative">
                            <span>{{ __('Категория') }}:</span> <span class="category"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script src="js/roadmap-slider.js"></script>
    <script>

        $(document).ready(function () {
            $('.roadmap--trigger').on('click', function (e) {
                e.stopPropagation();

                let heading = $(this).find('.dropdowns__content-heading').text();
                let html = $(this).find('.dropdowns__content-fulltext').html();
                let img_src = $(this).find('.dropdowns__content-image img').attr('src');
                let category = $(this).find('.dropdowns__content-category').text();
                let date = $(this).find('.dropdowns__content-date').text();

                $('#roadmap .modal__heading').text(heading);
                $('#roadmap .modal__success-text').html(html);
                $('#roadmap .modal__success-image img').attr('src', img_src);
                $('#roadmap .category').text(category);
                $('#roadmap .modal__success-date').text(date);

                $('#roadmap').addClass('show-modal');
            });

            $('.archive-card__close').click(function (e) {
                $(this).parent().toggleClass('archive-show-items');
                if ($(this).parent().hasClass('archive-show-items')) {
                    $('.archive-item').show();
                    $(this).parent().find('.cards__name').text("{{ __('Скрыть') }}");
                } else {
                    $('.archive-item').hide();
                    $(this).parent().find('.cards__name').text("{{ __('Показать') }}");
                }
            });
        });

    </script>
@endpush
