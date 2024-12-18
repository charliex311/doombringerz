<footer class="footer dark:!bg-gray-800 bg-white">
    <div class="footer__container main-container">
        <div class="footer__body">
            <div class="footer__top">
                <nav class="footer-nav">
                    <ul class="footer-nav__list">
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('about_us') }}"
                                class="footer-nav__link {{ is_active('about_us') }}">About us</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('cabinet') }}"
                                class="footer-nav__link">{{ __('Аккаунт') }}</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('roadmap') }}"
                                class="footer-nav__link">{{ __('Дорожная карта') }}</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('track') }}"
                                class="footer-nav__link">{{ __('Track') }}</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('merchandise') }}"
                                class="footer-nav__link">Merchandise</a></li>

                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('digi-goods') }}"
                                class="footer-nav__link">Digi Goods</a></li>

                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('contact') }}"
                                class="footer-nav__link">Contact</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('tickets') }}"
                                class="footer-nav__link">{{ __('Поддержка') }}</a></li>

                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('terms') }}"
                                class="footer-nav__link">{{ __('Условия обслуживания') }}</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('privacy') }}"
                                class="footer-nav__link">{{ __('Политика конфиденциальности') }}</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a href="{{ route('rules') }}"
                                class="footer-nav__link">{{ __('Правила и положения') }}</a></li>
                        <li class="footer-nav__item dark:text-gray-50"><a
                                href="https://markipliershop.com/return-refund/"
                                class="footer-nav__link">{{ __('Политика возврата') }}</a></li>
                    </ul>
                </nav>
            </div>

            <div class="flex flex-col w-full">
                <div class="flex flex-col mx-auto">
                    <div class="flex dark:text-gray-50 items-center gap-2">
                        <i class="fa fa-envelope"></i>
                        <a href="mailto::contact@doombringerz.com" class="">contact@doombringerz.com</a>
                    </div>
                </div>

                <div class="" style="display:flex; gap: 14px; justify-content: end; color: #01A7E1">
                    <a href="https://twitter.com/D00mbringerz" class="">
                        <i class="fab fa-x"></i>
                    </a>

                    <a href="https://twitch.tv/d00mbringerz" class="">
                        <i class="fab fa-twitch"></i>
                    </a>

                    <a href="https://tiktok.com/@doombringerz" class="">
                        <i class="fab fa-tiktok"></i>
                    </a>

                    <a href="ko-fi.com/doombringerz" class="">
                        <i class="fab fa-kofi">Ko Fi</i>
                    </a>
                </div>
            </div>
            <div class="footer__bottom">
                <div class="footer__row">
                    <div class="footer__logos">
                        <a href="/" class="footer__website-logo">
                            <img src="/img/logo-light.png" alt="logo"
                                class="object-contain h-16 hidden dark:block">
                            <img src="/img/logo-dark.png" alt="logo" class="object-contain h-16 dark:hidden">
                        </a>
                        {{-- <a target="_blank" href=" https://unsimpleworld.com" title="Website development / разработка сайта UNSIMPLE WORLD" dofollow="" class="footer__un-logo">
                            <img src="/img/footer/unsimple-logo.svg" alt="unsimple-logo">
                        </a> --}}
                    </div>
                    <div class="footer__copy  dark:text-gray-50">
                        Powered by Ridoco & Ridoen. © {{ now()->format('Y') }} Doombringerz. All Rights Reserved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
