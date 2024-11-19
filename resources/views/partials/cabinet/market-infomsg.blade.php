@if(!$marketitems)
    <div class="alert alert-warning">
        <div class="alert-cta flex-wrap flex-md-nowrap">
            <div class="alert-text">
                <p>{{ __('У вас нет в продаже предметов.') }}</p>
            </div>
            <ul class="alert-actions gx-3 mt-3 mb-1 my-md-0">
                <li class="order-md-last">
                    <a href="{{ route('market.sell') }}" class="btn btn-sm btn-warning">{{ __('Продать предметы') }}</a>
                </li>
            </ul>
        </div>

    </div>
@endif