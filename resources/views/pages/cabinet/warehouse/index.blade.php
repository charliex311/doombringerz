@extends('layouts.cabinet')

@section('title', __('Склад'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Склад') }}</span>
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-ulist is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Предмет') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Количество') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text"></span></div>
                            </div>
                            <!-- .nk-tb-item -->


                            @forelse($items as $item)

                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar sm bg-primary">
                                                @if(strpos($item->icon, 'images') === FALSE)
                                                    <img src="{{ asset("images/items/{$item->icon}.png") }}" alt="" title="{{ $item->name }}">
                                                @else
                                                    <img src="{{ asset("/storage/{$item->icon}") }}" alt="" title="{{ $item->name }}">
                                                @endif
                                            </div>
                                            <div class="user-name"> <span class="tb-lead">{{ $item->name }} {{ $item->enchant > 0 ? "+{$item->enchant}" : '' }}</span> </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"> <span>{{ $item->amount }} {{ __('шт.') }}</span> </div>
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <div class="drodown">
                                            <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="{{ route('warehouse.transfer', $item) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Отправить в игру') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('warehouse.auction', $item) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Выставить на аукцион') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col text-center">
                                        {{ __('Склад пуст') }}.
                                    </div>
                                    <div class="nk-tb-col">  </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
