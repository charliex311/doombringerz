@php
    $title = "title_" .app()->getLocale();
    $description = "description_" .app()->getLocale();
@endphp

<sidebar class="basket">
    <div class="basket-inner">
        <div class="basket-main">
            @if(empty($cart['cart']))
                <div class="basket-purchased">
                    <div class="basket-header">
                    <span class="basket-header__text">
                        {{ __('Моя корзина') }}
                    </span>
                        <div class="basket-header__value">
                            {{ count($cart['cart']) }} {{ __('предметов') }}
                        </div>
                    </div>

                    <div class="basket-purchased__item empty-cart-block">
                        <div class="empty-cart">
                            <p class="title">{{ __('Ваша корзина пуста') }}</p>
                            <p class="text">{{ __('Добавьте товары в магазин, чтобы') }}<br/>{{ __('оформить заказ') }}</p>
                        </div>
                    </div>
                </div>
            @else

                <div class="basket-purchased">

                <div class="basket-header">
                    <span class="basket-header__text">
                        {{ __('Моя корзина') }}
                    </span>
                    <div class="basket-header__value">
                        {{ count($cart['cart']) }} {{ __('предметов') }}
                    </div>
                </div>

                    @foreach($cart['cart'] as $cart_item)

                        <div class="basket-purchased__item">
                            <div class="basket-purchased__image">
                                <img src="{{ get_image_url($cart_item['image']) }}" alt="{{ strip_tags($cart_item['title']) }}">
                            </div>
                            <div class="basket-purchased__info">
                                <div class="basket-purchased__description">
                                    {{ Str::limit(strip_tags($cart_item['description']), 60) }}
                                </div>
                                <div class="basket-purchased__price">
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
                                    <div class="basket-purchased__price-text">
                                        {{ $cart_item['price'] }} {{ config('options.server_0_coin_short_name', 'CoL') }}
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
                        </div>
                    @endforeach


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

                        <a href="{{ route('shop.cart.checkout') }}" type="submit"
                           class="basket-checkout btn" id="pay-submit">
                            <span>{{ __('Оформить заказ') }}</span>
                        </a>
                    </div>

                </div>


                <div class="basket-purchased">
                    <div class="basket-header">
                        <span class="basket-header__text">
                            {{ __('Вместе с этим часто покупают') }}
                        </span>
                    </div>

                    @foreach($cart['togethers'] as $together)
                        <div class="basket-purchased__item">
                            <div class="basket-purchased__image">
                                <img src="{{ $together->image_url }}" alt="{{ strip_tags($together->$title) }}">
                            </div>
                            <div class="basket-purchased__info">
                                <div class="basket-purchased__description">
                                    {{ Str::limit(strip_tags($together->$description), 60) }}
                                </div>
                                <div class="basket-purchased__price @if($together->sale > 0) block--discount @endif">
                                    <div class="basket-purchased__price-icon">
                                        <svg width="32" height="32" viewBox="0 0 32 32" fill="" xmlns="http://www.w3.org/2000/svg">
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

                                    @if($together->sale > 0)
                                        <div class="basket-purchased__price-text">
                                            {{ $together->sale }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                        </div>
                                        <div class="block-price__previous">
                                            {{ $together->price }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                        </div>
                                    @else
                                        <div class="basket-purchased__price-text">
                                            {{ $together->price }} {{ config('options.server_0_coin_short_name', 'CoL') }}
                                        </div>
                                    @endif
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

                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif
    </div>
</sidebar>


{{--
<div class="inner-shop-right">

    <!--cart-->
    <div class="my-cart">
        <span><img src="/images/shop/cart2-icon.png">{{ __('Моя корзина') }}</span><span class="purple">({{ $cart['total']['total'] }})</span>
    </div>

    <!--item on cart-->
    <div class="inner-item-cart-group">
        @if(empty($cart['cart']))
            <div class="empty-cart">
                <p1>{{ __('Ваша корзина пуста') }}</p1>
                <p>{{ __('Добавьте товары в магазин, чтобы') }}<br/>{{ __('оформить заказ') }}</p>
            </div>
        @else

            @foreach($cart['cart'] as $cart_item)
                <div class="item-cart">
                    <img src="/storage/{{ $cart_item['image'] }}">
                    <div class="cart-item-detail">
                        <p>{{ str_replace('<br>', '', $cart_item['title']) }}</p>
                        <div class="cart-item-price">
                            <span class="orange">{{ __('Цена') }}: </span> <span> {{ $cart_item['price'] }} <img src="/images/shop/tc-icon.png"></span>
                        </div>
                        <div class="quantity">
                            <input class="item-qty" type="number" name="item_qty" data-itemid="{{ $cart_item['id'] }}" min="1" max="1000" step="1" value="{{ $cart_item['qty'] }}">
                        </div>
                    </div>
                    <div class="remove-item">
                        <form action="{{ route('shop.cart.delete') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $cart_item['id'] }}">
                            <button><img src="/images/shop/x-icon.png"></button>
                        </form>
                    </div>
                </div>
            @endforeach

                <div class="togethers-list">
                    <span>{{ __('Вместе с этим часто покупают') }}:</span>
                </div>

                @foreach($cart['togethers'] as $together)
                    <div class="item-cart">
                        <img src="{{ $together->image_url }}">
                        <div class="cart-item-detail">
                            <p>{{ strip_tags($together->$title) }}</p>
                            <div class="cart-item-price">
                                <span class="orange">{{ __('Цена') }}: </span> <span> {{ $together->price }} <img src="/images/shop/tc-icon.png"></span>
                            </div>

                        </div>
                        <div class="addcart-item">
                            <form action="{{ route('shop.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $together->id }}">
                                <input type="hidden" name="server_id" value="1">
                                <button type="submit" class="btn-additem"><img src="/images/shop/cart2-icon.png"></button>
                            </form>
                        </div>
                    </div>
                @endforeach

        @endif
    </div>

    <!--checkout-->
    <div class="inner-shop-total-checkout">
        <span>{{ __('Всего') }}:</span><span class="glow">{{ $cart['total']['amount'] }} <img src="/images/shop/tc-icon.png"/></span>
        <div class="shop-checkout">
            @if(empty($cart['cart']))
                <div class="form-group" style="margin-top: 50px;">
                    <a type="submit" class="home__play checkout-off" id="pay-submit">
                        <span>{{ __('Оформить заказ') }}</span>
                    </a>
                </div>
            @else
                <div class="form-group" style="margin-top: 50px;">
                    <a href="{{ route('shop.cart.checkout') }}" type="submit" class="home__play" id="pay-submit">
                        <span>{{ __('Оформить заказ') }}</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
--}}


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
    </script>
@endpush
