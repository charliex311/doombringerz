@extends('layouts.cabinet')

@section('title', __('Голосование за сервер'))

@section('wrap')

    <link rel="stylesheet" href="/css/css-update.css?ver=1.11"/>

                {{-- Alert --}}
                @foreach (['danger', 'warning', 'success', 'info'] as $type)
                    @if(Session::has('alert.' . $type))
                        @foreach(Session::get('alert.' . $type) as $message)
                            <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon">
                                @if ($type === 'danger')
                                    <em class="icon ni ni-cross-circle"></em>
                                @elseif($type === 'success')
                                    <em class="icon ni ni-check-circle"></em>
                                @else
                                    <em class="icon ni ni-alert-circle"></em>
                                @endif
                                {{ $message }}
                                <button class="close" data-dismiss="alert"></button>
                            </div>
                        @endforeach
                    @endif
                @endforeach
                @php
                    session()->forget(['alert.danger', 'alert.warning', 'alert.success', 'alert.info']);
                @endphp
                {{-- End Alert --}}


                <div class="nk-block">
                    <div class="row g-gs">
                        <div class="col-lg-12">
                            <div class="card card-bordered">
                                <div class="card-inner mb-4">
                                    <div class="card-title-group">
                                        <h5 class="card-title">
                                            <span class="mr-2">{{ __('Голосование за сервер') }}</span>
                                        </h5>
                                    </div>
                                </div>
                                <div class="card-inner">
                                    <div class="card-title-group">
                                        <span class="mr-2 mb-4" style="font-size: 13px;color: red;">{{ __('Проверка голосов происходит раз в 10 минут. Бонусные предметы добавляются на') }} <a href="{{ route("warehouse.index") }}" style="color: #f09b28">{{ __('склад в ЛК') }}</a></span>
                                    </div>
                                </div>
                                <div class="card-inner p-0 border-top">
                                    <div class="nk-tb-list nk-tb-ulist is-compact">
                                        <div class="nk-tb-item nk-tb-head">
                                            <div class="nk-tb-col"><span class="sub-text" style="margin-left: 15px;">{{ __('Площадка') }}</span></div>
                                            <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                                            <div class="nk-tb-col"><span class="sub-text"></span>{{ __('Награда') }}</div>
                                            <div class="nk-tb-col" style="text-align: center;"><span class="sub-text"></span>{{ __('До повторного голосования') }}</div>
                                            <div class="nk-tb-col"><span class="sub-text"></span></div>
                                        </div>
                                        <!-- .nk-tb-item -->
                                        @php
                                            $voting_count = 0;
                                        @endphp
                                        @forelse($votings as $voting)
                                            @php
                                                if ($voting->status == 2) {
                                                    $voting_count++;
                                                }
                                            @endphp
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col">
                                                    <div class="user-card">
                                                        <div class="voting-img">
                                                            <img src="{{ $voting->image }}" alt="" title="{{ $voting->name }}">
                                                        </div>
                                                        <div class="voting-name"><span class="tb-lead">{{ $voting->title }}</span></div>
                                                    </div>
                                                </div>
                                                <div class="nk-tb-col">
                                                    @if($voting->status == 0)
                                                        <span>{{ __('Не проголосовано') }}</span>
                                                    @elseif($voting->status == 1)
                                                        <span style="color: red;">{{ __('Не засчитано') }}</span>
                                                    @elseif($voting->status == 2)
                                                        <span style="color: #0acf0a;">{{ __('Засчитано') }}</span>
                                                    @endif
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>
                                                        @if($voting->status == 2)
                                                            <img src="/images/shop/{{ $bonus_item->icon0 }}.png" alt="" title="{{ $bonus_item->name }}" style="width: 32px;height: 32px;">
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="nk-tb-col" style="text-align: center;">
                                                    <span>
                                                        {{ downcounter($voting->updated_at) }}
                                                    </span>
                                                </div>
                                                <div class="nk-tb-col">
                                                    <span>
                                                        @if(downcounter($voting->updated_at) == '-')
                                                            <a href="{{ route('voting.redirect', $voting->name) }}" target="_blank">{{ __('Голосовать') }}</a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col text-center">
                                                    {{ __('Нет площадок для голосования') }}.
                                                </div>
                                                <div class="nk-tb-col">  </div>
                                            </div>
                                        @endforelse


                                            <div class="nk-tb-item">
                                                <div class="nk-tb-col text-left">
                                                    <span>{{ __('Награда за голосование на всех площадках:') }} </span>
                                                    @if($voting_count >= count($votings))
                                                        @if($bonus_final_item)
                                                            <span style="color: #0acf0a;"><span style="margin-right: 5px;margin-left: 5px;"></span>
                                                            <img src="/images/items/{{ $bonus_final_item->icon0 }}.png" alt="" title="{{ $bonus_final_item->name }}">
                                                            <span style="margin-right: 5px;margin-left: 5px;">{{ $bonus_final_item->name }}</span>@endif</span>
                                                    @else
                                                        <span style="color: red;">{{ __('Не получена') }}</span>
                                                    @endif
                                                </div>
                                                <div class="nk-tb-col"></div>
                                            </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

    <script>
        $( document ).ready(function(event) {

        });
    </script>
@endsection
