@extends('layouts.cabinet')
@section('title', __('Рефералы'))

@push('head')
    <link rel="stylesheet" href="/css/box.css?ver=1.11">
@endpush

@section('wrap')

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Рефералы') }}</span>
                            </h5>
                            <div class="card-title__info btn-help">
                                <img src="/img/info-icon.svg" alt="info-icon">
                                <span class="referral-help">{{ __('Помощь') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">

                        </div>
                    </div>
                    <div class="card-inner">
                        <div class="box">
                            <div class="box-container">
                                <div class="box-progress">
                                    <div class="box-progress__inner">
                                        <div class="box-progress__row">
                                            <div class="box-progress__user">
                                                <div class="box-user">
                                                    <span class="box-user__fill"
                                                          style="--fill-width: {{ intval(getReferralCurrentLvl($referral->total) / 10 * 100) }}%">

                                                    </span>
                                                    <div class="box-user__icon">
                                                        <img src="/img/referral/user-icon.webp" alt="user-icon">
                                                    </div>
                                                </div>
                                                <div class="box-progress__user-level">
                                                    <span class="box-progress__user-level-value">
                                                        {{ getReferralCurrentLvl($referral->total) }} {{ __('Уровень') }}
                                                    </span>
                                                </div>
                                            </div>

                                            <ul class="box-drops">

                                                @foreach(getReferralLvls() as $lvl => $count)

                                                    @if(getReferralCurrentLvl($referral->total) >= $lvl)

                                                        <li class="box-drops__item @if(getReferralCurrentLvl($referral->total) == $lvl){{ 'box-drops__item--current' }}@else{{ 'box-drops__item--opened' }}@endif">
                                                            <div class="box-drops__item-icon">
                                                                <img src="/img/drop/drop-icon-{{ $lvl }}.png" alt="drop-icon">
                                                                <div class="box-drops__item-state box-drops__item-state--opened">
                                                                    <img src="/img/check-icon.svg" alt="check-icon">
                                                                </div>
                                                            </div>
                                                            <div class="box-drops__item-level">
                                                                <span class="box-drops__item-level-value">{{ $lvl }} {{ __('Уровень') }}</span>
                                                            </div>
                                                        </li>

                                                    @else

                                                        <li class="box-drops__item box-drops__item--locked">
                                                            <div class="box-drops__item-icon">
                                                                <img src="/img/drop/drop-icon-{{ $lvl }}.png" alt="drop-icon">
                                                                <div class="box-drops__item-state box-drops__item-state--opened">
                                                                    <img src="/img/check-icon.svg" alt="check-icon">
                                                                </div>
                                                                <div class="box-drops__item-state box-drops__item-state--locked">
                                                                    <img src="/img/lock-icon.svg" alt="lock-icon">
                                                                </div>
                                                            </div>
                                                            <div class="box-drops__item-level">
                                                                <span class="box-drops__item-level-value">{{ $lvl }} {{ __('Уровень') }}</span>
                                                            </div>
                                                        </li>
                                                    @endif

                                                    <li class="box-drops__line"></li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-actions">
                                    <div class="box-actions__input">
                                        <input class="text-upper" type="text" value="{{ $referral->code }}" disabled>
                                        <span class="ref-status">{{ ($referral->status === 1) ? __('Активно: дайте новым участникам этот реферальный код для повышения уровня и получения потрясающих наград!') : __('Приостановлено: ваш реферальный код в настоящее время неактивен! Вы не получите вознаграждения за людей, присоединившихся по вашему приглашению!') }}</span>
                                    </div>
                                    <div class="box-actions__options">
                                        <button class="box-actions__copy btn">
                                            <span class="getcopy" data-code="{{ $referral->code }}">{{ __('Скопировать код') }}</span>
                                        </button>

                                        <button class="box-actions__pause btn-pause @if($referral->status === 0){{ 'hide' }}@endif">
                                            <div class="box-actions__pause-bars">
                                                <span></span>
                                                <span></span>
                                            </div>
                                            <span>{{ __('Пауза') }}</span>
                                        </button>
                                        <button class="box-actions__pause btn-play @if($referral->status !== 0){{ 'hide' }}@endif">
                                            <div class="box-actions__play-bars">
                                                <span></span>
                                            </div>
                                            <span>{{ __('Активировать') }}</span>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-table">
                                    <div class="box-table__col">
                                        <div class="box-table__header">
                                            {{ __('Статистика приглашений') }}
                                        </div>

                                        @foreach($referral->ref_users as $ref_user)
                                            <div class="box-table__row">
                                            <div class="box-table__row-item">
                                                <div class="box-table__user">
                                                    <div class="box-table__user-icon">
                                                        <img src="{{ (isset(getuser($ref_user->user_id)->avatar_url)) ? getuser($ref_user->user_id)->avatar_url : '' }}" alt="user-icon">
                                                    </div>
                                                    <div class="box-table__user-info">
                                                        <div class="box-table__user-name">
                                                            {{ (isset(getuser($ref_user->user_id)->name)) ? getuser($ref_user->user_id)->name : '' }}
                                                        </div>
                                                        <div class="box-table__user-date">
                                                            {{ getmonthname(date('m', strtotime($ref_user->date))) }} {{ date('d', strtotime($ref_user->date)) }}, {{ date('Y', strtotime($ref_user->date)) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-table__row-item">
                                                <div class="box-table__friends">
                                                    <button class="box-table__invite">
                                                        <img src="/img/invite-btn.svg" alt="invite-icon">
                                                    </button>
                                                    <div class="box-table__friends-amount">{{ getReferralCountUsers($ref_user->user_id) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                    <div class="box-table__col">
                                        <h1 class="box-table__header">
                                            {{ __('Таблица лидеров') }}
                                        </h1>

                                        @foreach($leaders as $leader)
                                            <div class="box-table__row">
                                            <div class="box-table__row-item">
                                                <div class="box-table__user">
                                                    <div class="box-table__order">
                                                        @if($loop->first)
                                                            <img src="/img/referral/crown-icon.svg" alt="crow-icon">
                                                        @endif
                                                    </div>
                                                    <div class="box-table__user-icon">
                                                        <img src="{{ (isset(getuser($leader->user_id)->avatar_url)) ? getuser($leader->user_id)->avatar_url : '' }}" alt="user-icon">
                                                    </div>
                                                    <div class="box-table__user-info">
                                                        <div class="box-table__user-name">
                                                            {{ (isset(getuser($leader->user_id)->name)) ? getuser($leader->user_id)->name : '' }}
                                                        </div>
                                                        <div class="box-table__user-date">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="box-table__row-item">
                                                <div class="box-table__friends">
                                                    <button class="box-table__invite">
                                                        <img src="/img/invite-btn.svg" alt="invite-icon">
                                                    </button>
                                                    <div class="box-table__friends-amount">{{ $leader->total }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@prepend('scripts')
    <div class="modal fade zoom" tabindex="-1" id="ReferralHelp" style="opacity:1;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border: 1px solid;">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close" OnClick="$('#ReferralHelp').hide();">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ config('options.referral_title_' . app()->getLocale(), '') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            {!! config('options.referral_description_' . app()->getLocale()) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endprepend

@prepend('scripts')
<script>
    function GetCode() {
        $.ajax({
            type: "POST",
            url: "{{ route('cabinet.referrals.getcode') }}",
            data: { safe: 'yes' },
            headers: { 'X-CSRF-Token': $("input[name=_token]").val() }
        }).done(function( msg ) {
            $('#code').val(msg);
            $('#btn-create').prop("disabled", false);

        });
    }
    function SetStatus(status) {
        $.ajax({
            type: "POST",
            url: "{{ route('cabinet.referrals.status.set') }}",
            data: { status: status },
            headers: { 'X-CSRF-Token': $("input[name=_token]").val() }
        }).done(function( msg ) {
            //
        });
    }
</script>
<script>
    $( document ).ready(function() {
        $('.getcopy').on('click', function() {
            let temp = $("<input>");
            $("body").append(temp);
            let link = '{{ config('app.url', '') }}' + '/ref/' + $(this).data('code');
            temp.val(link).select();
            document.execCommand("copy");
            temp.remove();

            $(this).addClass('is-copied');
            setTimeout(function(){
                $('.getcopy').removeClass('is-copied');
            }, 1000);
        });

        $('.btn-pause').on('click', function() {
            $('.btn-pause').addClass('hide');
            $('.btn-play').removeClass('hide');
            $('.btn-play').removeClass('hide');
            $('.ref-status').text('{{ __('Приостановлено: ваш реферальный код в настоящее время неактивен! Вы не получите вознаграждения за людей, присоединившихся по вашему приглашению!') }}');
            SetStatus(0);
        });
        $('.btn-play').on('click', function() {
            $('.btn-play').addClass('hide');
            $('.btn-pause').removeClass('hide');
            $('.ref-status').text('{{ __('Активно: дайте новым участникам этот реферальный код для повышения уровня и получения потрясающих наград!') }}');
            SetStatus(1);
        });
        $('.btn-help').on('click', function() {
            $('#ReferralHelp').modal('show');
        });
    });
</script>
@endprepend
