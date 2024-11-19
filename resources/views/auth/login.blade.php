@extends('layouts.auth')
@section('title', __('Авторизация'))

@push('head')
    @error('recaptcha_v3')
    @else
    {!! RecaptchaV3::initJs() !!}
    @enderror
@endpush

@push('scripts')

    @error('recaptcha_v3')
        {!!  GoogleReCaptchaV2::render('form_login') !!}
    @enderror
@endpush


@section('form')

                            {{-- Alert --}}
                            @foreach (['danger', 'warning', 'success', 'info'] as $type)
                                @if(Session::has('alert.' . $type))
                                    @foreach(Session::get('alert.' . $type) as $message)
                                        <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon">
                                            @if ($type === 'danger')
                                                <em class="icon ni ni-cross-circle"></em>
                                            @elseif($type === 'success')
                                                <em class="icon ni ni-check-circle"></em>
                                            @else
                                                <em class="icon ni ni-alert-circle"></em>
                                            @endif
                                            {{ $message }}
                                            <button class="close" data-dismiss="alert"></button>
                                        </div>
                                    @endforeach
                                @endif
                            @endforeach
                            {{-- End Alert --}}


                            <div class="col-sm-12 tabs">
                                <ul class="nav nav-tabs">
                                    <li class=""><a href="#tab-email" data-toggle="tab" aria-expanded="true" class="active"><em class="icon ni ni-email"></em>Email</a></li>
                                    @if (config('options.sms') !== NULL && config('options.sms') === "1" && config('options.sms_api_key') !== NULL && config('options.sms_api_key') !== "")
                                        <li class=""><a href="#tab-mobile" data-toggle="tab" aria-expanded="false"><em class="icon ni ni-phone"></em>{{ __('Мобильный') }}</a></li>
                                    @endif
                                </ul>

                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab-email">

                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf
					        <div class="form-group" style="text-align: center;">
					                <span>{{ __('Используйте') }} demo@wizardcp.com / demopassword {{ __('чтобы войти') }}</span>
					        </div>

                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="email">E-Mail</label>
                                                </div>
                                                <input type="text" class="form-control form-control-lg"
                                                       id="email" name="email" placeholder="{{ __('Введите E-Mail') }}" value="{{ old('email') }}">
                                            </div>
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="password">{{ __('Пароль') }}</label>
                                                    <a class="link link-primary link-sm" tabindex="-1" href="{{ route('password.request') }}">{{ __('Забыли пароль?') }}</a>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control form-control-lg"
                                                           id="password" name="password" placeholder="{{ __('Введите пароль') }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-control-xs custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                    <label class="custom-control-label" for="remember">{{ __('Запомнить меня?') }}</label>
                                                </div>
                                            </div>
                                            @error('recaptcha_v3')
                                            <div id="form_login" class="mb-2"></div>
                                            @else
                                                {!! RecaptchaV3::field('login', 'recaptcha_v3') !!}
                                                @enderror
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Войти') }}</button>
                                                </div>
                                        </form>

                                    </div>


                                    @if (config('options.sms') !== NULL && config('options.sms') === "1" && config('options.sms_api_key') !== NULL && config('options.sms_api_key') !== "")

                                    <div class="tab-pane" id="tab-mobile">

                                        <form action="{{ route('login') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="phone">{{ __('Телефон') }}</label>
                                                </div>
                                                <input type="tel" class="form-control form-control-lg"
                                                       id="phone" name="phone" placeholder="{{ __('Введите номер телефона без +') }}" value="{{ old('phone') }}">
                                            </div>
                                            <div class="form-group">
                                                <div class="form-label-group">
                                                    <label class="form-label" for="password">{{ __('Пароль') }}</label>
                                                    <a class="link link-primary link-sm" tabindex="-1" href="{{ route('password.request') }}">{{ __('Забыли пароль?') }}</a>
                                                </div>
                                                <div class="form-control-wrap">
                                                    <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch" data-target="password2">
                                                        <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                                        <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                                    </a>
                                                    <input type="password" class="form-control form-control-lg"
                                                           id="password2" name="password" placeholder="{{ __('Введите пароль') }}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-control-xs custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                                                    <label class="custom-control-label" for="remember">{{ __('Запомнить меня?') }}</label>
                                                </div>
                                            </div>
                                            @error('recaptcha_v3')
                                            <div id="form_login" class="mb-2"></div>
                                            @else
                                                {!! RecaptchaV3::field('login', 'recaptcha_v3') !!}
                                                @enderror
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-lg btn-primary btn-block">{{ __('Войти') }}</button>
                                                </div>
                                        </form>

                                    </div>

                                    @endif

                                </div>
                            </div>


    <div class="form-note-s2 pt-4">
        {{ __('Нет аккаунта?') }} <a href="{{ route('register') }}">{{ __('Зарегистрироваться') }}</a>
    </div>
@endsection
