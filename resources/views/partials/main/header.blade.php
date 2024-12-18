<header class="header dark:!bg-gray-800 transition duration-300">
    <div class="flex items-center w-full px-12">


        <a href="{{ route('index') }}" class="h-12">
            <img src="/img/logo-light.png" alt="logo" class="object-contain h-full hidden dark:block">
            <img src="/img/logo-dark.png" alt="logo" class="object-contain h-full dark:hidden">
        </a>

        @include('partials.main.header-menu')

        @include('partials.main.header-languages')

        @include('partials.main.header-dark-mode-toggle')

        @include('partials.main.header-account')

        <div class="header__burger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>
