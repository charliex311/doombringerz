@extends('layouts.cabinet')

@section('title', __('Аукцион'))

@section('wrap')
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">@yield('title')</h3>
            </div>
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <div class="toggle-expand-content" data-content="pageMenu">
                        <ul class="nk-block-tools g-3">
                            <li>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-white btn-dim btn-outline-light" data-toggle="dropdown">
                                        <em class="d-none d-sm-inline icon ni ni-filter-alt"></em>
                                        <span>{{ __('Фильтр') }}{{ request()->has('class') ? (': ' . __(request()->query('class'))) : '' }}</span>
                                        <em class="dd-indc icon ni ni-chevron-right"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="{{ route('auction.index') }}"><span>{{ __('Все') }}</span></a></li>
                                            <li><a href="{{ route('auction.index', ['class' => 'weapon']) }}"><span>{{ __('Оружие') }}</span></a></li>
                                            <li><a href="{{ route('auction.index', ['class' => 'armor']) }}"><span>{{ __('Броня') }}</span></a></li>
                                            <li><a href="{{ route('auction.index', ['class' => 'accessary']) }}"><span>{{ __('Аксессуары') }}</span></a></li>
                                            <li><a href="{{ route('auction.index', ['class' => 'etc']) }}"><span>{{ __('Разное') }}</span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row g-gs">
            @forelse($lots as $lot)
                <div class="col-sm-6 col-xl-4">
                    <div class="card card-bordered h-100">
                        <div class="card-inner">
                            <div class="project">
                                <div class="project-head">
                                    <div class="project-title">
                                        <div class="user-avatar sq bg-primary">
                                            <img src="{{ asset("images/items/{$lot->icon}.png") }}" alt="" title="{{ $lot->name }}">
                                        </div>
                                        <div class="project-info">
                                            <h6 class="title" style="{{ $lot->augmentation1 || $lot->augmentation2 ? 'color: #C06ACD;' : '' }}font-size: .675rem;">
                                                {{ $lot->name }}{{ $lot->augmentation1 || $lot->augmentation2 ? '-[LS]' : '' }}
                                                {!! $lot->add_name ? "<span style='color: yellow'>{$lot->add_name}</span>" : '' !!}
                                                {{ $lot->enchant > 0 ? "+{$lot->enchant}" : '' }} ({{ $lot->amount }} шт.)
                                            @if ($lot->augmentation0 || $lot->augmentation1 || $lot->augmentation2)
                                                <em class="icon ni ni-info text-gray p-1" style="vertical-align: middle;font-size: 15px;"
                                                    data-toggle="tooltip" data-placement="right" data-html="true"
                                                    title="Augmentation Effects:<br><span style='color: #C06ACD'>{!! $lot->augmentation1 ? str_replace('\n', '<br>', $lot->augmentation1->name) : '' !!}<br>{!! $lot->augmentation2 ? str_replace('\n', '<br>', $lot->augmentation2->name) : '' !!}</span>"></em>
                                            @endif
                                            </h6>
                                        </div>
                                    </div>
                                    @if($lot->user_id === auth()->id())
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger mt-n1 mr-n1"
                                               data-toggle="dropdown" aria-expanded="false">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="{{ route('auction.cancel', $lot) }}">
                                                            <em class="icon ni ni-cross-circle"></em>
                                                            <span>{{ __('Отменить лот') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="project-details">
                                    <p class="m-0">{{ __('Текущая ставка') }}: <span class="fw-bold text-primary">{{ $lot->current_bet ?? $lot->start_price }} <em class="icon ni ni-coins"></em></span></p>
                                    <p class="m-0">{{ __('Завершится') }} <span class="fw-bold text-primary">{{ $lot->end_at->diffForHumans() }}</span></p>
                                </div>
                                <div class="project-progress">
                                    <div class="project-progress-details">
                                        <div class="project-progress-task"><em class="icon ni ni-check-round-cut"></em><span>{{ $lot->count }} {{ plural_form($lot->count, [__('ставка'), __('ставки'), __('ставок')]) }}</span></div>
                                        <div class="project-progress-percent">{{ __('Блиц') }}: <span class="fw-bold text-primary">{{ $lot->buyout_price }} <em class="icon ni ni-coins"></em></span></div>
                                    </div>
                                    <div class="progress progress-pill progress-md bg-light">
                                        <div class="progress-bar" data-progress="{{ round((100 / $lot->buyout_price) * ($lot->current_bet ?? $lot->start_price)) }}"
                                             style="width: {{ round((100 / $lot->buyout_price) * ($lot->current_bet ?? $lot->start_price)) }}%;"></div>
                                    </div>
                                </div>

                                @if($lot->user_id !== auth()->id())
                                    <div class="project-meta">
                                        <form action="{{ route('auction.bet', $lot) }}" method="POST">
                                            @csrf
                                            <div class="row g-gs">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="amount" name="amount" value="{{ ($lot->current_bet ?? $lot->start_price) + 1 }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 p-0">
                                                    <div class="form-group">
                                                        <button type="submit" class="btn w-100 btn-lg btn-primary justify-content-center" style="margin-top:-20px">
                                                            {{ __('Сделать ставку') }}
                                                        </button>
                                                        <a href="{{ route('auction.buyout', $lot) }}" class="btn w-100 btn-lg btn-light justify-content-center mt-2">
                                                            {{ __('Купить по блиц-цене') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="ml-3 mt-3 text-gray">{{ __('Нет доступных лотов') }}.</p>
            @endforelse
        </div>
        <div class="card-inner">
            {{ $lots->appends(request()->except('page'))->links('layouts.pagination.cabinet') }}
        </div>
    </div>
@endsection
