<div class="languages" style="margin-left: 18px;">
    @if((config('options.language1') !== NULL && config('options.language1') === 'en'))
        <a href="{{ route('setlocale', 'en') }}"
           @class(['languages__item en', 'active' => app()->getLocale() === 'en'])
        title="Русский"></a>
    @endif
    @if(config('options.language2') !== NULL && config('options.language2') === 'ru')
        <a href="{{ route('setlocale', 'ru') }}"
           @class(['languages__item ru', 'active' => app()->getLocale() === 'ru'])
        title="English"></a>
    @endif
    @if(config('options.language3') !== NULL && config('options.language3') === 'pt')
        <a href="{{ route('setlocale', 'pt') }}"
           @class(['languages__item br', 'active' => app()->getLocale() === 'pt'])
        title="Português"></a>
    @endif
    @if(config('options.language4') !== NULL && config('options.language4') === 'es')
        <a href="{{ route('setlocale', 'es') }}"
           @class(['languages__item es', 'active' => app()->getLocale() === 'es'])
        title="Español"></a>
    @endif
            @if(config('options.language5') !== NULL && config('options.language5') === 'fr')
                    <a href="{{ route('setlocale', 'fr') }}"
                       @class(['languages__item fr', 'active' => app()->getLocale() === 'fr'])
                    title="Français"></a>
            @endif
</div>
