@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Пользователи'))
@section('headerTitle', __('Пользователи'))
@section('headerDesc', __('Список пользователей.'))

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-tools" style="display: flex; flex-direction: row;">
                                <form method="GET" style="margin-right: 15px;">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Поиск') }}...">
                                    </div>
                                </form>
                                <form method="GET" style="margin-right: 15px;">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="accountsearch" value="{{ request()->query('accountsearch') }}" placeholder="{{ __('Поиск по аккаунту') }}...">
                                    </div>
                                </form>
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="charsearch" value="{{ request()->query('charsearch') }}" placeholder="{{ __('Поиск по персонажу') }}...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-ulist is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Пользователь') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Баланс') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Роль') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Дата регистрации') }}</span></div>
                                <div class="nk-tb-col tb-col-md" style="width: 350px;"><span class="sub-text"></span></div>
                            </div>
                            <!-- .nk-tb-item -->
                            @foreach($users as $user)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-primary">
                                                <span class="text-uppercase"> {{ substr(trim($user->name), 0, 2) }} </span>
                                            </div>
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $user->name }}</span>
                                                <span>{{ $user->email }}</span>
                                                <span>{{ $user->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"> <span>{{ $user->balance }}</span> </div>
                                    <div class="nk-tb-col"> <span>{{ $user->role }}</span> </div>
                                    <div class="nk-tb-col tb-col-md"> <span>{{ $user->created_at->format('d/m/Y H:i') }}</span> </div>

                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <div class="users-set">
                                        <div class="coin-set">
                                            <a href="{{ route('backend.user.details', $user) }}" class="btn btn-sm btn-icon btn-trigger getinfo" title="{{ __('Информация') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                                                <em class="icon ni ni-info ml-1"></em>
                                            </a>
                                        </div>
                                        <div class="coin-set">
                                            <a href="{{ route('backend.user.warehouse', $user) }}" class="btn btn-sm btn-icon btn-trigger" title="{{ __('Склад пользователя') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                                                <em class="icon ni ni-inbox ml-1"></em>
                                            </a>
                                        </div>
                                        <div class="coin-set">
                                            <a href="{{ route('logs.userlogs', $user) }}" class="btn btn-sm btn-icon btn-trigger" title="{{ __('Логи пользователя') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                                                <em class="icon ni ni-file-docs ml-1"></em>
                                            </a>
                                        </div>
                                        <div class="coin-set">
                                            <a class="btn btn-sm btn-icon btn-trigger setcoin" title="{{ __('Начислить баланс') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                                                <em class="icon ni ni-coins ml-1"></em>
                                            </a>
                                        </div>
                                        <div class="coin-set">
                                            <a class="btn btn-sm btn-icon btn-trigger setitem" title="{{ __('Начислить предмет') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                                                <em class="icon ni ni-cart ml-1"></em>
                                            </a>
                                        </div>

                                        <div class="drodown">
                                            <a href="#"
                                               class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown" title="{{ __('Назначить роль') }}">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="{{ route('user.ban', $user) }}" class="text-danger">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Забанить') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('user.unban', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Разбанить') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('user.role.admin', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Администратор') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('user.role.investor', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Аналитик') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('user.role.support', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Поддержка') }}</span>
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('user.role.user', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Пользователь') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <div id="popup-balance" class="popup-balance-block">

                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="col-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <h5 class="card-title">
                                                    <span class="mr-2">{{ __('Изменить баланс пользователю ') }} <span id="u_name"></span></span>
                                                </h5>
                                                <span class="popup-close" onClick="$('#popup-balance').hide();">x</span>
                                            </div>
                                        </div>
                                        <div class="card-inner border-top">
                                            <form action="{{ route('user.balance.set') }}" method="POST">
                                                @csrf
                                                <input id="balance_user_id" name="user_id" type="hidden" value="">

                                                <div class="row g-4">
                                                    <div class="col-lg-6">

                                                        <div class="form-group">
                                                            <label class="form-label" for="amount">{{ __('Введите количество') }} {{ config('options.coin_name', 'CoL') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" min="0" step="0.01" class="form-control" id="balance" name="balance"
                                                                       value="{{ old('balance') ? old('balance') : '0' }}">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">{{ __('Начислить') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div id="popup-item" class="popup-balance-block">

                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="col-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <h5 class="card-title">
                                                    <span class="mr-2">{{ __('Выдать предмет пользователю на склад МА') }} <span id="u_name"></span></span>
                                                </h5>
                                                <span class="popup-close" onClick="$('#popup-item').hide();">x</span>
                                            </div>
                                        </div>
                                        <div class="card-inner border-top">
                                            <form action="{{ route('user.item.set') }}" method="POST">
                                                @csrf
                                                <input id="item_user_id" name="user_id" type="hidden" value="">

                                                <div class="row g-4">
                                                    <div class="col-lg-6">

                                                        <div class="form-group">
                                                            <label class="form-label" for="item_id">{{ __('Введите L2 ID предмета') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" min="0" class="form-control" id="item_id" name="item_id"
                                                                       value="{{ old('item_id') ?: '0' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="item_quantity">{{ __('Введите количество') }} {{ __('шт.') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" min="0" class="form-control" id="item_quantity" name="item_quantity"
                                                                       value="{{ old('item_quantity') ?: '0' }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">{{ __('Начислить') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="card-inner">
                        {{ $users->links('layouts.pagination.cabinet') }}
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(document).ready(function () {

            $('.setcoin').on('click', function () {
                $('#popup-balance').show();
                $('#balance_user_id').val($(this).data('userid'));
                $('#u_name').text($(this).data('username'));

                console.log($(this).data('username'));
            });
            $('.setitem').on('click', function () {
                $('#popup-item').show();
                $('#item_user_id').val($(this).data('userid'));
                $('#u_name').text($(this).data('username'));

                console.log($(this).data('username'));
            });
        });
    </script>

    <!-- .nk-block -->
@endsection
