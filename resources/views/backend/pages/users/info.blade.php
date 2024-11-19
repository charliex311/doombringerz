@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Пользователи'))
@section('headerTitle', __('Пользователи'))
@section('headerDesc', $user->name)

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title flex flex-column">
                                <span class="mr-2 mb-gs">{{ __('Информация о пользователе') }}</span>
                                <span><img src="{{ $user->avatar_url }}" alt="avatar" class="userinfo-avatar"> {{ $user->name }}</span>
                            </h5>
                        </div>
                    </div>

                    <div class="card-inner p-0 border-top card-userinfo">

                        <div class="nk-reply-item">
                            <div class="nk-reply-header">
                                <div class="user-card flex-column align-items-start">
                                    <p><span class="bold">{{ __('Email') }}:</span> {{ $user->email }}</p>
                                    <p><span class="bold">{{ __('Телефон') }}:</span> {{ $user->phone }}</p>
                                    <p><span class="bold">{{ __('PIN код') }}:</span> {{ $user->pin }}</p>
                                    <p><span class="bold">{{ __('Баланс') }}:</span> {{ $user->balance }} {{ config('options.coin_name', 'CoL') }}</p>
                                    <p><span class="bold">{{ __('Дата создания') }}:</span> {{ $user->created_at->format('d.m.Y') }}</p>
                                    <p><a id="BtnChangePasswordMA" class="btn btn-secondary btn-change">{{ __('Изменить пароль Мастер Аккаунта') }}</a></p>
                                    <p><a id="BtnChangeEmailMA" class="btn btn-secondary btn-change">{{ __('Изменить email Мастер Аккаунта') }}</a></p>
                                    <p><a href="{{ route('backend.user.account.create', $user) }}" class="btn btn-secondary btn-change" onClick="return Confirm();">{{ __('Создать/Привязать Игровой Аккаунт') }}</a></p>

                                    <div class="nk-tb-col nk-tb-col-tools users-set" style="float: left;justify-content: start;width: 100%;">
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
                                            <a class="btn btn-sm btn-icon btn-trigger set-balance-btn" title="{{ __('Начислить баланс') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
                                                <em class="icon ni ni-coins ml-1"></em>
                                            </a>
                                        </div>
                                        <div class="coin-set">
                                            <a class="btn btn-sm btn-icon btn-trigger set-item-btn" title="{{ __('Начислить предмет') }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">
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
                                                        <a href="{{ route('user.role.admin', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Администратор') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('user.role.investor', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>{{ __('Инвестор') }}</span>
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
                        </div>
                        <div class="nk-reply-item nk-reply-server">
                            <div class="nk-reply-header-bc">
                                <div class="user-card flex-row align-items-start">
                                    @foreach($data as $server)
                                    <div class="server-block">
                                        <div class="server-header">{{ __('Сервер') }} : {{ $server['server']->name }}</div>
                                            <div class="account-block">

                                                <div class="account-info-block">
                                                <div class="account-header-block">
                                                <div class="account-header">{{ __('Аккаунт') }} : {{ isset($server['account']->login) ? $server['account']->login : '-' }}</div>

                                                @if(count($server['characters']) > 0)
                                                    @php $char_isset = false; @endphp

                                                    @foreach($server['characters'] as $character)
                                                        @if(strtolower($character->account) == strtolower($server['game_account']->id))
                                                            @php $char_isset = true; @endphp
                                                        @endif
                                                    @endforeach

                                                    @foreach($server['characters'] as $character)
                                                        @if(strtolower($character->account) == strtolower($server['game_account']->id))
                                                            <div class="character-block">
                                                                <div class="character-header">{{ __('Персонаж') }} : {{ $character->name }}</div>
                                                            </div>
                                                        @endif
                                                        @if($char_isset === false)
                                                                @php $char_isset = true; @endphp
                                                            <div class="character-block">
                                                                {{ __('Нет персонажей') }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @else
                                                    <div class="character-block">
                                                        {{ __('Нет персонажей') }}
                                                    </div>
                                                @endif
                                                </div>
                                            </div>
                                                <div class="nk-tb-col nk-tb-col-action">
                                                    <div class="dropdown">
                                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                                            <em class="icon ni ni-more-h" style="transform: rotate(90deg);"></em>
                                                        </a>
                                                        <div class="dropdown-menu dropdown-menu-right">
                                                            <ul class="link-list-plain">
                                                                <li><a href="#" data-change-password="{{ $server['account'] }}" data-serverid="{{ $server['server']->id }}">{{ __('Сменить пароль') }}</a></li>
                                                                <li><a href="#" data-transfer-account="{{ $server['account'] }}" data-serverid="{{ $server['server']->id }}">{{ __('Перенести в МА') }}</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection

@prepend('scripts')

    <div class="modal fade zoom" tabindex="-1" id="ChangePasswordMA">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Изменить пароль Мастер Аккаунта') }}</h5>
                </div>
                <form method="POST" action="{{ route('backend.user.change.password') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="modal-body">

                        <div class="form-group">
                            <label class="form-label" for="new_password">{{ __('Новый пароль') }} <small style="display: block;font-size: 11px;">({{ __('используйте латинские буквы и введите не менее 8 символов и не более 20') }})</small></label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                                @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="new_password_confirmation">{{ __('Подтвердите новый пароль') }}</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required>
                                @error('new_password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Изменить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zoom" tabindex="-1" id="ChangeEmailMA">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Изменить email Мастер Аккаунта') }}</h5>
                </div>
                <form method="POST" action="{{ route('backend.user.change.email') }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="modal-body">

                        <div class="form-group">
                            <label class="form-label" for="email">{{ __('Новый email') }}</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" required>
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Изменить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zoom" tabindex="-1" id="changePasswordAccount">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Изменить пароль Аккаунта') }} - <span id="accountLogin"></span></h5>
                </div>
                <form method="POST" action="{{ route('backend.user.account.change.password') }}">
                    @csrf
                    <input type="hidden" id="changePasswordLogin" name="login">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" id="server_id" name="server_id">

                    <div class="modal-body">

                        <div class="form-group">
                            <label class="form-label" for="new_password">{{ __('Новый пароль') }} <small style="display: block;font-size: 11px;">({{ __('используйте латинские буквы и введите не менее 6 символов и не более 16') }})</small></label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password" required>
                                @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="new_password_confirmation">{{ __('Подтвердите новый пароль') }}</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror" id="new_password_confirmation" name="new_password_confirmation" required>
                                @error('new_password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Изменить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zoom" tabindex="-1" id="TransferAccount">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Перенести Аккаунт') }} - <span id="transferAccountLogin"></span></h5>
                </div>
                <form method="POST" action="{{ route('backend.user.account.transfer') }}">
                    @csrf
                    <input type="hidden" id="transfer_account_login" name="login">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <input type="hidden" id="transfer_server_id" name="server_id">
                    <input type="hidden" id="transfer_user_id" name="transfer_user_id">

                    <div class="modal-body">

                        <div class="form-group">
                            <label class="form-label" for="user_name">{{ __('Перенести на Мастер Аккаунт') }} <small style="display: block;font-size: 11px;">({{ __('введите имя МА и выберите из выпадающего списка') }})</small></label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control @error('user_name') is-invalid @enderror" id="user_name" name="user_name" required>
                                <div class="form-icon form-icon-right" style="cursor: pointer;">
                                    <em class="icon ni ni-search"></em>
                                </div>
                                @error('user_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div id="users-find"></div>

                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Перенести') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zoom" tabindex="-1" id="set-balance">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Изменить баланс пользователю') }} <span id="u_name"></span></h5>
                </div>
                <form method="POST" action="{{ route('user.balance.set') }}">
                    @csrf
                    <input id="balance_user_id" name="user_id" type="hidden" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label" for="amount">{{ __('Введите сумму') }}</label>
                            <div class="form-control-wrap">
                                <input type="number" min="0" step="0.01" class="form-control" id="balance" name="balance"
                                       value="{{ old('balance') ? old('balance') : '0' }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Изменить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zoom" tabindex="-1" id="set-item">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Выдать предмет пользователю на склад МА') }} <span id="ui_name"></span></h5>
                </div>
                <form method="POST" action="{{ route('user.item.set') }}">
                    @csrf
                    <input id="item_user_id" name="user_id" type="hidden" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label" for="item_id">{{ __('Введите ID предмета') }}</label>
                            <div class="form-control-wrap">
                                <input type="number" min="0" class="form-control" id="item_id" name="item_id"
                                       value="{{ old('item_id') ?: '0' }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="item_quantity">{{ __('Введите количество') }} {{ __('шт.') }}</label>
                            <div class="form-control-wrap">
                                <input type="number" min="0" class="form-control" id="item_quantity" name="item_quantity"
                                       value="{{ old('item_quantity') ?: '0' }}">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Начислить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endprepend
@push('scripts')
    <script>
        $(document).ready(function () {

            $('#BtnChangePasswordMA').on('click', function () {
                $('#ChangePasswordMA').modal('show');
                return false;
            });
            $('#BtnChangeEmailMA').on('click', function () {
                $('#ChangeEmailMA').modal('show');
                return false;
            });

            $('[data-change-password]').on('click', function () {
                $('#accountLogin').html($(this).data('change-password'));
                $('#changePasswordLogin').val($(this).data('change-password'));
                $('#server_id').val($(this).data('serverid'));

                $('#changePasswordAccount').modal('show');
                return false;
            });
            $('[data-transfer-account]').on('click', function () {
                $('#transferAccountLogin').html($(this).data('transfer-account'));
                $('#transfer_account_login').val($(this).data('transfer-account'));
                $('#transfer_server_id').val($(this).data('serverid'));

                $('#TransferAccount').modal('show');
                return false;
            });

            $('input[name="user_name"]').change(function() {
                let input = $(this);
                let html = '';
                input.removeClass('success-input');
                input.removeClass('error-input');
                $.ajax({
                    type: "POST",
                    url: "{{ route('backend.users.getuserbyname') }}",
                    dataType: "json",
                    data: { user_name: $(this).val(), _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#users-find').addClass('find-active');
                        $.each(data.users,function(index, user){
                            console.log(user);
                            html = html + '<span class="user-find" onClick="UserSelect(\''+user.id+'\',\''+user.name+'\');">'+user.name+'</span>';
                            $('#users-find').html(html);
                        });
                    } else {
                        input.addClass('error-input');
                    }
                });
            });

            $('.set-balance-btn').on('click', function () {
                $('#set-balance').modal('show');
                return false;
            });
            $('.set-item-btn').on('click', function () {
                $('#set-item').modal('show');
                return false;
            });
        });

        function UserSelect(user_id, user_name) {
            console.log(user_id);
            $('input[name="transfer_user_id"]').val(user_id);
            $('input[name="user_name"]').val(user_name);
            $('#users-find').removeClass('find-active');
        }
    </script>
    <script>
        function Confirm() {
            if (confirm("{{ __('Вы уверены, что хотите создать/привязать Игровой Аккаунт?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endpush