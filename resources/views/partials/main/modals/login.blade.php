@push('head')
    @error('recaptcha_v3')
    @else
        {!! RecaptchaV3::initJs() !!}
        @enderror
@endpush
<div class="modal modal_login" id="login">
    <div class="modal__container">
        <div class="modal__body">
            <div class="modal__close">
                <svg>
                    <use href="img/sprite/sprite.svg#close-icon"></use>
                </svg>
            </div>
            <div>
                <div class="modal__grid">
                <form action="{{ route('login') }}" method="POST" id="loginForm">
                    @csrf

                    <div class="modal__grid-item">
                        <h1 class="modal__heading">
                            {{ __('Авторизация') }}
                        </h1>

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

                        <div class="modal__inputs">
                            <div class="modal__input">
                                <input type="text" name="email" id="login-email" placeholder="{{ __('Имя Аккаунта или Email') }}">
                                <div class="invalid-feedback hide" id="login-email-err">
                                    {{ __('Поле Имя Аккаунта является обязательным') }}
                                </div>
                            </div>
                            <div class="modal__input">
                                <input type="password" name="password" id="login-password" placeholder="{{ __('Пароль') }}">
                                <div class="invalid-feedback hide" id="login-password-err">
                                    {{ __('Поле Пароль является обязательным') }}
                                </div>
                            </div>
                        </div>
                        <div class="modal__remember">
                            <div class="modal__check tracker__check">
                                <input type="checkbox" name="remember">
                                <label for="remember">{{ __('Запомнить меня. Не рекомендуется на общих компьютерах') }}</label>
                            </div>
                        </div>
                        @error('recaptcha_v3')
                            <div id="form_login" class="mb-2"></div>
                        @else
                            {!! RecaptchaV3::field('login', 'recaptcha_v3') !!}
                        @enderror
                        <a class="modal__btn btn loginSubmit">
                            <span>{{ __('Войти ') }}</span>
                        </a>
                        <a href="{{ route('password.request') }}" class="modal__forgot">
                            {{ __('Забыли пароль?') }}
                        </a>
                    </div>
                </form>
                    <div class="modal__grid-item">
                        <div class="modal__alternative">
                            {{ __('Или войдите с помощью одного из этих сервисов') }}
                        </div>
                        <div class="modal__options">

                            <form action="{{ route('loginDiscord') }}" method="POST" id="login_discord">
                                @csrf
                                <input type="hidden" name="f_token">
                                <button class="modal__platform modal__platform_discord">
                                    <img src="img/sprite/discord-icon.svg" alt="fb-icon">
                                    <span>{{ __('Войти с') }} Discord</span>
                                </button>
                            </form>

                            <form action="{{ route('loginGoogle') }}" method="POST" id="login_google">
                                @csrf
                                <input type="hidden" name="f_token">
                                <button class="modal__platform modal__platform_google">
                                    <img src="img/sprite/google-icon.svg" alt="fb-icon">
                                    <span>{{ __('Войти с') }} Google</span>
                                </button>
                            </form>

                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>
</div>