@extends('layouts.cabinet')

@section('title', __('Персонажи'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">@yield('title'){{ $account !== null ? ':' : '' }} <span class="text-primary">{{ $account }}</span></span>
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-ulist is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Персонаж') }}</span></div>
                                @if ($account === null)
                                    <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Аккаунт') }}</span></div>
                                @endif
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Уровень') }}</span></div>
                                <div class="nk-tb-col tb-col-sm"><span class="sub-text">{{ __('Клан') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('PVP') }}</span></div>
                                <div class="nk-tb-col tb-col-xl"><span class="sub-text">{{ __('PK') }}</span></div>
                                <div class="nk-tb-col tb-col-xl"><span class="sub-text">{{ __('Игровое время') }}</span></div>
                                <div class="nk-tb-col tb-col-xl"><span class="sub-text">{{ __('Последний вход') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text"></span></div>
                            </div>
                            <!-- .nk-tb-item -->
                            @if($characters)
                            @forelse($characters as $character)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-primary" title="{{ $character->class }}">
                                                @if(in_array($character->class, [0,10,18,31,38,49]))
                                                    <span class="text-uppercase"> {{ $character->class }} </span>
                                                @else
                                                    <img src="{{ asset("images/class/{$character->class}.gif") }}" alt="" style="z-index: 1;" >
                                                    <span class="text-uppercase position-absolute"> {{ $character->class }} </span>
                                                @endif
                                            </div>
                                            <div class="user-name"> <span class="tb-lead">{{ $character->char_name }}</span> </div>
                                        </div>
                                    </div>
                                    @if ($account === null)
                                        <div class="nk-tb-col tb-col-md"> <span>{{ $character->account_name }}</span> </div>
                                    @endif
                                    <div class="nk-tb-col tb-col-md"> <span>{{ $character->lvl }}</span> </div>
                                    <div class="nk-tb-col tb-col-sm"> <span>{{ $character->clanName ?: '-' }}</span> </div>
                                    <div class="nk-tb-col tb-col-md"> <span>{{ $character->Duel }}</span> </div>
                                    <div class="nk-tb-col tb-col-xl"> <span>{{ $character->PK }}</span> </div>
                                    <div class="nk-tb-col tb-col-xl">
                                        <ul class="list-status">
                                            <li>
                                                <em class="icon text-gray ni ni-clock"></em>
                                                <span>{{ format_seconds($character->use_time) }}</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="nk-tb-col tb-col-xl">
                                        <span>{{ $character->LastLogin }}</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        @if ($character->BanChar == 1)
                                            <span class="tb-status text-danger">
                                                <em class="icon text-danger ni ni-report"></em>
                                                {{ __('Забанен') }}
                                            </span>
                                        @else
                                            @if ($character->online)
                                                <span class="tb-status text-success">{{ __('Онлайн') }}</span>
                                            @else
                                                <span class="tb-status text-danger">{{ __('Оффлайн') }}</span>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <div class="drodown"> <a href="#" class="btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="{{ route('characters.inventory', $character->char_id) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Инвентарь') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('characters.teleport', $character->char_id) }}">
                                                            <em class="icon ni ni-home-alt"></em>
                                                            <span>{{ __('Отправить в город') }}</span>
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
                                        {{ __('У Вас пока нет персонажей') }}.
                                    </div>
                                    <div class="nk-tb-col tb-col-md">  </div>
                                    <div class="nk-tb-col tb-col-sm">  </div>
                                    <div class="nk-tb-col tb-col-md">  </div>
                                    <div class="nk-tb-col tb-col-xl">  </div>
                                    <div class="nk-tb-col tb-col-xl">  </div>
                                    <div class="nk-tb-col tb-col-xl">  </div>
                                    <div class="nk-tb-col tb-col-xl">  </div>
                                    <div class="nk-tb-col">  </div>
                                </div>
                            @endforelse

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
