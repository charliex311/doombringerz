<div class="col-sm-4">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-title-group align-start mb-2">
                <div class="card-title">
                    <h6 class="title">{{ __('Баланс') }}</h6>
                </div>
                <div class="card-tools">
                    <div class="dropdown">
                        <a class="text-soft dropdown-toggle btn btn-sm p-0" data-toggle="dropdown">
                            <em class="icon ni ni-more-h"></em>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <ul class="link-list-plain">
                                <li><a href="{{ route('donate.transfer') }}"><em class="icon ni ni-coins text-warning"></em> {{ __('Перевести в игру') }}</a></li>
                                <li><a href="{{ route('donate') }}"><em class="icon ni ni-plus-c text-success"></em> {{ __('Пополнить') }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="align-end flex-sm-wrap g-4 flex-md-nowrap">
                <div class="nk-sale-data">
                    <span class="amount text-primary"><em class="icon ni ni-coins"></em> {{ auth()->user()->balance }} {{ config('options.server_'.session('server_id', 1).'_coin_name', 'Coins') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
