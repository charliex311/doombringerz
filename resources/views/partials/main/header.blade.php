<header class="header">

    @include('partials.main.header-account')

    <div class="header__container main-container">
        <div class="header__row">

            @include('partials.main.header-menu')

            <a href="{{ route('index') }}" class="header__logo">
                <img src="/img/logo_red.png" alt="logo">
            </a>

            @include('partials.main.header-languages')

            <div class="header__burger">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</header>
