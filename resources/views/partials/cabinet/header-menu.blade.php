
<x-cabinet.menu-item title="{{ __('О нас') }}" route="index" />
<x-cabinet.menu-item title="{{ __('FAQ') }}" href="{{ config('options.forum_link', '#') }}" />
<x-cabinet.menu-item title="{{ __('Дорожная карта') }}" route="donate" />
<x-cabinet.menu-item title="{{ __('Баг Трекер') }}" route="donate" />
<x-cabinet.menu-item title="{{ __('Логи Релизов') }}" route="donate" />
<x-cabinet.menu-item title="{{ __('Дорожная карта') }}" route="donate" />

<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createAccount" style="width: 80%;margin-left: 25px;">
	<em class="icon ni ni-plus-c mr-1"></em>
	<span class="d-sm-inline mr-1">{{ __('Создать игровой аккаунт') }}</span>
</a>
