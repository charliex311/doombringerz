@php
    if(isset($referral) && $referral->history !== NULL) {
        $histories = json_decode($referral->history);
    }
@endphp

@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Просмотр реферала'))
@section('headerDesc', __('Просмотр реферала') . ".")
@section('headerTitle', __('Реферал'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                        </div>


                        <div class="nk-tb-item">
                            <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        <a target="_blank">{{ $referral->code }}</a>
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $referral->note }}
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        @if ($referral->status == 1) <span class="green">{{ __('Активный') }}</span> @else <span class="red">{{ __('Не активный') }}</span> @endif
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $referral->total }} {{ config('options.server_0_coin_name', 'CoL') }}
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $referral->created_at->format('d.m.Y') }}
                                    </span>
                            </div>
                        </div>

                        <div class="card-inner">
                        <div class="card-head">
                            {{ __('История транзакций') }}
                        </div>

                        <div class="nk-tb-item">
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ __('Начислено') }}
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ __('Транзакция') }}
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ __('Сумма') }}
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ __('Количество') }} {{ config('options.server_0_coin_name', 'CoL') }}
                                    </span>
                            </div>
                            <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ __('Платежная система') }}
                                    </span>
                            </div>
                        </div>

                        @if (isset($histories))
                                @foreach($histories as $history)

                                <div class="nk-tb-item">
                                    <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $history->accrued }} {{ config('options.server_0_coin_name', 'CoL') }}
                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $history->transaction_id }}
                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $history->amount }}
                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $history->coins }} {{ config('options.server_0_coin_name', 'CoL') }}
                                    </span>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $history->payment_system }}
                                    </span>
                                    </div>
                                </div>

                                @endforeach
                        @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
