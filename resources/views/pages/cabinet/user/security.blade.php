@extends('layouts.cabinet')
@section('title', __('Настройки безопасности'))

@section('wrap')
    @include('partials.cabinet.settings-menu')

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">{{ __('Изменить пароль') }}</h5>
                        </div>
                        <form method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="row g-4">
                                <div class="col-lg-6">

                                    @if (config('options.pin') !== NULL && config('options.pin') === "1")

                                        <div class="form-group">
                                            <label class="form-label" for="pin">{{ __('PIN код') }}</label>
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

                                </div>
                                <div class="col-lg-6">
                                </div>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
