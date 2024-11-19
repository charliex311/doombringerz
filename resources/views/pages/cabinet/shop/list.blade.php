@extends('layouts.cabinet-shop')

@section('title', __('Магазин'))

@php
    $title = "title_" .app()->getLocale();
    $description = "description_" .app()->getLocale();
@endphp

@section('wrap')

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">@yield('title')</span>
                            </h5>
                            <div class="card-title__info btn-help">
                                <img src="/img/info-icon.svg" alt="info-icon">
                                <span class="referral-help">{{ __('Помощь') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                        </div>
                    </div>
                    <div class="card-inner">
                        <div class="layout">
                            <div class="layout-grid">
                                <div class="layout-content">
                                    <div class="panel">
                                        <div class="panel-top">
                                            <div class="panel-dropdown">
                                                    <select name="server_id" id="server_id" class="form-control selectpicker">
                                                        @foreach(getservers() as $server)
                                                            @if($server->id == $server_id)
                                                                <option value="{{ $server->id }}">{{ $server->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                            </div>
                                            <div class="panel-search">

                                                <form method="GET">
                                                    <input type="hidden" name="server_id" value="{{ $server_id }}">
                                                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                                                    <input class="panel-search__input" type="search" id="search" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Искать в магазине') }}">
                                                </form>

                                                <div class="panel-search__icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                                        <circle cx="11" cy="11" r="7.25" stroke="#ACADB1" stroke-width="1.5"/>
                                                        <path d="M17 16L21 20" stroke="#ACADB1" stroke-width="1.5"/>
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-container">
                                            <ul class="panel-flex panel-flex--scroll">

                                                @foreach(getmainshopcategories() as $category)
                                                        <li class="panel-flex__item panel-card @if($category_id == $category->id) panel-card--active @endif" data-catid="{{ $category->id }}" onclick="changeCategory('{{ $category->id }}', '0');">
                                                            <div class="panel-card__icon">
                                                                <img src="/img/category/shield-image.png" alt="shield-image">
                                                            </div>
                                                            <div class="panel-card__name">
                                                                {{ $category->$title }}
                                                            </div>
                                                        </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                        <ul class="panel-flex panel-flex--wrap">

                                            @foreach(getmainshopcategories() as $category)
                                                @if($category->id == $category_id && childshopcategories_count($category->id) > 0)
                                                    @foreach(getchildshopcategories($category->id) as $childcategory)
                                                        <li class="panel-toggle" data-catid="{{ $childcategory->id }}" onclick="scrollToCategory('{{ $childcategory->id }}');">
                                                            {{ $childcategory->$title }}
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="category">
                                        <div class="category-inner">

                                            @if(childshopcategories_count($category_id) > 0)
                                                @php $title = "title_" .app()->getLocale(); @endphp
                                                @foreach(getchildshopcategories($category_id) as $childcategory)

                                                    <div class="category-container">
                                                        <div class="category-header">
                                                            {{ $childcategory->$title }}
                                                        </div>
                                                        <ul class="category-grid">

                                                            @foreach($shopitems as $shopitem)
                                                                @if($shopitem->category_id != $childcategory->id) @continue @endif
                                                                <li class="category-grid__item block @if($shopitem->sale > 0) block--discount @endif" id="cat_{{ $shopitem->category_id }}">
                                                                    <a href="{{ route('shop.item.show', $shopitem) }}"
                                                                       class="block-image">
                                                                        <img src="{{ get_image_url($shopitem->image) }}"
                                                                             class="block-image__img" alt="cover-image">

                                                                        @if($shopitem->sale > 0)
                                                                            <div class="block-image__label block-image__label--green">
                                                                                <span class="block-image__label-text">-{{ $shopitem->discount }}%</span>
                                                                            </div>
                                                                        @endif
                                                                        @if($shopitem->label === 1)
                                                                            <div class="block-image__label block-image__label--yellow">
                                                                                <span class="block-image__label-text">{{ __('Популярный') }}</span>
                                                                            </div>
                                                                        @endif
                                                                    </a>
                                                                    <div class="block-data">
                                                                        <div class="block-header">
                                                                            {{ Str::limit(strip_tags($shopitem->$description), 60) }}
                                                                        </div>
                                                                        <div class="block-price">
                                                                            <div class="block-price__icon">
                                                                                <svg width="32" height="32"
                                                                                     viewBox="0 0 32 32" fill=""
                                                                                     xmlns="http://www.w3.org/2000/svg">
                                                                                    <g clip-path="url(#clip0_601_1328)">
                                                                                        <path fill-rule="evenodd"
                                                                                              clip-rule="evenodd"
                                                                                              d="M16 6C10.477 6 6 10.477 6 16C6 21.523 10.477 26 16 26C21.523 26 26 21.523 26 16C26 10.477 21.523 6 16 6ZM16 7C16 9.38695 15.0518 11.6761 13.364 13.364C11.6761 15.0518 9.38695 16 7 16C9.38695 16 11.6761 16.9482 13.364 18.636C15.0518 20.3239 16 22.6131 16 25C16 22.6131 16.9482 20.3239 18.636 18.636C20.3239 16.9482 22.6131 16 25 16C22.6131 16 20.3239 15.0518 18.636 13.364C16.9482 11.6761 16 9.38695 16 7Z"
                                                                                              fill=""/>
                                                                                    </g>
                                                                                    <defs>
                                                                                        <clipPath id="clip0_601_1328">
                                                                                            <rect width="32" height="32"
                                                                                                  fill="white"/>
                                                                                        </clipPath>
                                                                                    </defs>
                                                                                </svg>
                                                                            </div>

                                                                            @if($shopitem->sale > 0)
                                                                                <div class="block-price__text">
                                                                                    {{ $shopitem->sale }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                                                </div>
                                                                                <div class="block-price__previous">
                                                                                    {{ $shopitem->price }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                                                </div>
                                                                            @else
                                                                                <div class="block-price__text">
                                                                                    {{ $shopitem->price }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div class="block-actions">

                                                                        <a href="{{ route('shop.item.show', $shopitem) }}"
                                                                           class="block-more">
                                                                            <span>{{ __('Подробнее') }}</span>
                                                                        </a>

                                                                        <form action="{{ route('shop.cart.add') }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="item_id" value="{{ $shopitem->id }}">

                                                                            <button class="block-purchase btn">
                                                                                <div class="block-purchase__icon">
                                                                                    <img src="/img/basket-icon.svg"
                                                                                         alt="basket-icon">
                                                                                </div>
                                                                            </button>
                                                                        </form>


                                                                    </div>
                                                                </li>
                                                            @endforeach

                                                        </ul>
                                                    </div>

                                                @endforeach
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                @include('pages.cabinet.shop.cart')

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


{{--
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">@yield('title')</span>
                            </h5>
                            <div class="shop-search">
                                <form method="GET">
                                    <input type="hidden" name="server_id" value="{{ $server_id }}">
                                    <input type="hidden" name="category_id" value="{{ $category_id }}">
                                    <input type="search" id="search" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Искать в магазине') }}">

                                    @if(request()->has('search') && request()->query('search') != '')
                                        <button id="search-btn" style="display: none;"><img src="//img/shop/search-icon.png"/></button>
                                        <button id="search-clean" style="display: none;"><img src="//img/shop/x-icon3.png"/></button>
                                        <button id="search-reset"><img src="//img/shop/x-icon3.png"/></button>
                                    @else
                                        <button id="search-btn"><img src="//img/shop/search-icon.png"/></button>
                                        <button id="search-clean" style="display: none;"><img src="//img/shop/x-icon3.png"/></button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="card-inner p-0 border-top">

                                <div class="inner-content">
                                    <div class="inner-shop">
                                        <!--shop left side content-->
                                        <div class="inner-shop-left">
                                            <div class="inner-shop-middle">
                                                <!--shop menu-->
                                                <div class="inner-shop-menu">




                                                    @php $title = "title_" .app()->getLocale(); @endphp
                                                    @foreach(getmainshopcategories() as $category)

                                                        @if(childshopcategories_count($category->id) < 1)
                                                            <a class="category @if($category_id == $category->id) active @endif" data-catid="{{ $category->id }}" onclick="changeCategory('{{ $category->id }}', '0');">{{ $category->$title }}</a>
                                                        @else
                                                            <span @if($category_id == $category->id) class="active" @endif>
                                        <a data-catid="{{ $category->id }}" onclick="changeCategory('{{ $category->id }}', '0');">{{ $category->$title }}</a>
                                        <div class="inner-shop-menu-dropdown">
                                            @foreach(getchildshopcategories($category->id) as $childcategory)
                                                <a @if($category_id == $childcategory->id) class="active" @endif data-catid="{{ $childcategory->id }}" onclick="changeCategory('{{ $category->id }}', '{{ $childcategory->id }}');">{{ $childcategory->$title }}</a>
                                            @endforeach
                                        </div>
                                        </span>
                                                        @endif
                                                    @endforeach


                                                </div>

                                                <!--realm dropdown-->
                                                <div class="realm-search">
                                                    <div class="inner-realm-dropdown">
                                                        <button class="realm-dropdown-btn">
                                                            @foreach(getservers() as $server)
                                                                @if($server->id == $server_id)
                                                                    <p><span class="orange">{{ __('Сервер') }}</span>: {{ $server->name }}</p><img src="//img/shop/dropdown-icon.png"/>
                                                                @endif
                                                            @endforeach
                                                        </button>
                                                        <div class="realm-dropdown-content">
                                                            @foreach(getservers() as $server)
                                                                <a class="server" onclick="changeServer('{{ $server->id }}');" data-serverid="{{ $server->id }}">{{ __('Сервер') }}: {{ $server->name }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                    <!--search results text-->
                                                    <div class="search-result">
                                                        @if($total_shopitems == 1)
                                                            <span>{{ __('Результат') }}:</span><span class="orange"> {{ $total_shopitems }}</span>
                                                        @else
                                                            <span>{{ __('Результаты') }}:</span><span class="orange"> {{ $total_shopitems }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <!--items sections-->


                                            @if(childshopcategories_count($category_id) > 0)
                                                @php $title = "title_" .app()->getLocale(); @endphp
                                                @foreach(getchildshopcategories($category_id) as $childcategory)

                                                    <!--first section-->
                                                        <div class="inner-shop-section" id="{{ $childcategory->path }}">
                                                            <div class="inner-shop-section-title">
                                                                <div class="line-left"></div>
                                                                <p>{{ $childcategory->$title }}</p>
                                                                <div class="line-right"></div>
                                                            </div>
                                                            <div class="inner-shop-items">
                                                                @php
                                                                    $title = "title_" .app()->getLocale();
                                                                    $description = "description_" .app()->getLocale();
                                                                @endphp
                                                                @foreach($shopitems as $shopitem)
                                                                    @if($shopitem->category_id != $childcategory->id) @continue @endif
                                                                    <a href="{{ route('shop.item.show', $shopitem) }}" class="shop-item gradient-border" style="background: url('/storage/{{ $shopitem->image }}') top / cover no-repeat;">
                                                                        <div class="shop-item-detail">
                                                                            <form action="{{ route('shop.cart.add') }}" method="POST" class="s-item">
                                                                                @csrf
                                                                                <input type="hidden" name="item_id" value="{{ $shopitem->id }}">
                                                                                <input type="hidden" name="server_id" value="{{ $server_id }}">
                                                                                <input type="hidden" class="character_guid" name="character_guid" value="@isset($characters[0]){{ $characters[0]->guid }}@endisset">

                                                                                <p>{!! $shopitem->$title !!}</p>
                                                                                <div class="shop-price-buy">
                                                                                    <span>{{ __('Подробнее') }}</span>
                                                                                    <button type="submit">{{ $shopitem->price }} {{ config('options.server_0_coin_short_name', 'CoL') }} <img src="//img/shop/cart2-icon.png"></button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </a>
                                                                @endforeach

                                                            </div>
                                                        </div>
                                                        <!--end first section-->
                                                @endforeach

                                            @else

                                                <!--first section-->
                                                    <div class="inner-shop-section">
                                                        <div class="inner-shop-section-title">
                                                            <div class="line-left"></div>
                                                            @forelse(getmainshopcategories() as $category)
                                                                @if($category_id == $category->id)
                                                                    <p>{{ $category->$title }}</p>
                                                                @endif
                                                            @empty
                                                                <p>{{ __('Все') }}</p>
                                                            @endforelse

                                                            <div class="line-right"></div>
                                                        </div>
                                                        <div class="inner-shop-items">
                                                            @php
                                                                $title = "title_" .app()->getLocale();
                                                                $description = "description_" .app()->getLocale();
                                                            @endphp
                                                            @foreach($shopitems as $shopitem)
                                                                <a href="{{ route('shop.item.show', $shopitem) }}" class="shop-item" style="background: url('/storage/{{ $shopitem->image }}') top / cover no-repeat;">
                                                                    <div class="shop-item-detail">
                                                                        <form action="{{ route('shop.cart.add') }}" method="POST" class="s-item">
                                                                            @csrf
                                                                            <input type="hidden" name="item_id" value="{{ $shopitem->id }}">
                                                                            <input type="hidden" name="server_id" value="{{ $server_id }}">
                                                                            <input type="hidden" class="character_guid" name="character_guid" value="@isset($characters[0]){{ $characters[0]->guid }}@endisset">

                                                                            <p>{!! $shopitem->$title !!}</p>
                                                                            <div class="shop-price-buy">
                                                                                <span>{{ __('Подробнее') }}</span>
                                                                                <button type="submit">{{ $shopitem->price }} {{ config('options.server_0_coin_short_name', 'CoL') }} <img src="//img/shop/cart2-icon.png"></button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </a>
                                                            @endforeach

                                                        </div>
                                                    </div>
                                                    <!--end first section-->

                                                @endif

                                            </div>
                                        </div>


                                        <!--basket right side-->
                                    @include('pages.cabinet.shop.cart')
                                    <!--end basket right side-->

                                    </div>
                                </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
--}}

@endsection

@push('scripts')
    <script>
        $( document ).ready(function() {

            @if(getshopcategory($child_id) !== NULL)
                scrollToCategory('{{ getshopcategory($child_id)->path }}');
            @endif

            $(".item-qty").change(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('shop.cart.update') }}",
                    data: { item_id: $(this).data('itemid'), item_qty: $(this).val(), _token: $('input[name="_token"]').val() }
                }).done(function( msg ) {
                    location.reload();
                });
            });
            $("#search").on('input', function () {
                $("#search-reset").hide();
                $("#search-btn").show();
                if ($("#search").val() != '') {
                    $("#search-clean").show();
                } else {
                    $("#search-clean").hide();
                }
            });
            $("#search-clean").on('click', function () {
                console.log($("#search").val());
                $("#search").val('');
                $("#search-clean").hide();
                return false;
            });
            $("#search-reset").on('click', function () {
                $("#search").val('');
                location.load('/account/store');
                return false;
            });


        });

        function changeServer(server_id) {
            location.href = '/account/store?server_id='+server_id+'&category_id={{ $category_id }}';
        }
        function changeCategory(category_id, child_id) {
            console.log(category_id);
            console.log(child_id);
            location.href = '/account/store?server_id={{ $server_id }}&category_id='+category_id+'&child_id='+child_id;
        }

        function scrollToCategory(cat_id) {
            let scrollTop = $('#cat_' + cat_id).offset().top;
            $('html').animate({
                    scrollTop: scrollTop - 100
                }, 500
            );

        }
    </script>
@endpush
