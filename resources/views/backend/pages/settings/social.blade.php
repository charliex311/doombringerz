@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки Социальных виджетов') . ".")

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
                                                <label class="form-label" for="instagram_link">{{ __('Ссылка Instagram') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="instagram_link" name="setting_instagram_link"
                                                           value="{{ config('options.instagram_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="facebook_link">{{ __('Ссылка Facebook') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="facebook_link" name="setting_facebook_link"
                                                           value="{{ config('options.facebook_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="discord_link">{{ __('Ссылка Discord') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="discord_link" name="setting_discord_link"
                                                           value="{{ config('options.discord_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="tg_link">{{ __('Ссылка Telegram') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="tg_link" name="setting_tg_link"
                                                           value="{{ config('options.tg_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="yt_link">{{ __('Ссылка YouTube') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="yt_link" name="setting_yt_link"
                                                           value="{{ config('options.yt_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="discord_widget">{{ __('Код виджета Discord') }}</label>
                                                <div class="form-control-wrap">
                                            <textarea type="text" class="form-control"
                                                      id="discord_widget" name="setting_discord_widget">{{ config('options.discord_widget') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="telegram_widget">{{ __('Код виджета Telegram') }}</label>
                                                <div class="form-control-wrap">
                                            <textarea type="text" class="form-control"
                                                      id="telegram_widget" name="setting_telegram_widget">{{ config('options.telegram_widget') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="vk_widget">{{ __('Код виджета VK') }}</label>
                                                <div class="form-control-wrap">
                                            <textarea type="text" class="form-control"
                                                      id="vk_widget" name="setting_vk_widget">{{ config('options.vk_widget') }}</textarea>
                                                </div>
                                            </div>
                                        </div>


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
