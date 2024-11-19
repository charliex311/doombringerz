<div class="nk-block">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="nk-help">
                <div class="nk-help-img">
                    <em class="icon ni ni-help-alt" style="font-size: 96px;"></em>
                </div>
                <div class="nk-help-text">
                    <h5>{{ __('Торговая площадка') }}</h5>
                    <p class="text-soft">{{ config('options.market_info_' .app()->getLocale(), '') }}</p>
                </div>
                <div class="nk-help-action">
                    <a href="{{ route('market.mylots') }}" class="btn btn-lg btn-outline-primary">{{ __('Ваши предметы на рынке') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>