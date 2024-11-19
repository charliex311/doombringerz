<li @class(['nk-menu-item', 'active current-page' => isset($route) ? Route::is($pattern) : false])>
    <a href="{{ isset($route) ? route($route) : ($href ? $href : '#') }}" class="nk-menu-link @isset($server) server-click @endisset" @isset($server) data-server="{{ $server }}"@endisset>
        @isset($icon)
            <span class="nk-menu-icon"><em class="icon ni ni-{{ $icon }}"></em></span>
        @endisset
        <span class="nk-menu-text">{{ $title }}</span>
        {{ $slot }}
    </a>
</li>
