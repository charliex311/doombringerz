<div class="languages" style="margin-left: 18px;">
    <a href="{{ route('setlocale', 'en') }}"
       @class(['languages__item en', 'active' => app()->getLocale() === 'en'])
       title="English"></a>
</div>
