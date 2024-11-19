@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки') . " Discord.")

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
                                                <label class="form-label" for="discord_api_client_id">Client ID</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="discord_api_client_id" name="setting_discord_api_client_id"
                                                           value="{{ config('options.discord_api_client_id', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discord_api_client_secret">Client Secret</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="discord_api_client_secret" name="setting_discord_api_client_secret"
                                                           value="{{ config('options.discord_api_client_secret', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discord_api_redirect">Redirect url</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="discord_api_redirect" name="setting_discord_api_redirect"
                                                           value="{{ config('options.discord_api_redirect', '') }}">
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
