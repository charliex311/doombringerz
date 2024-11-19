@extends('layouts.cabinet')
@section('title', __('Телефон и Pin код'))

@section('wrap')
    @include('partials.cabinet.settings-menu')

    <link rel="stylesheet" href="/assets/css/intlTelInput.css"/>
    <script src="/assets/js/jquery-2.1.1.min.js"></script>

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Pin код') }}</h5>
                        </div>

                        <div class="col-sm-12 tabs">
                        <ul class="nav nav-tabs">
                            <li class=""><a href="#tab-pin" data-toggle="tab" aria-expanded="false" class="active"><em class="icon ni ni-phone"></em>{{ __('Pin код') }}</a></li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane active" id="tab-pin">

                        <form method="POST" action="{{ route('settings.pin.reset') }}">
                            @csrf

                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <div class="form-message">
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
                </div>
            </div>
        </div>
    </div>

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
@endsection
