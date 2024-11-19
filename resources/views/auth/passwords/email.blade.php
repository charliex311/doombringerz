@extends('layouts.auth')
@section('title', __('Reset Password'))

@section('form')

    @if(session('status'))
        <div class="alert alert-fill alert-success alert-icon" role="alert">
            <em class="icon ni ni-check-circle"></em>
            <strong>{{ session('status') }}</strong>
        </div>
    @endif

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

        <div class="tab-content">
            <div class="tab-pane active" id="tab-email">

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="form-group">
                        <input id="name" type="name"
                               class="form-control form-control-lg @error('name') is-invalid @enderror" name="name"
                               value="{{ old('name') }}" required autocomplete="name" placeholder="{{ __('Введите Имя Аккаунта') }}">
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="email" type="email"
                               class="form-control form-control-lg @error('email') is-invalid @enderror" name="email"
                               value="{{ old('email') }}" required autocomplete="email"
                               placeholder="{{ __('Введите E-Mail') }}" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit"
                                class="btn btn-lg btn-primary btn-block"><span>{{ __('Отправить ссылку сброса пароля') }}</span></button>
                    </div>
                </form>
            </div>


            <div class="form-note-s2 pt-4 support-block">
                <span>{{ __('Не помните свое имя Аккаунта и email?') }}</span>
                <span>{{ __('Свяжитесь со службой поддержки') }} <a href="mailto:support@hellreach.loc" target="_blank">support@hellreach.loc</a> {{ __('или') }} <a href="https://discord.gg/#" target="_blank"><strong>Discord</strong></a></span>
            </div>

        </div>
    </div>

@endsection
