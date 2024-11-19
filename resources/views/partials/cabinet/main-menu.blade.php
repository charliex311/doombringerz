<ul class="nk-menu">

    <li class="nk-menu-heading">
        <h6 class="overline-title text-primary-alt">{{ __('Личный кабинет') }}</h6>
    </li>

    <x-cabinet.menu-item title="{{ __('Главная') }}" icon="home" route="cabinet" />
    <x-cabinet.menu-item title="{{ __('Рефералы') }}" icon="users" route="cabinet.referrals.index" />
    <x-cabinet.menu-item title="{{ __('Промо код') }}" icon="offer" route="promocodes" />
    <x-cabinet.menu-item title="{{ __('Поддержка') }}" icon="help-alt" route="tickets" />
    <x-cabinet.menu-item title="{{ __('Настройки') }}" icon="setting" route="settings.profile" pattern="settings.*" />
    <x-cabinet.menu-item title="{{ __('Магазин') }}" icon="cart" route="shop" />
    <x-cabinet.menu-item title="{{ __('Колесо удачи') }}" icon="help-alt" route="luckywheel.index" />
    <x-cabinet.menu-item title="{{ __('Пожертвование') }}" icon="coins" route="donate" />
    <x-cabinet.menu-item title="{{ __('Логи') }}" icon="file-docs" route="activitylogs" />

    <li class="nk-menu-item">
        <a href="{{ route('logout') }}" class="nk-menu-link " data-original-title="" title="">
            <span class="nk-menu-icon"><em class="icon ni ni-signout"></em></span>
            <span class="nk-menu-text">{{ __('Выйти') }}</span>

        </a>
    </li>

    <li class="nk-menu-heading">
        <h6 class="overline-title text-primary-alt">{{ __('Баланс') }}</h6>
    </li>

    <li class="nk-menu-item">
        <span class="nk-menu-link balance-cur">
            <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
            <span class="nk-menu-text"><span class="user-balance">{{ auth()->user()->balance }}</span> {{ config('options.server_0_coin_short_name', 'CoL') }}</span>
        </span>
    </li>


    <li class="nk-menu-heading">
        <h6 class="overline-title text-primary-alt">{{ __('Статус Игровых миров') }}</h6>

        @foreach(getservers() as $server)
            <x-cabinet.menu-item title="{{ $server->name }}" icon="server" server="{{ $server->id }}">
            <span class="badge badge-pill badge-{{ server_status($server->id) === 'Online' ? 'success' : 'danger' }}">
                {{ server_status($server->id) }} @if(server_status($server->id) === 'Online') ({{ online_count($server->id) }}) @endif
            </span>
            </x-cabinet.menu-item>
        @endforeach

    </li>
</ul>
