@php
    if(isset($server)) {
        $options = json_decode($server->options);
    }
@endphp

@extends('backend.layouts.backend')

@isset($server)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать игровой сервер'))
    @section('headerDesc', __('Редактирование игрового сервера ') . $server->name . '.')
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить игровой сервер'))
    @section('headerDesc', __('Добавление игрового сервера.'))
@endisset

@section('headerTitle', __('Игровой сервер'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($server){{ route('servers.update', $server) }}@else{{ route('servers.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($server)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="name">{{ __('Название') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="name" name="name"
                                                   @isset($server->name) value="{{ $server->name }}" @else value="{{ old('title') }}" @endisset required>
                                            @error('title')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">{{ __('Статус') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="status" name="status" class="form-select">
                                                <option value="0" @if (isset($server->status) && $server->status == '0') selected @endif>{{ __('Скрыть') }}</option>
                                                <option value="1" @if (isset($server->status) && $server->status == '1') selected @endif>{{ __('Отобразить') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="ip">{{ __('Адрес подключения IP:PORT') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="ip" name="ip"
                                                   @isset($options->ip) value="{{ $options->ip }}" @else value="" @endisset required>
                                            @error('ip')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="wowword_db_type">{{ __('Тип ИБД') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="wowword_db_type" name="wowword_db_type" class="form-select">
                                                <option value="1" @if (isset($options->wowword_db_type) && $options->wowword_db_type == '1') selected @endif>{{ __('Тип') }} 1</option>
                                            </select>
                                            @error('wowword_db_type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="soap_uri">{{ __('Тип сервера') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="soap_uri" name="soap_uri" class="form-select">
                                                <option value="urn:TC" @if (isset($options->soap_uri) && $options->soap_uri === 'urn:TC') selected @endif>TrinityCore</option>
                                            </select>
                                            @error('soap_uri')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="soap_login">SOAP {{ __('логин') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="soap_login" name="soap_login"
                                                   @isset($options->soap_login) value="{{ $options->soap_login }}" @else value="" @endisset required>
                                            @error('soap_login')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                    <div class="col-lg-6">
                                        <div class="form-group">
                                        <label class="form-label" for="soap_password">SOAP {{ __('пароль') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="soap_password" name="soap_password"
                                                   @isset($options->soap_password) value="{{ $options->soap_password }}" @else value="" @endisset required>
                                            @error('soap_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        </div>
                                    </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="soap_style">{{ __('Тип') }} SOAP</label>
                                                <div class="form-control-wrap">
                                                    <select id="soap_style" name="soap_style" class="form-select">
                                                        <option value="SOAP_RPC" @if (isset($options->soap_style) && $options->soap_style === 'SOAP_RPC') selected @endif>SOAP_RPC</option>
                                                    </select>
                                                    @error('soap_style')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>


                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="wowdb_host">WOWDB_HOST</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowdb_host" name="wowdb_host"
                                                   @isset($options->wowdb_host) value="{{ $options->wowdb_host }}" @else value="" @endisset required>
                                            @error('wowdb_host')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowdb_port">WOWDB_PORT</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowdb_port" name="wowdb_port"
                                                   @isset($options->wowdb_port) value="{{ $options->wowdb_port }}" @else value="" @endisset required>
                                            @error('wowdb_port')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowdb_database">WOWDB_DATABASE</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowdb_database" name="wowdb_database"
                                                   @isset($options->wowdb_database) value="{{ $options->wowdb_database }}" @else value="" @endisset required>
                                            @error('wowdb_database')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowdb_username">WOWDB_USERNAME</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowdb_username" name="wowdb_username"
                                                   @isset($options->wowdb_username) value="{{ $options->wowdb_username }}" @else value="" @endisset required>
                                            @error('wowdb_username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowdb_password">WOWDB_PASSWORD</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" id="wowdb_password" name="wowdb_password"
                                                   @isset($options->wowdb_password) value="********" @else value="" @endisset required>
                                            @error('wowdb_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="wowworld_host">WOWWORLD_HOST</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowworld_host" name="wowworld_host"
                                                   @isset($options->wowworld_host) value="{{ $options->wowworld_host }}" @else value="" @endisset required>
                                            @error('wowworld_host')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowworld_port">WOWWORLD_PORT</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowworld_port" name="wowworld_port"
                                                   @isset($options->wowworld_port) value="{{ $options->wowworld_port }}" @else value="" @endisset required>
                                            @error('wowworld_port')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowworld_database">WOWWORLD_DATABASE</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowworld_database" name="wowworld_database"
                                                   @isset($options->wowworld_database) value="{{ $options->wowworld_database }}" @else value="" @endisset required>
                                            @error('wowworld_database')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowworld_username">WOWWORLD_USERNAME</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wowworld_username" name="wowworld_username"
                                                   @isset($options->wowworld_username) value="{{ $options->wowworld_username }}" @else value="" @endisset required>
                                            @error('wowworld_username')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>

                                        <label class="form-label" for="wowworld_password">WOWWORLD_PASSWORD</label>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control" id="wowworld_password" name="wowworld_password"
                                                   @isset($options->wowworld_password) value="********" @else value="" @endisset required>
                                            @error('wowworld_password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
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
