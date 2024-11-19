<header class="header">
    <div class="header__container main-container">
        <div class="header__row">

            @include('partials.main.header-menu')

            <a href="{{ route('index') }}" class="header__logo">
                <img src="/img/logo_red.png" alt="logo">
            </a>

            @include('partials.main.header-languages')

            <div class="nk-header-menu mobile">
                <ul class="nk-menu nk-menu-main">
                    @include('partials.cabinet.header-menu')
                </ul>
            </div>

            @include('partials.cabinet.user-dropdown')

        </div>
    </div>
</header>
