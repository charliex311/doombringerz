<div class="col-4">
    <div class="card card-bordered card-full">
        <div class="card-inner">
            <div class="card-title-group category-group">
                @php
                    $title = "title_" .app()->getLocale();
                    $description = "description_" .app()->getLocale();
                @endphp
                @foreach($marketcategories as $marketcategory)
                    <div class="card-title category-item">
                        <a href="{{ route('market.category', $marketcategory) }}">
                            <img src="/storage/{{ $marketcategory->image }}">
                            <div class="category-info">
                                <h6 class="title"><span class="mr-2">{{ $marketcategory->$title }}</span></h6>
                                <div class="user-name">{{ $marketcategory->$description }}</div>
                            </div>
                        </a>
                        <div class="category-count">
                            <span class="badge badge-pill badge-primary">{{ marketitems_count_bycategory($marketcategory->id, session('server_id')) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="card-title category-btn">
                <ul class="alert-actions gx-3 mt-3 mb-1 my-md-0">
                    <li class="order-md-last">
                        <a href="{{ route('market.sell') }}" class="btn btn-sm btn-warning">{{ __('Продать предметы') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>