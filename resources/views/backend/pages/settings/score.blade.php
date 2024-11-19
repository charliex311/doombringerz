@extends('backend.layouts.backend')

@section('title', 'Панель управления - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки магазина') . '.')

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
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="coin_name">{{ __('Игровой сервер') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="server" name="server" class="form-select @error('server') is-invalid @enderror">
                                                        @foreach(getservers() as $server)
                                                            <option value="{{ $server->id }}">{{ $server->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="shop_name_price">{{ __('Стоимость смены имени') }}, {{ config('options.server_'.session('server_id', 1).'_coin_name', 'Coins') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="shop_name_price"
                                                           name="setting_shop_name_price" value="{{ config('options.shop_name_price', 1) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="shop_name_color_price">{{ __('Стоимость смены цвета имени') }}, {{ config('options.server_'.session('server_id', 1).'_coin_name', 'Coins') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="shop_name_color_price"
                                                           name="setting_shop_name_color_price" value="{{ config('options.shop_name_color_price', 1) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="shop_title_color_price">{{ __('Стоимость смены цвета титула') }}, {{ config('options.server_'.session('server_id', 1).'_coin_name', 'Coins') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="shop_title_color_price"
                                                           name="setting_shop_title_color_price" value="{{ config('options.shop_title_color_price', 1) }}">
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
        </div>
    <!-- .nk-block -->
@endsection
