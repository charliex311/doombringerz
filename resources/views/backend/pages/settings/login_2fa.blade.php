@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки 2FA') . ".")

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                        <div class="row g-4">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="ga_key">{{ __('Ключ безопасности Google Authenticator') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="ga_key" name="setting_ga_key"
                                                               value="{{ config('options.ga_key', 'np57kf8rpwp3e4w9qwm8') }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="ga_status">{{ __('Состояние') }}</label>
                                                    <div class="form-control-wrap">
                                                        <select id="ga_status" name="setting_ga_status" class="form-select">
                                                            <option value="0"
                                                                    @if(config('options.ga_status', '0') == '0') selected @endif>{{ __('Отключено') }}</option>
                                                            <option value="1"
                                                                    @if(config('options.ga_status', '1') == '1') selected @endif>{{ __('Включено') }}</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label" for="code_2fa">{{ __('Отсканируйте QR код в приложении Google Authenticator и введите полученный код') }}</label>
                                                    <div class="form-label-group" style="flex-direction: column;">
                                                        {!! $qrcode !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="ga_users_status">{{ __('Состояние') }} 2FA {{ __('для пользователей') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="ga_users_status" name="setting_ga_users_status" class="form-select">
                                                        <option value="0"
                                                                @if(config('options.ga_users_status', '0') == '0') selected @endif>{{ __('Отключено') }}</option>
                                                        <option value="1"
                                                                @if(config('options.ga_users_status', '0') == '1') selected @endif>{{ __('Включено') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary ml-auto">{{ __('Отправить') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    </div>
                </div>

    <!-- .nk-block -->
@endsection
