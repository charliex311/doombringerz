<div class="header__navigation">
    <nav>
        <ul>
            <li><a href="{{ route('about_us') }}" class="{{ is_active('about_us') }} dark:text-gray-50">{{ __('О нас') }}</a></li>
            <li><a href="{{ route('roadmap') }}" class="{{ is_active('roadmap') }} dark:text-gray-50">{{ __('Дорожная карта') }}</a></li>
            <li class="nav__item nav__item_dropdown">
                <div class="dropdown dark:bg-gray-800 bg-[#0270d2]">
                    <ul class="dropdown__list">
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Arcavell</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Apolytonomachy</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Crepuscule</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Godsbane</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Malfeasance</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Omniclasm,</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Revenant Realms</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Sylvathar</a></li>
                        <li class="dropdown__item"><a href="#" class="dropdown__link dark:text-gray-50">Sylvafia and Wilderheart</a></li>
                    </ul>
                </div>
                <span class="nav__link nav__link_dropdown-link dark:text-gray-50">Featured projects <i class="fa fa-chevron-down"></i></span>
            </li>
            <li><a href="{{ route('tickets') }}" class="{{ is_active('tickets') }} dark:text-gray-50">{{ __('Поддержка') }}</a></li>

            <li class="nav__item nav__item_dropdown">
                <div class="dropdown dark:bg-gray-800 bg-[#0270d2]">
                    <ul class="dropdown__list">
                        <li class="dropdown__item"><a href="{{ route('merchandise') }}" class="{{ request()->routeIs('merchandise') ? '!text-blue-300 font-semibold' : '' }} dark:text-gray-50">Merchandise</a></li>
                        <li class="dropdown__item"><a href="{{ route('track') }}" class="{{ request()->routeIs('track') ? '!text-blue-300 font-semibold' : '' }} dark:text-gray-50">Track</a></li>
                    </ul>
                </div>
                <span class="nav__link nav__link_dropdown-link dark:text-gray-50">Merchandise <i class="fa fa-chevron-down"></i></span>
            </li>
            <li><a href="{{ route('digi-goods') }}" class="{{ request()->routeIs('digi-goods') ? '!text-blue-300 font-semibold' : '' }} dark:text-gray-50">Digi-Goods</a></li>
            <li><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? '!text-blue-300 font-semibold' : '' }} dark:text-gray-50">Contact</a></li>
            {{-- <li><a href="{{ route('shop') }}" class="{{ is_active('shop') }}">{{ __('Магазин') }}</a></li> --}}

            <li><a href="{{ route('faq') }}" class="{{ is_active('faq') }} dark:text-gray-50">{{ __('FAQ') }}</a></li>
        </ul>
    </nav>
</div>
