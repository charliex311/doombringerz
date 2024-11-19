@extends('layouts.cabinet')

@section('title', __('История моих продаж'))

@section('wrap')

    @include('partials.cabinet.market-statistics')

    <div class="nk-block">
        <div class="row g-gs">

            <div class="col-12">
                <div class="card card-bordered card-full">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-title">
                                <h6 class="title"><span class="mr-2">{{ __('История моих продаж') }}</span></h6>
                            </div>
                        </div>
                    </div>

                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Лот') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Ранг') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Атрибут') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Цена') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Количество') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Дата продажи') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Покупатель') }}</span></div>
                            </div>
                            @forelse($marketsolds as $marketsold)
                                <div class="nk-tb-item account fade show have-chars">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar sm bg-primary">
                                                @if(strpos($marketsold->icon, 'images') === FALSE)
                                                    <img src="{{ asset("images/items/{$marketsold->icon}.png") }}" alt="" title="{{ $marketsold->name }}">
                                                @else
                                                    <img src="{{ asset("/storage/{$marketsold->icon}") }}" alt="" title="{{ $marketsold->name }}">
                                                @endif
                                            </div>
                                            <div class="user-name"> <span class="tb-lead">#{{ $marketsold->id }}  {{ $marketsold->name }} {{ $marketsold->enchant > 0 ? "+{$marketsold->enchant}" : '' }}</span> </div>
                                        </div>
                                    </div>

                                    <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketsold->enchant }}
                                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ '-' }}
                                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketsold->price }}
                                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketsold->amount }}
                                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketsold->created_at->format('d.m.Y') }}
                                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ getuser($marketsold->buyer_id)->name }}
                                                    </span>
                                    </div>

                                </div>
                            @empty
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col text-center">
                                        {{ __('У вас еще нет истории продаж') }}.
                                    </div>
                                </div>
                            @endforelse

                            <div class="card-inner">
                                {{ $marketsolds->links('layouts.pagination.cabinet') }}
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    @include('partials.cabinet.market-info')


@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#quantity').on('change', function () {
                let total = $('#quantity').data('price');
                console.log(total);
                $('#lot-total').val(total);
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
