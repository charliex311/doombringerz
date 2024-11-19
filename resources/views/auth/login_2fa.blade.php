@extends('layouts.auth')
@section('title', __('Двухфакторная Авторизация'))

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

    <form action="{{ route('user.login_2fa.auth') }}" method="POST">
        @csrf
        <div class="form-group">
            <div class="form-control-wrap" style="text-align: left;">
                <label class="form-label" for="code_2fa">{{ __('Одноразовый код авторизации') }}</label>
                <input type="password" class="form-control form-control-lg"
                       id="code_2fa" name="code_2fa" placeholder="{{ __('Введите код') }}">
                @error('code_2fa')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>
        <div class="form-group" style="text-align: left;">
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

@endsection
