@extends('backend.layouts.auth')
@section('title', __('Вход в панель управления'))

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

    <form action="{{ route('backend.login') }}" method="POST">
        @csrf

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

@endsection
