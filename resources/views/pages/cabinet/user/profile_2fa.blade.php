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
                            <h5 class="card-title">{{ __('Двухфакторная Авторизация') }}</h5>
                        </div>

                        @if(config('options.ga_users_status', '0') == '1')

                            <div class="row g-gs">
                                <div class="col-6">
                            @if(auth()->user()->status_2fa == '0')
                                <button id="btn-2fa" class="btn btn-lg btn-primary ml-auto"><span>{{ __('Активировать') }} 2FA</span></button>
                            @endif

                            <div id="group-2fa" class="content-group" style="@if(auth()->user()->status_2fa == '0')display: none; @endif justify-content: flex-start;">

                                @if(auth()->user()->status_2fa == '0')
                                    <div class="table c-content setting-content">

                                        <label class="form-label" for="phone">{{ __('Активировать') }} 2FA</label>
                                        <div class="form">
                                            <form action="{{ route('settings.profile_2fa.set') }}" method="POST">
                                                @csrf
                                                <input type="text" class="form-control form-control-lg"
                                                       id="code_2fa" name="code_2fa" placeholder="{{ __('Код доступа') }}" value="" style="margin-bottom: 20px;">
                                                @error('code_2fa')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror

                                                <button class="btn btn-lg btn-primary ml-auto"><span>{{ __('Активировать') }}</span></button>
                                            </form>
                                        </div>
                                    </div>

                                @else
                                    <div class="table c-content setting-content" style="text-align: center;margin-top: 40px;">
                                        <h6 style="color: #4afb02;text-align: center;">{{ __('2FA уже активировано!') }}</h6>
                                    </div>
                                @endif

                                <div class="table c-content setting-content" style="text-align: center;margin-top: 40px;">

                                    <h6 style="color: white;text-align: center;">{{ __('Отсканируйте QR код в приложении Google Authenticator и введите полученный код') }}</h6>
                                    <div class="form">
                                        <div id="qrcode_2fa" class="form-label-group" style="flex-direction: column;">
                                            {!! $qrcode !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#btn-2fa').click(function() {

                $.ajax({
                    type: "POST",
                    url: "{{ route('settings.get2FACode') }}",
                    data: { user: {{ auth()->user()->id }} },
                    headers: { 'X-CSRF-Token': $("input[name=_token]").val() }
                }).done(function( msg ) {
                    console.log( msg );

                    $('#btn-2fa').hide();
                    $('#qrcode_2fa').html(msg);
                    $('#group-2fa').show();

                });

            });

        });
    </script>
@endpush
