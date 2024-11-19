@extends('layouts.cabinet')
@section('title', __('Личный кабинет'))

@section('wrap')

    @if(!auth()->user()->hasVerifiedEmail())
        <div class="alert alert-warning">
            <div class="alert-cta flex-wrap flex-md-nowrap">
                <div class="alert-text">
                    <p>{{ __('Вы не подтвердили Ваш E-Mail адрес.') }}</p>
                </div>
                <ul class="alert-actions gx-3 mt-3 mb-1 my-md-0">
                    <li class="order-md-last">
                        <a href="{{ route('verification.notice') }}" class="btn btn-sm btn-warning"><span>{{ __('Подтвердить') }}</span></a>
                    </li>
                </ul>
            </div>

        </div>
    @endif

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
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Статус Аккаунта') }}</span></span>
                            </h5>
                        </div>
                    </div>

                    <div class="card-inner border-top">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <div class="user-card flex-row align-items-start">
                                        <div class="user-icon">
                                            <img src="{{ auth()->user()->avatar_url }}" alt="user-icon">
                                        </div>
                                        <div class="user-profile">
                                            <p><span class="bold">{{ __('Имя пользователя') }}:</span> {{ auth()->user()->name }} (ID: {{ auth()->user()->id }})</p>
                                            <p><span class="bold">{{ __('Ранг') }}:</span> {{ __('Игрок') }}</p>
                                            <p>
                                                <span class="bold">{{ __('Статус') }}:</span> @if(auth()->user()->ban !== NULL)<span class="red">{{ __('Забанен') }}</span>@else<span class="green">{{ __('Активный') }}</span>@endif
                                                @if(auth()->user()->ban !== NULL)
                                                    (<span>{{ __('Причина') }}: "{{ auth()->user()->ban_reason }}"</span> <span>{{ __('выдан') }}: {{ getuser(auth()->user()->ban_set)->name }}</span>.
                                                    <span>{{ __('Окончание') }}: {{ date('d.m.Y', strtotime(auth()->user()->ban)) }}</span>)
                                                @endif
                                            </p>
                                            <p><span class="bold">{{ __('Дата регистрации') }}:</span> {{ auth()->user()->created_at->format('d.m.Y') }}</p>
                                            <p><span class="bold">{{ __('Последний вход') }}:</span> {{ $last_login }}</p>
                                            <p><span class="bold">{{ __('Игровое время') }}:</span> {{ format_seconds($characters_play_time) }}</p>
                                            <p><span class="bold">{{ __('Персонажей') }}:</span> {{ $characters_count }}</p>
                                            <p><span class="bold">{{ __('Количество рефераллов') }}:</span> 5 (<a href="https://hellreach.org/">g45gg65eu56jhfgjh7ikgf</a>) </p>
                                            <p><span class="bold">{{ __('Свободное вращение колеса') }}:</span> {{ $free_spin ? __('Да') : __('Нет') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <table class="table table-ulogs" style="font-family: Nunito, sans-serif;">
                                    <h6 class="card-title" style="text-align: center;">
                                        <span class="mr-2">{{ __('Recent Logs') }}</span></span>
                                    </h6>
                                    <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td class="tb-col-os" style="padding-left: 2px;">{{ $log->created_at }}</td>
                                            <td class="tb-col-ip"><span class="sub-text">{{ $log->message }}</span></td>
                                            <td class="tb-col-time"><span class="sub-text">{{ $log->ip }}</span></td>
                                            <td class="tb-col-action" style="padding-right: 0px;">
                                                <span class="activity-type-{{ $log->type }}">{{ getlogtype($log->type) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-ulist is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Персонаж') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Раса') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Класс') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Уровень') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Пол') }}</span></div>
                                <div class="nk-tb-col tb-col-xl"><span class="sub-text">{{ __('Игровое время') }}</span></div>
                                <div class="nk-tb-col tb-col-xl"><span class="sub-text">{{ __('Последний вход') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                            </div>
                            <!-- .nk-tb-item -->
                            @if($characters)
                                @forelse($characters as $character)
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <div class="user-name"> <span class="tb-lead">{{ $character->name }}</span> </div>
                                        </div>
                                        <div class="nk-tb-col tb-col-md"> <span>{{ getReportRacesNameById($character->race) }}</span> </div>
                                        <div class="nk-tb-col tb-col-md"> <span>{{ getReportClassesNameById($character->class) }}</span> </div>
                                        <div class="nk-tb-col tb-col-md"> <span>{{ $character->level }}</span> </div>
                                        <div class="nk-tb-col tb-col-sm"> <span>{{ $character->gender === 1 ? __('Женский') : __('Мужской') }}</span> </div>
                                        <div class="nk-tb-col tb-col-xl">
                                            <ul class="list-status">
                                                <li>
                                                    <em class="icon text-gray ni ni-clock"></em>
                                                    <span>{{ format_seconds($character->totaltime) }}</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="nk-tb-col tb-col-xl"> <span>{{ date('d/m/Y H:i', $character->logout_time) }}</span> </div>
                                        <div class="nk-tb-col">
                                            @if ($character->online)
                                                <span class="tb-status text-success">{{ __('Онлайн') }}</span>
                                            @else
                                                <span class="tb-status text-danger">{{ __('Оффлайн') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col text-center">
                                            {{ __('У Вас пока нет персонажей') }}.
                                        </div>
                                        <div class="nk-tb-col tb-col-md">  </div>
                                        <div class="nk-tb-col tb-col-sm">  </div>
                                        <div class="nk-tb-col tb-col-md">  </div>
                                        <div class="nk-tb-col tb-col-xl">  </div>
                                        <div class="nk-tb-col tb-col-xl">  </div>
                                        <div class="nk-tb-col tb-col-xl">  </div>
                                        <div class="nk-tb-col tb-col-xl">  </div>
                                    </div>
                                @endforelse

                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@prepend('scripts')

    <div class="modal fade zoom" tabindex="-1" id="changePasswordAccount">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Изменить пароль аккаунта') }}</h5>
                </div>
                <form method="POST" action="{{ route('account.change.password') }}">
                    @csrf
                    <input type="hidden" id="changePasswordLogin" name="login">
                    <div class="modal-body">

                        @if (config('options.pin') !== NULL && config('options.pin') === "1")

                            <div class="form-group">
                                <label class="form-label" for="pin">{{ __('Pin код') }}</label>
                                <div class="form-control-wrap">
                                    <input type="password" class="form-control @error('pin') is-invalid @enderror" id="pin" name="pin">
                                    @error('pin')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        @else

                            <div class="form-group">
                                <label class="form-label" for="password">{{ __('Текущий пароль') }}</label>
                                <div class="form-control-wrap">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                        @endif

                        <div class="form-group">
                            <label class="form-label" for="new_password">{{ __('Новый пароль') }} <small style="display: block;font-size: 11px;">({{ __('используйте латинские буквы и введите не менее 6 символов и не более 20') }})</small></label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" name="new_password">
                                @error('new_password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="new_password_confirmation">{{ __('Подтвердите новый пароль') }}</label>
                            <div class="form-control-wrap">
                                <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                       id="new_password_confirmation" name="new_password_confirmation">
                                @error('new_password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="form-control-wrap" style="font-size:12px;text-align:right;color:red;cursor:pointer;">
				<a OnClick="$('#resetPasswordAccount').show();">{{ __('Я забыл пароль и хочу его сбросить') }}!</a>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Изменить') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade zoom" tabindex="-1" id="resetPasswordAccount" style="opacity:1;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border: 1px solid;">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close" OnClick="$('#resetPasswordAccount').hide();">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Сбросить пароль аккаунта') }}</h5>
                </div>
                <form method="POST" action="{{ route('account.reset.password') }}">
                    @csrf
                    <input type="hidden" id="resetPasswordLogin" name="login">
                    <div class="modal-body">

                        <div class="form-group">
                            <div class="form-control-wrap">
				<p>{{ __('Пароль будет сброшен! Новый пароль придёт на вашу эл. почту') }}.</p>
				<p>{{ __('Вы уверены?') }}</p>
                            </div>
                        </div>


                        <div class="form-group">
                    	    <div class="modal-footer bg-light">
                       	      <button type="submit" class="btn btn-lg btn-primary">{{ __('Сбросить') }}</button>
                      	      <button type="cancel" class="btn btn-lg btn-primary" OnClick="$('#resetPasswordAccount').hide();">{{ __('Отменить') }}</button>
	                    </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endprepend
@push('scripts')
    <script>
        $(document).ready(function () {

            @if ($down_reg !== false)
                window.open("{{ route('download.registrationData') }}", "Download");
            @endif

            $('[data-change-password]').on('click', function () {
                $('#changePasswordLogin').val($(this).data('change-password'));
                $('#resetPasswordLogin').val($(this).data('change-password'));
                $('#changePasswordAccount').modal('show');
                return false;
            });

            $('.account-tab').on('click', function () {
                let target = $(this).data('target');
                $('.account').removeClass('show').addClass('d-none');
                $(target).removeClass('d-none').addClass('show');
                $('.account-tab').parent().removeClass('active');
                $(this).parent().addClass('active');
                return false;
            });
        });
    </script>
@endpush
