<footer class="footer">
    <div class="footer__container main-container">
        <div class="footer__body">
            <div class="footer__top">
                <nav class="footer-nav">
                    <ul class="footer-nav__list">
                        <li class="footer-nav__item"><a href="{{ route('about_us') }}" class="footer-nav__link {{ is_active('about_us') }}">{{ __('О нас') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('cabinet') }}" class="footer-nav__link">{{ __('Аккаунт') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('roadmap') }}" class="footer-nav__link">{{ __('Дорожная карта') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('reports') }}" class="footer-nav__link">{{ __('Keep Track') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('shop') }}" class="footer-nav__link">{{ __('Магазин') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('tickets') }}" class="footer-nav__link">{{ __('Поддержка') }}</a></li>

                        <li class="footer-nav__item"><a href="{{ route('terms') }}" class="footer-nav__link">{{ __('Условия обслуживания') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('privacy') }}" class="footer-nav__link">{{ __('Политика конфиденциальности') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('rules') }}" class="footer-nav__link">{{ __('Правила и положения') }}</a></li>
                        <li class="footer-nav__item"><a href="{{ route('refund') }}" class="footer-nav__link">{{ __('Политика возврата') }}</a></li>
                    </ul>
                </nav>
            </div>
            <div class="footer__bottom">
                <div class="footer__row">
                    <div class="footer__logos">
                        <a href="/" class="footer__website-logo">
                            <img src="/img/footer/logo-footer.svg" alt="logo-footer">
                        </a>
                        <a target="_blank" href=" https://unsimpleworld.com" title="Website development / разработка сайта UNSIMPLE WORLD" dofollow="" class="footer__un-logo">
                            <img src="/img/footer/unsimple-logo.svg" alt="unsimple-logo">
                        </a>
                    </div>
                    <div class="footer__copy">
                        {{ date('Y') }} © Hellreach. All right are reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
