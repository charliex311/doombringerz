<div class="menu dark:bg-gray-800 flex flex-col h-full">
    <div class="menu__container">
        <div class="menu__close"></div>
        <div class="menu__inner">
            <nav class="menu-nav">
                <ul class="menu-nav__list">
                    <li class="menu-nav__item"><a href="{{ route('about_us') }}" class="menu-nav__link {{ is_active('about_us') }}">{{ __('О нас') }}</a></li>
                    <li class="menu-nav__item"><a href="{{ route('faq') }}" class="menu-nav__link {{ is_active('faq') }}">{{ __('FAQ') }}</a></li>
                    <li class="menu-nav__item"><a href="{{ route('roadmap') }}" class="menu-nav__link {{ is_active('roadmap') }}">{{ __('Дорожная карта') }}</a></li>
                    <li class="menu-nav__item menu-nav__item_dropdown @if(str_contains(url()->current(), '/keep_track') ){{ 'active' }}@endif"><span>{{ __('Keep Track') }}</span><img src="/img/sprite/whit-arrow-down.png" alt="arrow-down">
                        <ul class="menu-dropdown">
                            <li class="menu-dropdown__item"><a href="{{ route('reports') }}" class="menu-dropdown__link {{ is_active('reports') }}">{{ __('Баг Трекер') }}</a></li>
                            <li class="menu-dropdown__item"><a href="{{ route('releasenotes') }}" class="menu-dropdown__link {{ is_active('releasenotes') }}">{{ __('Логи Релизов') }}</a></li>
                        </ul>
                    </li>
                    <li class="menu-nav__item"><a href="{{ route('tickets') }} " class="menu-nav__link {{ is_active('tickets') }}">{{ __('Поддержка') }}</a></li>
                    <li class="menu-nav__item"><a href="{{ route('shop') }}" class="menu-nav__link {{ is_active('shop') }}">{{ __('Магазин') }}</a></li>
                </ul>
            </nav>
            @if(isset(auth()->user()->id))
                <a href="{{ route('cabinet') }}" class="header__register btn">
                    <span>{{ __('Аккаунт') }}</span>
                </a>
            @else
                <button class="header__login btn login--trigger">
                    <span>{{ __('Войти') }}</span>
                </button>
                <a class="header__register btn reg--trigger mt-4">
                    <span>{{ __('Регистрация') }}</span>
                </a>
            @endif
        </div>
    </div>


    <div class="mt-auto flex py-4 px-2 justify-end">
        @include('partials.main.header-dark-mode-toggle')
    </div>
</div>
