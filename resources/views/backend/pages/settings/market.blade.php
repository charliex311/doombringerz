@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки торговой площадки') . '.')

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Tabs -->
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="tab">
                                                @foreach(getlangs() as $key => $value)
                                                    @if($loop->index == 0)
                                                        <a class="tablinks active" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                                    @else
                                                        <a class="tablinks" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab content -->
                                    @foreach(getlangs() as $key => $value)
                                        @if($loop->index == 0)
                                            <div id="{{ $key }}" class="tabcontent" style="display: block">
                                                @else
                                                    <div id="{{ $key }}" class="tabcontent">
                                                        @endif

                                                        <div class="row g-4">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="market_memo_desc_{{ $key }}">{{ __('Памятка на Торговой площадке') }} ({{ $key }})</label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea type="text" class="form-control" id="market_memo_desc_{{ $key }}" name="setting_market_memo_desc_{{ $key }}">{{ config('options.market_memo_desc_' . $key, '') }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="market_info_{{ $key }}">{{ __('Информация на Торговой площадке') }} ({{ $key }})</label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea type="text" class="form-control" id="market_info_{{ $key }}" name="setting_market_info_{{ $key }}">{{ config('options.market_info_' . $key, '') }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    @endforeach

                                                    <div class="row g-4">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="market_seller_commission">{{ __('Комиссия с продавца на Торговой площадке') }}</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="vk_link" name="setting_market_seller_commission"
                                                                           value="{{ config('options.market_seller_commission', '5') }}">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label class="form-label" for="market_status">{{ __('Состояние') }}</label>
                                                                <div class="form-control-wrap">
                                                                    <select id="market_status" name="setting_market_status" class="form-select">
                                                                        <option value="0" @if (config('options.market_status') !== NULL && config('options.market_status') === '0') selected @endif>{{ __('Выключить') }}</option>
                                                                        <option value="1" @if (config('options.market_status') !== NULL && config('options.market_status') === '1') selected @endif>{{ __('Включить') }}</option>
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
