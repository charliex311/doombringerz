@extends('layouts.cabinet')

@section('title', __('Торговая площадка'))

@section('wrap')


    @include('partials.cabinet.market-infomsg')

    @include('partials.cabinet.market-statistics')

    @include('partials.cabinet.account-metrics')

        <div class="nk-block">
            <div class="row g-gs">

                @include('partials.cabinet.market-categories')

                <div class="col-8">
                    <div class="card card-bordered card-full">
                        <div class="card-inner">
                            <div class="card-title-group">
                                <div class="card-title">
                                    <h6 class="title"><span class="mr-2">{{ $cat_title }}</span></h6>
                                </div>
                                    <div class="card-tools d-none d-md-inline">
                                        <form method="GET">
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-left">
                                                    <em class="icon ni ni-search"></em>
                                                </div>
                                                <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Поиск') }}...">
                                            </div>
                                        </form>
                                    </div>
                            </div>
                        </div>


                                            <div class="card-inner p-0 border-top">
                                                <div class="nk-tb-list nk-tb-orders">
                                                    <div class="nk-tb-item nk-tb-head">
                                                        <div class="nk-tb-col"><span class="sub-text">{{ __('Лот') }}</span></div>
                                                        <div class="nk-tb-col"><span class="sub-text">{{ __('Ранг') }}</span></div>
                                                        <div class="nk-tb-col"><span class="sub-text">{{ __('Атрибут') }}</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('В наличии') }}</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Цена') }}</span></div>
                                                        <div class="nk-tb-col tb-col-md"><span class="sub-text"></span></div>
                                                    </div>
                                                    @forelse($marketitems as $marketitem)
                                                        <div class="nk-tb-item account fade show have-chars">
                                                            <div class="nk-tb-col">
                                                                <div class="user-card">
                                                                    <div class="user-avatar sm bg-primary">
                                                                        @if(strpos($marketitem->icon, 'images') === FALSE)
                                                                            <img src="{{ asset("images/items/{$marketitem->icon}.png") }}" alt="" title="{{ $marketitem->name }}">
                                                                        @else
                                                                            <img src="{{ asset("/storage/{$marketitem->icon}") }}" alt="" title="{{ $marketitem->name }}">
                                                                        @endif
                                                                    </div>
                                                                    <div class="user-name"> <span class="tb-lead">#{{ $marketitem->id }}  {{ $marketitem->name }} {{ $marketitem->enchant > 0 ? "+{$marketitem->enchant}" : '' }}</span> </div>
                                                                </div>
                                                            </div>

                                                            <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketitem->enchant }}
                                                    </span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ '-' }}
                                                    </span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketitem->amount }}
                                                    </span>
                                                            </div>
                                                            <div class="nk-tb-col tb-col-md">
                                                    <span class="tb-sub">
                                                        {{ $marketitem->price }}
                                                    </span>
                                                            </div>

                                                            <div class="nk-tb-col nk-tb-col-action">
                                                                <div class="dropdown">
                                                                    <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                                        <em class="icon ni ni-more-h"></em>
                                                                    </a>
                                                                    <div class="dropdown-menu dropdown-menu-right">
                                                                        <ul class="link-list-plain">
                                                                            @if($marketitem->user_id == auth()->id())
                                                                                <li><a href="{{ route('market.cancel', $marketitem) }}">{{ __('Отменить') }}</a></li>
                                                                            @else
                                                                                <li><a href="{{ route('market.show', $marketitem) }}">{{ __('Купить') }}</a></li>
                                                                            @endif
                                                                                <li><a href="{{ route('market.show', $marketitem) }}">{{ __('Подробнее') }}</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="nk-tb-item">
                                                            <div class="nk-tb-col text-center">
                                                                {{ __('Нет товаров в продаже') }}.
                                                            </div>
                                                        </div>
                                                    @endforelse

                                                    <div class="card-inner">
                                                        {{ $marketitems->links('layouts.pagination.cabinet') }}
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
                    //
                });
            </script>
    @endpush
