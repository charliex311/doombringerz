@extends('layouts.cabinet')
@section('title', __('Настройки профиля'))

@section('wrap')
    @include('partials.cabinet.settings-menu')

    <link rel="stylesheet" href="/assets/css/intlTelInput.css"/>

    <div class="nk-block">

        <div class="row g-gs" id="block-2">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Имя аккаунта') }}</h5>
                        </div>
                        <form method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('Имя') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                   id="name" name="name" value="{{ auth()->user()->name }}" required>
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                @if (config('options.change_email', '0') == '1')
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="email">E-Mail</label>
                                            <div class="form-control-wrap">
                                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                                       id="email" name="email" value="{{ auth()->user()->email }}" required>
                                                @error('email')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary ml-auto"><span>{{ __('Изменить') }}</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-gs" id="block-3">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Изменить пароль') }}</h5>
                        </div>
                        @if(auth()->user()->status_2fa === 1)
                        <form method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row g-4">
                                <div class="col-lg-6">

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

                                </div>
                                <div class="col-lg-6"></div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="new_password">{{ __('Новый пароль') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                                   id="new_password" name="new_password" required>
                                            @error('new_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="new_password_confirmation">{{ __('Повторите новый пароль') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control @error('new_password_confirmation') is-invalid @enderror"
                                                   id="new_password_confirmation" name="new_password_confirmation" required>
                                            @error('new_password_confirmation')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary ml-auto"><span>{{ __('Изменить') }}</span></button>
                                    </div>
                                </div>
                            </div>
                            </form>
                        @else
                            <div class="col-12">
                                <div class="form-group">
                                    <a href="{{ route('settings.profile_2fa') }}" class="btn btn-lg btn-primary ml-auto btn-link-2fa"><span>{{ __('Активировать') }} 2FA</span></a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{--
        <div class="row g-gs" id="block-4">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('PIN аккаунта') }}</h5>
                        </div>

                                    <form method="POST" action="{{ route('settings.pin.reset') }}">
                                        @csrf

                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                            <p>{{ __('Pin код будет сброшен! Новый Pin код придёт на вашу эл. почту или на телефон.') }}</p>
                                                            <p>{{ __('Выберите куда выслать новый Pin код') }}</p>
                                                            <div class="radio-block">
                                                                @if (auth()->user()->email)
                                                                    <div class="radio-input">
                                                                        <input type="radio" id="email"
                                                                               name="method" value="email" checked>
                                                                        <label for="email">Email</label>
                                                                    </div>
                                                                @endif
                                                                @if (auth()->user()->phone)
                                                                    <div class="radio-input">
                                                                        <input type="radio" id="phone"
                                                                               name="method" value="phone"
                                                                               @if (!auth()->user()->email) checked @endif
                                                                        >
                                                                        <label for="phone">{{ __('Телефон') }}</label>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary ml-auto"><span>{{ __('Сбросить') }}</span></button>
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
        --}}

        <div class="row g-gs" id="block-5">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner" style="min-height: 800px;">
                        <div class="card-head flex-column align-items-start">
                            <h5 class="card-title m-0">{{ __('Активные устройства') }}</h5>
                            <div class="nk-block-des">
                                <p>{{ __('При необходимости вы можете выйти из всех других сеансов браузера на всех ваших устройствах. Некоторые из ваших недавних сеансов перечислены ниже; однако этот список может быть не исчерпывающим. Если вы считаете, что ваша учетная запись была скомпрометирована, вам также следует обновить пароль.') }}</p>
                            </div>
                        </div>
                        <table class="table table-ulogs">
                            <thead class="thead-light">
                            <tr>
                                <th class="tb-col-os"><span class="overline-title">{{ __('Браузер') }} <span class="d-sm-none">/ IP</span></span></th>
                                <th class="tb-col-ip"><span class="overline-title">IP</span></th>
                                <th class="tb-col-time"><span class="overline-title">{{ __('Последняя активность') }}</span></th>
                                <th class="tb-col-action"><span class="overline-title">&nbsp;</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td class="tb-col-os">{{ $session->getBrowser() }} {{ __('на') }} {{ $session->getOs() }}</td>
                                    <td class="tb-col-ip"><span class="sub-text">{{ $session->ip_address }}</span></td>
                                    <td class="tb-col-time"><span class="sub-text">{{ date('d.m.Y', $session->last_activity) }} <span class="d-none d-sm-inline-block">{{ date('H:i', $session->last_activity) }}</span></span></td>
                                    <td class="tb-col-action">
                                        @if (session()->getId() !== $session->id)
                                            <a href="{{ route('settings.activity.destroy', $session->id) }}" title="{{ __('Выйти с устройства') }}">
                                                <span class="badge badge-outline-danger">{{ __('Отключить') }}</span>
                                            </a>
                                        @else
                                            <span class="badge badge-outline-success">{{ __('Данное устройство') }}</span>
                                        @endif
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

@endsection
@push('scripts')
    <script src="/assets/js/intlTelInput.min.js"></script>
    <script> document.addEventListener("DOMContentLoaded", function (event) {
            let input = document.querySelector("#phone");
            let iti = window.intlTelInput(input, {
                initialCountry: "ru",
                nationalMode: false,
                placeholderNumberType: "MOBILE",
                preferredCountries: ["ru", "ua", "by", "md", "kz", "uz", "az", "pl", "am", "ge", "bg", "be", "tj", "kg", "lt", "lv", "ee", "ro", "tm", "ch", "de"],
                separateDialCode: true,
                utilsScript: "/assets/js/utils.js",
            });
            $('#phone_code').val(iti.getSelectedCountryData().dialCode);
            $('.separate-dial-code').on('click', '.selected-flag, .country', function () {
                $('#phone_code').val(iti.getSelectedCountryData().dialCode);
            });
            $('.send-sms').on('click', function (e) {

                e.preventDefault();
                let phone_code = $("input[name=phone_code]").val();
                let phone = phone_code+$("input[name=phone]").val().replace(/\D/g, '');

                console.log(phone);

                $("input[name=phone]").removeClass('error');
                if (phone.length < 10) {
                    $("input[name=phone]").addClass('error');
                    return false;
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('settings.sendcode') }}",
                    data: { phone: phone },
                    headers: { 'X-CSRF-Token': $("input[name=_token]").val() }
                }).done(function( msg ) {

                    let time = '{{ config("options.sms_timer", "60") }}';
                    if (msg.indexOf('error_timer') !== -1) {
                        time = msg.replace('error_timer=', '');
                        console.log( time );
                    }

                    $('.send-sms').text('{{ __("SMS код отправлен!") }}');
                    $(".send-sms").prop('disabled',true);
                    $('.seconds').text(time);
                    $(".send-sms-msg").show();
                    Timer(time);
                });

            });
        });
    </script>

    <script>
        function Timer(seconds) {
            console.log(seconds);
            var _Seconds = seconds,
                int;
            int = setInterval(function() {
                if (_Seconds > 0) {
                    _Seconds--;
                    $('.seconds').text(_Seconds);
                } else {
                    clearInterval(int);
                    $(".send-sms-msg").hide();
                    $('.send-sms').text('{{ __("Получить SMS код") }}');
                    $(".send-sms").prop('disabled',false);
                }
            }, 1000);
        }
    </script>


    <script>
        $(document).ready(function() {
            $(".scroll-link").on("click", function(e) {
                e.preventDefault();

                $(".scroll-link").removeClass('active');
                $(this).addClass('active');

                let targetId = $(this).data("target");
                let targetBlock = $("#block-" + targetId);

                if (targetBlock.length > 0) {
                    $("html, body").animate({
                        scrollTop: targetBlock.offset().top
                    }, 1000);
                }

                let targetHref = $(this).attr("href");
                console.log(window.location.pathname);
                if (window.location.pathname !== targetHref) {
                    window.location.href = targetHref;
                }
            });

            // Проверяем, есть ли URL-параметр для прокрутки к блоку
            if (window.location.hash) {
                var targetBlockId = window.location.hash.substring(1); // Удаляем "#" из хеша
                var targetBlock = $("#" + targetBlockId);

                if (targetBlock.length > 0) {
                    $("html, body").animate({
                        scrollTop: targetBlock.offset().top
                    }, 1000); // Прокрутка за 1 секунду (можете изменить значение)
                }
            }
        });
    </script>
@endpush
