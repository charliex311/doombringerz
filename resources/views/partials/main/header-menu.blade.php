<div class="header__navigation">
    <nav>
        <ul class="nav">
            <li><a href="{{ route('about_us') }}" class="{{ is_active('about_us') }}">{{ __('О нас') }}</a></li>
            <li><a href="{{ route('faq') }}" class="{{ is_active('faq') }}">{{ __('FAQ') }}</a></li>
            <li><a href="{{ route('roadmap') }}" class="{{ is_active('roadmap') }}">{{ __('Дорожная карта') }}</a></li>
        </ul>
        <ul>
            <li class="nav__item nav__item_dropdown">
                <div class="dropdown">
                    <ul class="dropdown__list">
                        <li class="dropdown__item"><a href="{{ route('reports') }}" class="dropdown__link {{ is_active('reports') }}">{{ __('Баг Трекер') }}</a></li>
                        <li class="dropdown__item"><a href="{{ route('releasenotes') }}" class="dropdown__link {{ is_active('releasenotes') }}">{{ __('Логи Релизов') }}</a></li>
                    </ul>
                </div>
                <span class="nav__link nav__link_dropdown-link @if(str_contains(url()->current(), '/keep_track') ){{ 'active' }}@endif">{{ __('Keep Track') }} <img class="nav__arrow" src="/img/sprite/whit-arrow-down.png" alt=""></span>
            </li>
            <li><a href="{{ route('tickets') }}" class="{{ is_active('tickets') }}">{{ __('Поддержка') }}</a></li>
            <li><a href="{{ route('shop') }}" class="{{ is_active('shop') }}">{{ __('Магазин') }}</a></li>
        </ul>
    </nav>
</div>
