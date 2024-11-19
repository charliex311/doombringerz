<div class="modal modal_register" id="register">
    <div class="modal__container">
        <div class="modal__body">
            <div class="modal__close">
                <svg>
                    <use href="img/sprite/sprite.svg#close-icon"></use>
                </svg>
            </div>
            <div>

                <form action="{{ route('register') }}" method="POST" class="modal__inner" id="registerForm">
                    @csrf

                    <div class="modal__heading">
                        {{ __('Регистрация') }}
                    </div>

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
                        <div class="modal__input @error('name') is-invalid @enderror">
                            <input type="text" name="name" id="register-name" placeholder="{{ __('Имя Аккаунта') }}" value="{{ old('name') }}">
                            <div class="invalid-feedback hide" id="register-name-err">
                                {{ __('Поле Имя Аккаунта является обязательным') }}
                            </div>
                            @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="modal__input @error('email') is-invalid @enderror">
                            <input type="email" name="email" id="register-email" placeholder="E-mail" value="{{ old('email') }}">
                            <div class="invalid-feedback hide" id="register-email-err">
                                {{ __('Поле E-mail является обязательным') }}
                            </div>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="modal__input @error('password') is-invalid @enderror">
                            <input type="password" name="password" id="register-password" placeholder="{{ __('Пароль') }}">
                            <div class="invalid-feedback hide" id="register-password-err">
                                {{ __('Поле Пароль является обязательным') }}
                            </div>
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="modal__input @error('password_confirmation') is-invalid @enderror">
                            <input type="password" name="password_confirmation" id="register-password_confirmation" placeholder="{{ __('Повторите пароль') }}">
                            <div class="invalid-feedback hide" id="register-password_confirmation-err">
                                {{ __('Поле Повторите пароль является обязательным') }}
                            </div>
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal__terms">
                            <div class="modal__check tracker__check register-ok">
                                <input type="checkbox" name="ok" name="register-ok" id="register-ok" value="1" class="@error('ok') is-invalid @enderror">
                                <label for="ok">{{ __('Я согласен с') }} <a tabindex="-1" href="{{ route('terms') }}" target="_blank">{{ __('пользовательским соглашением') }}</a></label>
                            </div>
                    </div>
                    <div class="invalid-feedback register-ok hide" id="register-ok-err">
                        {{ __('Вам нужно согласиться с пользовательским соглашением') }}
                    </div>
                    @error('ok')
                    <div class="invalid-feedback register-ok">
                        {{ $message }}
                    </div>
                    @enderror
                    <div class="modal__terms reg-disclaimer">
                        {{ strip_tags(config('options.reg_disclaimer_description_'.app()->getLocale())) }}
                    </div>
                    <a class="modal__btn btn registerSubmit">
                        <span>{{ __('Создать аккаунт') }}</span>
                    </a>
                </form>

            </div>
        </div>
    </div>
</div>
