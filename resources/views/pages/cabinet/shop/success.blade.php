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
                                            <a href="{{ route('shop') }}" class="card-return"><img src="/img/arrow-icon.svg" alt="arrow-icon"><span class="card-return__text">{{ __('Вернуться') }}</span></a>
                                            <span class="basket-header__text checkout-header__text">
                                                {{ count($cart['cart']) }} {{ __('предметов') }}
                                            </span>
                                        </div>

                                        <div class="basket-list-group">

                                            @if(Session::has('alert.success'))
                                                @foreach(Session::get('alert.success') as $message)
                                                    <div class="inner-middle-big">
                                                        <div class="checkout-success">
                                                            <p>{{ __('Заказ успешно оформлен!') }}</p>
                                                            <a href="{{ route('shop') }}" class="card-return"><img src="/img/arrow-icon.svg" alt="arrow-icon"><span class="card-return__text">{{ __('Вернуться') }}</span></a>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="inner-middle-big">
                                                    <div class="checkout-error">
                                                        <p>{{ __('Произошла ошибка!') }}</p>
                                                        <a href="{{ route('shop') }}" class="card-return"><img src="/img/arrow-icon.svg" alt="arrow-icon"><span class="card-return__text">{{ __('Вернуться') }}</span></a>
                                                    </div>
                                                </div>
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
    <script>
        function ConfirmComplete() {
            if (confirm("{{ __('Вы уверены, что хотите оформить заказ?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endpush
