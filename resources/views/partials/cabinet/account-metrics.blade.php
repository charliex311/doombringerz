<div class="nk-block">
    <div class="row g-gs">
        @include('partials.cabinet.balance')
        <div class="col-sm-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">{{ __('Склад') }}</h6>
                        </div>
                        <div class="card-tools">
                            <div class="dropdown">
                                <a class="text-soft dropdown-toggle btn btn-sm p-0" data-toggle="dropdown">
                                    <em class="icon ni ni-more-h"></em>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                    <ul class="link-list-plain">
                                        <li><a href="{{ route('warehouse.index') }}">{{ __('Открыть') }}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                        <div class="nk-sale-data">
                            <span class="amount">{{ $warehouse_count }} <em class="icon ni ni-inbox"></em></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card card-bordered">
                <div class="card-inner">
                    <div class="card-title-group align-start mb-2">
                        <div class="card-title">
                            <h6 class="title">{{ __('Персонажей') }}</h6>
                        </div>
                    </div>
                    <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                        <div class="nk-sale-data">
                            <span class="amount mt-1">{{ $characters_count }} <em class="icon ni ni-users"></em></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>