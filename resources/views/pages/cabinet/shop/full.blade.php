@extends('layouts.cabinet-shop')

@php
    $title = "title_" .app()->getLocale();
    $description = "description_" .app()->getLocale();
    $description_add = "description_add_" .app()->getLocale();
@endphp

@section('title', strip_tags($shopitem->$title))

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
                                    <div class="panel"></div>
                                    <div class="main">
                                        <div class="info">
                                            <div class="info-row">
                                                <div class="info-image" style="background-image: url('{{ get_image_url($shopitem->image) }}');">
                                                </div>
                                                <div class="info-data">
                                                    <div class="info-header">
                                                        {!! $shopitem->$description !!}
                                                    </div>
                                                    <div class="block-price @if($shopitem->sale > 0) block--discount @endif">
                                                        <div class="block-price__icon">
                                                            <svg width="32" height="32" viewBox="0 0 32 32" fill="" xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_601_1328)">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 6C10.477 6 6 10.477 6 16C6 21.523 10.477 26 16 26C21.523 26 26 21.523 26 16C26 10.477 21.523 6 16 6ZM16 7C16 9.38695 15.0518 11.6761 13.364 13.364C11.6761 15.0518 9.38695 16 7 16C9.38695 16 11.6761 16.9482 13.364 18.636C15.0518 20.3239 16 22.6131 16 25C16 22.6131 16.9482 20.3239 18.636 18.636C20.3239 16.9482 22.6131 16 25 16C22.6131 16 20.3239 15.0518 18.636 13.364C16.9482 11.6761 16 9.38695 16 7Z" fill=""></path>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_601_1328">
                                                                        <rect width="32" height="32" fill="white"></rect>
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

                                                    <form action="{{ route('shop.cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="item_id" value="{{ $shopitem->id }}">

                                                        <button class="info-cart btn">
                                                            <div class="info-cart__icon">
                                                                <img src="/img/basket-icon.svg" alt="basket-icon">
                                                            </div>
                                                            <div class="info-cart__text">
                                                                {{ __('В корзину') }}
                                                            </div>
                                                        </button>
                                                    </form>

                                                    <div class="info-text">
                                                        {!! $shopitem->$description_add !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="category">
                                            <div class="category-inner">
                                                <div class="category-container">
                                                    <div class="category-header">
                                                        {{ __('Вместе с этим часто покупают') }}
                                                    </div>
                                                    <ul class="category-grid">

                                                        @foreach($togethers as $together)
                                                            <li class="category-grid__item block @if($together->sale > 0) block--discount @endif" id="cat_{{ $together->category_id }}">
                                                                <a href="{{ route('shop.item.show', $together) }}"
                                                                   class="block-image">
                                                                    <img src="{{ get_image_url($together->image) }}"
                                                                         class="block-image__img" alt="cover-image">

                                                                    @if($together->sale > 0)
                                                                        <div class="block-image__label block-image__label--green">
                                                                            <span class="block-image__label-text">-{{ $together->discount }}%</span>
                                                                        </div>
                                                                    @endif
                                                                    @if($together->label === 1)
                                                                        <div class="block-image__label block-image__label--yellow">
                                                                            <span class="block-image__label-text">{{ __('Популярный') }}</span>
                                                                        </div>
                                                                    @endif
                                                                </a>
                                                                <div class="block-data">
                                                                    <div class="block-header">
                                                                        {{ Str::limit(strip_tags($together->$description), 60) }}
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

                                                                        @if($together->sale > 0)
                                                                            <div class="block-price__text">
                                                                                {{ $together->sale }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                                            </div>
                                                                            <div class="block-price__previous">
                                                                                {{ $together->price }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                                            </div>
                                                                        @else
                                                                            <div class="block-price__text">
                                                                                {{ $together->price }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="block-actions">

                                                                    <a href="{{ route('shop.item.show', $together) }}"
                                                                       class="block-more">
                                                                        <span>{{ __('Подробнее') }}</span>
                                                                    </a>

                                                                    <form action="{{ route('shop.cart.add') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="item_id" value="{{ $together->id }}">

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
                                            </div>
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
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">

                        <div class="inner-content">
                            <div class="inner-shop">

                                <!--basket left side-->
                                <div class="inner-shop-left">
                                    <div class="inner-shop-middle">


                                        @foreach (['danger', 'warning', 'success', 'info'] as $type)
                                            @if(Session::has('alert.' . $type))
                                                @foreach(Session::get('alert.' . $type) as $message)
                                                    <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon">
                                                        <span>{{ $message }}</span>
                                                    </div>
                                            @endforeach
                                        @endif
                                    @endforeach


                                    <!--navigation basket cart-->
                                        <div class="inner-basket-navigation-cart">
                                            <div class="inner-basket-navigation">
                                                <button><a href="{{ url()->previous() }}"><img src="//img/shop/back-icon.png"/>{{ __('Назад') }}</a></button>
                                                <a href="{{ route('shop') }}">{{ __('Магазин') }}</a>

                                                @if($category)
                                                    <span><img src="//img/shop/arrow-right-yellow.png"></span>
                                                    <a href="{{ route('shop') }}/?category_id={{ $category->id }}">{{ $category->$title }}</a>
                                                @else
                                                    <span><img src="//img/shop/arrow-right-yellow.png"></span>
                                                    <a href="{{ route('shop') }}">{{ __('Все') }}</a>
                                                @endif

                                                <span><img src="//img/shop/arrow-right-yellow.png"></span>
                                                <a class="active">{{ strip_tags($shopitem->$title) }}</a>
                                            </div>
                                        </div>
                                        <!--end navigation-->
                                        <!--shop item details-->
                                        <div class="shop-item-details">
                                            <div class="shop-item-top-details">
                                                <!--left details-->
                                                <div class="shop-item-details-left">
                                                    <form action="{{ route('shop.cart.add') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="item_id" value="{{ $shopitem->id }}">
                                                        <input type="hidden" name="server_id" value="{{ $server_id }}">

                                                        <h>{!! $shopitem->$title !!}</h>
                                                        {!! $shopitem->$description !!}
                                                        <div class="shop-item-details-left-buttons">
                                                            <span>{{ $shopitem->price }} <img src="//img/shop/tc-icon.png"/></span>
                                                            <button type="submit">{{ __('В корзину') }}</button>
                                                        </div>
                                                    </form>

                                                </div>
                                                <!--item image-->
                                                <div class="shop-item-details-right" style="background: url('/storage/{{ $shopitem->image }}') top / cover no-repeat;"></div>

                                            </div>
                                        </div>
                                        <!--shop item details end-->
                                        <div class="shop-item-details-additional-info">
                                            <h>{{ __('Дополнительная Информация') }}</h>
                                            <div class="details-additional-info">
                                                {!! $shopitem->$description_add !!}
                                            </div>
                                        </div>
                                        <div class="shop-item-details-additional-info inner-shop-section">
                                            <h>{{ __('Похожие товары') }}</h>
                                            <div class="inner-shop-items">
                                                @foreach($related_shopitems as $related_shopitem)
                                                    <a  href="{{ route('shop.item.show', $related_shopitem) }}" class="shop-item" style="background: url('/storage/{{ $related_shopitem->image }}') top / cover no-repeat;">
                                                        <div class="shop-item-detail">
                                                            <form action="{{ route('shop.cart.add') }}" method="POST" class="s-item">
                                                                @csrf
                                                                <input type="hidden" name="item_id" value="{{ $related_shopitem->id }}">
                                                                <input type="hidden" name="server_id" value="{{ $server_id }}">
                                                                <input type="hidden" class="character_guid" name="character_guid" value="@isset($characters[0]){{ $characters[0]->guid }}@endisset">

                                                                <p>{!! $related_shopitem->$title !!}</p>
                                                                <div class="shop-price-buy">
                                                                    <span>{{ __('Подробнее') }}</span>
                                                                    <button type="submit">{{ $related_shopitem->price }} {{ config('options.server_0_coin_short_name', 'CoL') }} <img src="//img/shop/cart2-icon.png"></button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>

                                        </div>
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
             $( ".item-qty" ).change(function() {
                 $.ajax({
                     type: "POST",
                     url: "{{ route('shop.cart.update') }}",
                     data: { item_id: $(this).data('itemid'), item_qty: $(this).val(), _token: $('input[name="_token"]').val() }
                 }).done(function( msg ) {
                     location.reload();
                 });
             });
         });
     </script>
@endpush
