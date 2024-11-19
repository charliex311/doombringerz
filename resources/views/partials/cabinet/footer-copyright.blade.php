<div class="footer__copyright-info">
    <div class="footer__copyright-info--text">
        &copy; {{ date('Y') }} {{ config('options.title', 'WoW') }}
    </div>
    <div class="footer__copyright-info--policy" style="display:flex; flex-direction: row;">
        <a href="{{ route('terms') }}">{{ __('Условия обслуживания') }}</a>
        <a href="{{ route('privacy') }}">{{ __('Политика конфиденциальности') }}</a>
    </div>
</div>
