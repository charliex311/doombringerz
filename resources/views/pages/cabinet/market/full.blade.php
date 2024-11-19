@extends('layouts.cabinet')

@section('title', $marketitem->name)

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
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top block-group">
                        <div class="nk-block-item">
                            <div class="nk-reply-header">
                                <div class="user-card flex-column align-items-start">
                                    <div class="user-name text-left">
                                        <div class="user-card">
                                            <div class="user-avatar sm bg-primary">
                                                @if(strpos($marketitem->icon, 'images') === FALSE)
                                                    <img src="{{ asset("images/items/{$marketitem->icon}.png") }}" alt="" title="{{ $marketitem->name }}">
                                                @else
                                                    <img src="{{ asset("/storage/{$marketitem->icon}") }}" alt="" title="{{ $marketitem->name }}">
                                                @endif
                                            </div>
                                            <div class="user-name"><span class="tb-lead">#{{ $marketitem->id }} {{ $marketitem->name }} {{ $marketitem->enchant > 0 ? "+{$marketitem->enchant}" : '' }}</span></div>
                                        </div>
                                        <div class="ml-3 text-gray">
                                            <div class="user-card">
                                                <div class="user-name"><span class="tb-lead">{{ __('Атрибуты') }}: <span class="tb-value">{{ 'Нет атрибутов' }}</span></span></div>
                                            </div>
                                        </div>
                                        <div class="ml-3 text-gray">
                                            <div class="user-card">
                                                <div class="user-name"><span class="tb-lead">{{ __('Цена') }}: <span class="tb-value">{{ $marketitem->price }} {{ config('options.server_'.session('server_id').'_coin_name', 'CoL') }}</span></span></div>
                                            </div>
                                        </div>
                                        <div class="ml-3 text-gray">
                                            <div class="user-card">
                                                <div class="user-name"><span class="tb-lead">{{ __('Вариант продажи') }}:
                                                        <span class="tb-value">
                                                            @if($marketitem->sale_type == 1)
                                                                {{ __('Продажа оптом') }}
                                                            @else
                                                                {{ __('Продажа в розницу') }}
                                                            @endif
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-3 text-gray">
                                            <div class="user-card">
                                                <div class="user-name"><span class="tb-lead">{{ __('Количество') }}: <span class="tb-value">{{ $marketitem->amount }}</span></span></div>
                                            </div>
                                        </div>

                                        @if($marketitem->user_id == auth()->id())
                                            <div class="row buy-block">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <a href="{{ route('market.cancel', $marketitem) }}" onClick="return Confirm('cancel');" class="btn w-100 btn-sm btn-primary justify-content-center">{{ __('Отменить лот') }}  <em class="icon ni ni-cross-circle ml-1 mr-1"></em></a>
                                                    </div>
                                                </div>
                                            </div>
                                        @else

                                        <form action="{{ route('market.buyout') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="marketitem_id" value="{{ $marketitem->id }}">

                                            <div class="row buy-block">
                                                <div class="col-12">

                                                    <div class="form-group">
                                                        <label class="form-label" for="quantity">{{ __('Укажите количество') }}</label>
                                                        <div class="form-control-wrap">
                                                            @if($marketitem->sale_type == 1)
                                                                <input type="number" class="form-control" data-price="{{ $marketitem->price }}" id="quantity" name="quantity" placeholder="{{ __('Количество') }}" value="{{ $marketitem->amount }}" readonly>
                                                            @else
                                                                <input type="number" min="1" max="{{ $marketitem->amount }}" data-price="{{ $marketitem->price }}" class="form-control" id="quantity" name="quantity" placeholder="{{ __('Количество') }}" value="1" required>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <button type="submit"
                                                                class="btn w-100 btn-sm btn-primary justify-content-center"
                                                                style="margin-top:-20px"
                                                                onClick="return Confirm('buy');"
                                                                @if (auth()->user()->balance < 1 ) disabled @endif>
                                                            {{ __('Купить за') }} <em class="icon ni ni-coins ml-1 mr-1"></em>
                                                            <span id="lot-total">
                                                                @if($marketitem->sale_type == 1)
                                                                    {{ $marketitem->price*$marketitem->amount }}
                                                                @else
                                                                    {{ $marketitem->price }}
                                                                @endif
                                                            </span>
                                                            {{ config('options.server_'.session('server_id').'_coin_name', 'CoL') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>

                                        @endif

                                    </div>

                                </div>

                            </div>
                            <div class="nk-reply-body">
                                <div class="nk-reply-entry entry">
                                    <p>{{ '' }}</p>
                                </div>
                            </div>
                        </div>


                        <div class="nk-block-item profile-block">
                            <div class="nk-reply-header">
                                <div class="user-card flex-column align-items-start">
                                    <div class="user-name text-left">{{ 'Профиль продавца' }}</div>
                                </div>
                                <div class="date-time">{{ '' }}</div>
                            </div>
                            <div class="nk-reply-body">
                                <div class="ml-3 text-gray">
                                    <div class="user-card">
                                        <div class="user-name"><span class="tb-lead">{{ __('Имя') }}: <span class="tb-value">{{ $user->name }}</span></span></div>
                                    </div>
                                    <div class="user-card">
                                        <div class="user-name"><span class="tb-lead">{{ __('Уровень') }}: <span class="tb-value">{{ $seller->trust_lvl }}</span></span></div>
                                    </div>
                                    <div class="user-card">
                                        <div class="user-name"><span class="tb-lead">{{ __('Регистрация') }}: <span class="tb-value">{{ $seller->created_at->format('d.m.Y') }}</span></span></div>
                                    </div>
                                </div>
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
        $(document).ready(function () {
            $('#quantity').on('change', function () {
                let total = $('#quantity').data('price') * $('#quantity').val();
                console.log(total);
                $('#lot-total').text(total);
            })
        });
    </script>
    <script>
        function Confirm(action) {
            let msg = "";
            if (action == 'buy') {
                msg = "{{ __('Вы уверены, что хотите купить?') }}";
            } else {
                msg = "{{ __('Вы уверены, что хотите отменить лот?') }}";
            }
            if (confirm(msg)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endpush
