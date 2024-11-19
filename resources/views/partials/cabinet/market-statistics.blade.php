<div class="nk-block">
    <div class="row g-gs">
        <div class="col-sm-8">
            <div class="card card-bordered">
                <div class="card-inner card-statistic">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title"><span class="mr-2">{{ __('Статистика') }}</span></h6>
                        </div>
                        @isset($marketsolds)
                            <div class="tb-col-md"><span class="sub-text"><a href="{{ route('market.index') }}">{{ __('Торговая площадка') }}</a></span></div>
                        @else
                            <div class="tb-col-md"><span class="sub-text"><a href="{{ route('market.history') }}">{{ __('История моих продаж') }}</a></span></div>
                        @endisset

                    </div>
                </div>
                <div class="card-inner p-0 border-top">
                    <div class="nk-tb-list nk-tb-orders">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span class="sub-text sub-statistics">{{ __('Продаж сегодня') }}: <span class="count-number">{{ $statistic->total_sales_today }}</span></span></div>
                            <div class="nk-tb-col"><span class="sub-text sub-statistics">{{ __('Продаж за неделю') }}: <span class="count-number">{{ $statistic->total_sales_week }}</span></span></div>
                            <div class="nk-tb-col"><span class="sub-text sub-statistics">{{ __('Новых сегодня') }}: <span class="count-number">{{ $statistic->total_new_today }}</span></span></div>
                            <div class="nk-tb-col tb-col-md"><span class="sub-text sub-statistics">{{ __('Новых за неделю') }}: <span class="count-number">{{ $statistic->total_new_week }}</span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-4">
            <div class="card card-bordered">
                <div class="card-inner card-statistic">
                    <div class="card-title-group">
                        <div class="card-title">
                            <h6 class="title"><span class="mr-2">{{ __('Профиль') }}</span></h6>
                        </div>
                        <div class="tb-col-md"><span class="sub-text">{{ __('УРОВЕНЬ') }}: <span class="count-number">{{ $seller->trust_lvl }}</span></span></div>
                    </div>
                </div>
                <div class="card-inner p-0 border-top">
                    <div class="nk-tb-list nk-tb-orders">
                        <div class="nk-tb-item nk-tb-head">
                            <div class="nk-tb-col"><span class="sub-text sub-statistics">{{ __('Активных') }}: <span class="count-number">{{ $statistic->total_seller_active }}</span></span></div>
                            <div class="nk-tb-col"><span class="sub-text sub-statistics">{{ __('Продажи') }}: <span class="count-number">{{ $statistic->total_seller_sales }}</span></span></div>
                            <div class="nk-tb-col"><span class="sub-text sub-statistics">{{ __('Комиссия') }}: <span class="count-number">{{ config('options.market_seller_commission', '5') }}%</span></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>