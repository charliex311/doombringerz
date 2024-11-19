@extends('layouts.cabinet-shop')

@php
    $title = "title_" .app()->getLocale();
    $description = "description_" .app()->getLocale();
    $description_add = "description_add_" .app()->getLocale();
@endphp

@section('title', __('Оформление заказа'))

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
                                    <div class="main checkout">
                                        <div class="basket-header checkout-header">
                                            <a href="{{ route('shop') }}" class="card-return"><img src="/img/arrow-icon.svg" alt="arrow-icon"><span class="card-return__text">Go back</span></a>
                                            <span class="basket-header__text checkout-header__text">
                                                {{ count($cart['cart']) }} {{ __('предметов') }}
                                            </span>
                                        </div>

                                        @foreach($cart['cart'] as $cart_item)
                                            <div class="basket-purchased__item basket-purchased__item--cols-3">
                                                <div class="basket-purchased__image">
                                                    <img src="{{ get_image_url($cart_item['image']) }}" alt="purchased-image">
                                                </div>
                                                <div class="basket-purchased__info">
                                                    <div class="basket-purchased__description">
                                                        {{ Str::limit(strip_tags($cart_item['description']), 60) }}
                                                    </div>
                                                    <div class="basket-purchased__price @if($cart_item['sale'] > 0) block--discount @endif">
                                                        <div class="basket-purchased__price-icon">
                                                            <svg viewBox="0 0 32 32"  xmlns="http://www.w3.org/2000/svg">
                                                                <g clip-path="url(#clip0_601_1328)">
                                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M16 6C10.477 6 6 10.477 6 16C6 21.523 10.477 26 16 26C21.523 26 26 21.523 26 16C26 10.477 21.523 6 16 6ZM16 7C16 9.38695 15.0518 11.6761 13.364 13.364C11.6761 15.0518 9.38695 16 7 16C9.38695 16 11.6761 16.9482 13.364 18.636C15.0518 20.3239 16 22.6131 16 25C16 22.6131 16.9482 20.3239 18.636 18.636C20.3239 16.9482 22.6131 16 25 16C22.6131 16 20.3239 15.0518 18.636 13.364C16.9482 11.6761 16 9.38695 16 7Z" fill=""/>
                                                                </g>
                                                                <defs>
                                                                    <clipPath id="clip0_601_1328">
                                                                        <rect fill=""/>
                                                                    </clipPath>
                                                                </defs>
                                                            </svg>
                                                        </div>

                                                        @if($cart_item['sale'] > 0)
                                                            <div class="basket-purchased__price-text">
                                                                {{ $cart_item['sale'] }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                            </div>
                                                            <div class="block-price__previous">
                                                                {{ $cart_item['price'] }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                            </div>
                                                        @else
                                                            <div class="basket-purchased__price-text">
                                                                {{ $cart_item['price'] }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="basket-options">
                                                    <div class="basket-counter">
                                                        <div class="basket-counter__change qty-minus" data-itemid="{{ $cart_item['id'] }}">
                                                            <span></span>
                                                        </div>
                                                        <input type="hidden" id="item_qty_{{ $cart_item['id'] }}" name="item_qty" min="1" max="1000" step="1" value="{{ $cart_item['qty'] }}">
                                                        <div class="basket-counter__value item_qty_text_{{ $cart_item['id'] }}">
                                                            {{ $cart_item['qty'] }}
                                                        </div>
                                                        <div class="basket-counter__change qty-plus" data-itemid="{{ $cart_item['id'] }}">
                                                            <span></span>
                                                            <span></span>
                                                        </div>
                                                    </div>

                                                    <form action="{{ route('shop.cart.delete') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="item_id" value="{{ $cart_item['id'] }}">
                                                        <button class="basket-delete">
                                                            <img src="/img/delete-icon.svg" alt="delete-icon">
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>


                                <aside class="basket">
                                    <div class="basket-inner">
                                        <div class="basket-main">
                                            <div class="basket-purchased">
                                                <div class="basket-header">
                                                    <span class="basket-header__text">
                                                        {{ __('Информация заказа') }}
                                                    </span>
                                                </div>
                                                <div class="basket-bill">
                                                    <div class="basket-bill__row">
                                                        <span class="basket-bill__head">
                                                            {{ __('Итого') }}
                                                        </span>
                                                        <div class="basket-bill__amount">
                                                            {{ $cart['total']['subtotal'] }}
                                                        </div>
                                                    </div>
                                                    <div class="basket-bill__row">
                                                        <span class="basket-bill__head">
                                                            {{ __('Скидка') }}
                                                        </span>
                                                        <div class="basket-bill__amount basket-bill__amount--discount">
                                                            {{ $cart['total']['discount'] }}
                                                        </div>
                                                    </div>
                                                    <div class="basket-bill__row">
                                                        <div class="basket-bill__head basket-bill__head--white">
                                                            {{ __('Всего') }}
                                                        </div>
                                                        <div class="basket-bill__amount basket-bill__amount--white">
                                                            {{ $cart['total']['amount'] }}
                                                        </div>
                                                    </div>

                                                        <div class="basket-actions">

                                                            @if($cart['total']['coupon'])

                                                                <form action="{{ route('shop.coupon.remove') }}" method="POST">
                                                                    @csrf

                                                                    <div class="basket-actions__input">
                                                                        <input type="text" name="coupon_code" value="{{ $cart['total']['coupon'] }}" placeholder="{{ __('Введите купон') }}">
                                                                    </div>
                                                                    <button class="basket-actions__apply red">
                                                                        {{ __('Удалить') }}
                                                                    </button>
                                                                </form>

                                                            @else
                                                                <form action="{{ route('shop.coupon.apply') }}" method="POST">
                                                                    @csrf
                                                                    <div class="basket-actions__input">
                                                                    <input type="text" name="coupon_code" value="" placeholder="{{ __('Введите купон') }}">
                                                                </div>
                                                                    <button class="basket-actions__apply">
                                                                        {{ __('Применить') }}
                                                                    </button>
                                                                </form>
                                                            @endif

                                                                <div class="panel-dropdown">
                                                                        <select name="character_id" id="character_id" class="form-control selectpicker" style="width: 100%">
                                                                            @if(get_game_characters()->count() < 1)
                                                                                <option value="0" selected>{{ __('Нет персонажей') }}</option>
                                                                            @else
                                                                                @foreach(get_game_characters() as $character)
                                                                                    @if($loop->iteration == 1)
                                                                                        <option value="{{ $character->guid }}">{{ $character->name }}</option>
                                                                                    @else
                                                                                        <option value="{{ $character->guid }}">{{ $character->name }}</option>
                                                                                    @endif
                                                                                @endforeach
                                                                            @endempty
                                                                        </select>
                                                                </div>

                                                        </div>

                                                    @foreach (['danger', 'warning', 'success', 'info'] as $type)
                                                        @if(Session::has('alert.' . $type))
                                                            @foreach(Session::get('alert.' . $type) as $message)
                                                                <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon">
                                                                    <span>{{ $message }}</span>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    @endforeach

                                                    <form action="{{ route('shop.cart.complete') }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="basket-checkout btn" onclick="ConfirmComplete();">
                                                            <span>{{ __('Подтвердить заказ') }}</span>
                                                        </button>
                                                    </form>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>

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
                                            <!--navigation basket cart-->
                                            <div class="inner-basket-navigation-cart">
                                                <div class="inner-basket-navigation">
                                                    <button><a href="{{ url()->previous() }}"><img src="//img/shop/back-icon.png"/>{{ __('Назад') }}</a></button>
                                                    <a href="{{ route('shop') }}">{{ __('Магазин') }}</a>
                                                    <span><img src="//img/shop/arrow-right.png"></span>
                                                    <a class="active">{{ __('Оформление заказа') }}</a>
                                                </div>
                                                <div class="inner-basket-cart">
                                                    <span><img src="//img/shop/cart2-icon.png">{{ __('Магазин') }}</span><span class="purple">({{ $cart['total']['total'] }})</span>
                                                </div>
                                            </div>
                                            <!--end navigation-->

                                            <!--basket item group-->
                                            <div class="basket-list-group">

                                            @foreach($cart['cart'] as $cart_item)
                                                <!--item-->
                                                    <div class="basket-item" style="background: url('/storage/{{ $cart_item['image'] }}') top / cover no-repeat;">
                                                        <div class="basket-item-details">
                                                            <div class="basket-item-name">
                                                                <p>{{ str_replace('<br>', '', $cart_item['title']) }}</p>
                                                                <p class="yellow">{{ getserver($cart_item['server_id'])->name }}</p>
                                                            </div>
                                                            <div class="basket-item-icon">
                                                                <img src="/storage/{{ $cart_item['image'] }}">
                                                            </div>
                                                        </div>
                                                        <div class="basket-item-quantity-value">
                                                            <div class="basket-item-value">
                                                                <span><img src="//img/shop/tc-icon.png"/>{{ $cart_item['price'] }}</span>
                                                            </div>
                                                            <div class="basket-item-quantity">
                                                                <div class="quantity quantity2">
                                                                    <input class="item-qty" type="number" name="item_qty" data-itemid="{{ $cart_item['id'] }}" min="1" max="1000" step="1" value="{{ $cart_item['qty'] }}">
                                                                </div>
                                                                <div class="basket-remove-item">
                                                                    <form action="{{ route('shop.cart.delete') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="item_id" value="{{ $cart_item['id'] }}">
                                                                        <button><img src="//img/shop/x-icon.png"></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end item-->
                                                @endforeach
                                            </div>
                                            <!--end basket item group-->

                                        </div>
                                    </div>

                                    <!--basket right side-->
                                    <div class="inner-shop-right">
                                        <!--details-->
                                        <div class="order-wrapper"> <!--move the content on "inner-shop-right" inside to this div-->
                                            <p>{{ __('Информация заказа') }}</p>
                                            <div class="basket-order-details">
                                                <div>
                                                    <p>{{ __('Итого') }}</p>
                                                    <p>{{ $cart['total']['subtotal'] }}</p>
                                                </div>
                                                <div>
                                                    <p>{{ __('Скидка') }} (-)</p>
                                                    <p>{{ $cart['total']['discount'] }}</p>
                                                </div>
                                                <div>
                                                    <p class="total">{{ __('Всего') }}</p>
                                                    <p class="total"><img src="//img/shop/tot-icon.png"/> {{ $cart['total']['amount'] }}</p>
                                                </div>
                                            </div>

                                            <!--inputs-->
                                            @if($cart['total']['coupon'])

                                                <div class="basket-input-coupon">
                                                    <div class="coupon-applied">
                                                        <form action="{{ route('shop.coupon.remove') }}" method="POST">
                                                            @csrf
                                                            <button class="red">{{ __('Убрать') }}</button>
                                                        </form>
                                                        <div class="basket-input-coupon-applied">
                                                            <span><strong>{{ $cart['total']['coupon'] }}</strong>&nbsp {{ __('применено') }}</span>
                                                            <span><img src="//img/shop/tc-icon.png">-{{ $cart['total']['discount'] }} ({{ session()->get('coupon_discount') }} OFF)</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            @else

                                                <div class="basket-input-coupon">
                                                    <form action="{{ route('shop.coupon.apply') }}" method="POST">
                                                        @csrf
                                                        <input type="text" id="coupon_code" name="coupon_code"
                                                               value="" placeholder="{{ __('Введите купон') }}">
                                                        <button>{{ __('Применить') }}</button>
                                                    </form>
                                                </div>

                                            @endif

                                            @foreach (['danger', 'warning', 'success', 'info'] as $type)
                                                @if(Session::has('alert.' . $type))
                                                    @foreach(Session::get('alert.' . $type) as $message)
                                                        <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon" style="margin: 0 auto;margin-bottom: 22px;width: 68%;padding: 10px;">
                                                            <span>{{ $message }}</span>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            @endforeach

                                            <div class="basket-input-character">
                                                <select>
                                                    @if(get_game_characters()->count() < 1)
                                                        <option value="0" selected>{{ __('Нет персонажей') }}</option>
                                                    @else
                                                        @foreach(get_game_characters() as $character)
                                                            @if($loop->iteration == 1)
                                                                <option value="{{ $character->guid }}">{{ $character->name }}</option>
                                                            @else
                                                                <option value="{{ $character->guid }}">{{ $character->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    @endempty

                                                </select>
                                            </div>

                                            <!--end inputs-->
                                            <!--checkout-->
                                            <!--checkout-->
                                            <div class="inner-shop-total-checkout">
                                                <div class="shop-checkout">
                                                    <form action="{{ route('shop.cart.complete') }}" method="POST">
                                                        @csrf
                                                        <div class="form-group" style="margin-top: 50px;">
                                                            <a type="submit" class="home__play" onclick="ConfirmComplete();">
                                                                <span>{{ __('Подтвердить заказ') }}</span>
                                                            </a>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end basket right side-->

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
            $(".qty-minus").click(function() {
                let itemid = $(this).data('itemid');
                let qty = parseInt($('#item_qty_'+itemid).val()) - 1;
                if (qty < 1) {
                    return false;
                }
                $('#item_qty_'+itemid).val(qty);
                $('.item_qty_text_'+itemid).text(qty);
                $.ajax({
                    type: "POST",
                    url: "{{ route('shop.cart.update') }}",
                    data: { item_id: $(this).data('itemid'), item_qty: qty, _token: $('input[name="_token"]').val() }
                }).done(function( msg ) {
                    location.reload();
                });
            });
            $(".qty-plus").click(function() {
                let itemid = $(this).data('itemid');
                let qty = parseInt($('#item_qty_'+itemid).val()) + 1;
                $('#item_qty_'+itemid).val(qty);
                $('.item_qty_text_'+itemid).text(qty);
                $.ajax({
                    type: "POST",
                    url: "{{ route('shop.cart.update') }}",
                    data: { item_id: $(this).data('itemid'), item_qty: qty, _token: $('input[name="_token"]').val() }
                }).done(function( msg ) {
                    location.reload();
                });
            });
        });

        function ConfirmComplete() {
            if (confirm("{{ __('Вы уверены, что хотите оформить заказ?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endpush
