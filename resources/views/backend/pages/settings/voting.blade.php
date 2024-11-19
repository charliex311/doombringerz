@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки Голосования') . '.')

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                    <div class="tab-pane" id="shop">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row g-4">
                                        <div class="payments-title" style="margin-top: 30px;">{{ __('Награда за 1 голос') }}</div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_item_id">{{ __('ID предмета') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="voting_item_id"
                                                           name="setting_voting_item_id" value="{{ config('options.voting_item_id', '1') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_item_amount">{{ __('Количество') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="voting_item_amount"
                                                           name="setting_voting_item_amount" value="{{ config('options.voting_item_amount', '1') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="payments-title" style="margin-top: 30px;">{{ __('Награда за голосование на всех площадках') }}</div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_finish_item_id">{{ __('ID предмета') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="voting_finish_item_id"
                                                           name="setting_voting_finish_item_id" value="{{ config('options.voting_finish_item_id', '1') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_finish_item_amount">{{ __('Количество') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="voting_finish_item_amount"
                                                           name="setting_voting_finish_item_amount" value="{{ config('options.voting_finish_item_amount', '1') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="payments-title" style="margin-top: 30px;">{{ __('Ссылки на Площадки голосования') }}</div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mmotop_link">{{ __('Ссылка') }} MMOTOP.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="mmotop_link" name="setting_mmotop_link"
                                                           value="{{ config('options.mmotop_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="hopezone_link">{{ __('Ссылка') }} HOPEZONE.NET</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="hopezone_link" name="setting_hopezone_link"
                                                           value="{{ config('options.hopezone_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="wowservers_link">{{ __('Ссылка') }} WOW-SERVERS.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="wowservers_link" name="setting_wowservers_link"
                                                           value="{{ config('options.wowservers_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="mcmonitoring_link">{{ __('Ссылка') }} MC-MONITORING.INFO</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="mcmonitoring_link" name="setting_mcmonitoring_link"
                                                           value="{{ config('options.mcmonitoring_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="topmmogames_link">{{ __('Ссылка') }} TOP-MMOGAMES.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="topmmogames_link" name="setting_topmmogames_link"
                                                           value="{{ config('options.topmmogames_link', '#') }}">
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="row g-4">
                                        <div class="payments-title" style="margin-top: 30px;">{{ __('Ссылки на API Площадок голосования') }}</div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_mmotop_link">{{ __('Ссылка') }} MMOTOP</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_mmotop_link" name="setting_voting_mmotop_link"
                                                           value="{{ config('options.voting_mmotop_link', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_mmotop_apikey">{{ __('API ключ') }} MMOTOP</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_mmotop_apikey" name="setting_voting_mmotop_apikey"
                                                           value="{{ config('options.voting_mmotop_apikey', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_hopezone_link">{{ __('Ссылка') }} HOPEZONE</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_hopezone_link" name="setting_voting_hopezone_link"
                                                           value="{{ config('options.voting_hopezone_link', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_hopezone_apikey">{{ __('API ключ') }} HOPEZONE</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_hopezone_apikey" name="setting_voting_hopezone_apikey"
                                                           value="{{ config('options.voting_hopezone_apikey', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_wowservers_link">{{ __('Ссылка') }} WOW-SERVERS.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_wowservers_link" name="setting_voting_wowservers_link"
                                                           value="{{ config('options.voting_wowservers_link', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_wowservers_apikey">{{ __('API ключ') }} WOW-SERVERS.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_wowservers_apikey" name="setting_voting_wowservers_apikey"
                                                           value="{{ config('options.voting_wowservers_apikey', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_mcmonitoring_link">{{ __('Ссылка') }} MC-MONITORING.INFO</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_mcmonitoring_link" name="setting_voting_mcmonitoring_link"
                                                           value="{{ config('options.voting_mcmonitoring_link', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_mcmonitoring_apikey">{{ __('API ключ') }} MC-MONITORING.INFO</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_mcmonitoring_apikey" name="setting_voting_mcmonitoring_apikey"
                                                           value="{{ config('options.voting_mcmonitoring_apikey', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_topmmogames_link">{{ __('Ссылка') }} TOP-MMOGAMES.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_topmmogames_link" name="setting_voting_topmmogames_link"
                                                           value="{{ config('options.voting_topmmogames_link', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="voting_topmmogames_apikey">{{ __('API ключ') }} TOP-MMOGAMES.RU</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="voting_topmmogames_apikey" name="setting_voting_topmmogames_apikey"
                                                           value="{{ config('options.voting_topmmogames_apikey', '') }}">
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
        </div>
    <!-- .nk-block -->
@endsection
