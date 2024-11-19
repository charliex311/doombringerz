@extends('backend.layouts.backend')

@section('title', 'Панель управления - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки аукциона') . '.')

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                    <div class="tab-pane" id="auction">
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
                                                <label class="form-label" for="auction_hours">{{ __('Длительность аукциона') }} (часов)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="auction_hours"
                                                           name="setting_auction_hours" value="{{ config('options.auction_hours', 12) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="auction_percent">{{ __('Комиссия аукциона') }} (%)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" class="form-control" id="auction_percent"
                                                           name="setting_auction_percent" value="{{ config('options.auction_percent', 15) }}">
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
