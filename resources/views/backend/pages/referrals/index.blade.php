@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Рефералы'))
@section('headerTitle', __('Рефералы'))
@section('headerDesc', __('Рефералы') . ".")

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-tools">
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search"
                                               value="{{ request()->query('search') }}"
                                               placeholder="{{ __('Поиск') }}...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">

                            @isset($referrals)
                            @foreach($referrals as $referral)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <a href="{{ route('referrals.show', $referral) }}">
                                    <span class="tb-lead">
                                        {{ $referral->code }}
                                    </span>
                                    </a>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        {{ $referral->note }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @if ($referral->status == 1) <span class="green">{{ __('Активный') }}</span> @else <span class="red">{{ __('Не активный') }}</span> @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        {{ $referral->total }} {{ config('options.server_0_coin_name', 'CoL') }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $referral->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <a class="btn btn-sm btn-icon btn-trigger getcopy" data-code="{{ $referral->code }}" title="{{ __('Скопировать ссылку') }}">
                                        <em class="icon ni ni-copy ml-1"></em>
                                    </a>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('referrals.show', $referral) }}">{{ __('Информация') }}</a></li>
                                                <form action="{{ route('referrals.destroy', $referral) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <li><a href="#" class="text-danger" onclick="this.closest('form').submit();return false;">{{ __('Удалить') }}</a></li>
                                                </form>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                                @endisset


                        </div>
                    </div>
                    <div class="card-inner">
                        {{ '' }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection

@prepend('scripts')
<script>
    $( document ).ready(function() {
        $('.getcopy').on('click', function() {

            let temp = $("<input>");
            $("body").append(temp);
            let link = '{{ config('app.url', '') }}' + 'ref/' + $(this).data('code');
            console.log(link);
            temp.val(link).select();
            document.execCommand("copy");
            temp.remove();

            $(this).addClass('is-copied');
            setTimeout(function(){
                $('.getcopy').removeClass('is-copied');
            }, 1000);
        });
    });
</script>
@endprepend