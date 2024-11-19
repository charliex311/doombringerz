@extends('backend.layouts.backend')

@section('title', 'Панель управления - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки доната') . '.')

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                    <div class="tab-pane" id="donate">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" name="server" value="0">

                                    <!-- Tabs -->
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="tab">
                                                @foreach(getlangs() as $key => $value)
                                                    <a class="tablinks @if($loop->first) active @endif"
                                                       onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Tab content -->
                                    @foreach(getlangs() as $key => $value)
                                        <div id="{{ $key }}" class="tabcontent" @if($loop->first) style="display: block" @endif>

                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label class="form-label" for="donate_description_{{ $key }}">{{ __('Описание') }} ({{ $key }})</label>
                                                        <div class="form-control-wrap">
                                                        <textarea type="text" class="form-control"
                                                          id="donate_description_{{ $key }}" name="setting_donate_description_{{ $key }}">{{ config('options.server_'.$server_id.'_donate_description_' . $key, '') }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    <div class="row g-4">

                                        {{--
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="server">{{ __('Игровой сервер') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="server" name="server" class="form-select @error('server') is-invalid @enderror">
                                                        <option value="0">{{ __('Личный кабинет') }}</option>
                                                        @foreach(getservers() as $server)
                                                            <option value="{{ $server->id }}" @if($server_id == $server->id) selected @endif>{{ $server->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        --}}

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="coin_name">{{ __('Название монеты') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="coin_name"
                                                           name="setting_coin_name" value="{{ config('options.server_'.$server_id.'_coin_name', 'CoL') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="coin_short_name">{{ __('Краткое название монеты') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="coin_short_name"
                                                           name="setting_coin_short_name" value="{{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="coin_price">{{ __('Курс за 1') }} {{ config('options.server_'.$server_id.'_coin_name', 'CoL') }} ({{ __('EUR') }})</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.01" class="form-control" id="coin_price"
                                                           name="setting_coin_price" value="{{ config('options.server_'.$server_id.'_coin_price', 40) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="min_coin_amount">{{ __('Минимальная сумма покупки') }} {{ config('options.server_'.$server_id.'_coin_name', 'CoL') }} ({{ __('EUR') }})</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.01" class="form-control" id="min_coin_amount"
                                                           name="setting_min_coin_amount" value="{{ config('options.server_'.$server_id.'_min_coin_amount', 0) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{--
                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="exchange_rate_brl">{{ __('Курс BRL за 1') }} EUR</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.001" class="form-control" id="exchange_rate_brl"
                                                           name="setting_exchange_rate_brl" value="{{ config('options.server_'.$server_id.'_exchange_rate_brl', 1) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="exchange_rate_rub">{{ __('Курс RUB за 1') }} EUR</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.001" class="form-control" id="exchange_rate_rub"
                                                           name="setting_exchange_rate_rub" value="{{ config('options.server_'.$server_id.'_exchange_rate_rub', 1) }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="exchange_rate_eur">{{ __('Курс EUR за 1') }} EUR</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" step="0.001" class="form-control" id="exchange_rate_eur"
                                                           name="setting_exchange_rate_eur" value="{{ config('options.server_'.$server_id.'_exchange_rate_eur', 1) }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    --}}

                                    <hr>

                                    <div class="row g-4">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="donat_active">{{ __('Состояние') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="donat_active" name="setting_donat_active" class="form-select">
                                                        <option value="0" @if(config('options.server_'.$server_id.'_donat_active', 0) == 0) selected @endif>{{ __('Выключить') }}</option>
                                                        <option value="1" @if(config('options.server_'.$server_id.'_donat_active', 1) == 1) selected @endif>{{ __('Включить') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="donat_date_start">{{ __('Дата начала действия') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="datetime-local" class="form-control" id="donat_date_start"
                                                           name="setting_donat_date_start" value="{{ config('options.server_'.$server_id.'_donat_date_start', '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div class="form-group">
                                                <label class="form-label" for="donat_date_end">{{ __('Дата окончания действия') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="datetime-local" class="form-control" id="donat_date_end"
                                                           name="setting_donat_date_end" value="{{ config('options.server_'.$server_id.'_donat_date_end', '') }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="donat_payments2">{{ __('Действует на платежные системы') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="hidden" name="setting_donat_payments4" value="" />
                                                    <input type="checkbox" class="payment-checkbox" id="donat_payments4" name="setting_donat_payments4" value="4" @if (config('options.server_'.$server_id.'_donat_payments4') !== NULL && config('options.server_'.$server_id.'_donat_payments4') === '4') checked @endif>PayPal
                                                    <input type="hidden" name="setting_donat_payments19" value="" />
                                                    <input type="checkbox" class="payment-checkbox" id="donat_payments19" name="setting_donat_payments19" value="19" @if (config('options.server_'.$server_id.'_donat_payments19') !== NULL && config('options.server_'.$server_id.'_donat_payments19') === '19') checked @endif>Stripe
                                                    <input type="hidden" name="setting_donat_payments46" value="" />
                                                    <input type="checkbox" class="payment-checkbox" id="donat_payments46" name="setting_donat_payments46" value="46" @if (config('options.server_'.$server_id.'_donat_payments46') !== NULL && config('options.server_'.$server_id.'_donat_payments46') === '46') checked @endif>Skrill
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- donat Cols -->

                                    <div class="margin-bottom-50"></div>
                                    <div id="donates">
                                        <div class="g-4 donat" data-donat="" id="donat_" style="display: none;">
                                            <div class="row g-4">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="coin_donat__end">{{ __('От суммы') }} ({{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="coin_donat__start"
                                                               name="setting_coin_donat__start" value="{{ config('options.server_'.$server_id.'_coin_donat__start', 1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="coin_donat__amount">{{ __('До суммы') }}, {{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}</label>

                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="coin_donat__end"
                                                               name="setting_coin_donat__end" value="{{ config('options.server_'.$server_id.'_coin_donat__end', 1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="coin_donat__start">{{ __('Бонус') }}, {{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="coin_donat__amount"
                                                               name="setting_coin_donat__amount" value="{{ config('options.server_'.$server_id.'_coin_donat__amount', 1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group delete-bonus">
                                                    <a class="btn delete" data-donat="donat_" onClick="deletedonat('donat_')">{{ __('Удалить донат') }}</a>
                                                </div>
                                            </div>
                                            </div>
                                            <!-- donat Items -->

                                            <div class="g-4">
                                            <div id="bitems_">

                                                <div class="row g-4 ditem_" data-bitem="" id="bitem_" style="display: none;">

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="coin_bitem__id">{{ __('Предмет') }}  (ID) </label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="coin_bitem__id"
                                                                       name="setting_coin_bitem__id" value="{{ config('options.server_'.$server_id.'_coin_bitem__id', 0) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label class="form-label" for="coin_bitem__name">{{ __('Название предмета') }} </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="coin_bitem__name"
                                                                       name="setting_coin_bitem__name" value="{{ config('options.server_'.$server_id.'_coin_bitem__name', __('Предмет')) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="coin_bitem__quantity">{{ __('Количество') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="coin_bitem__quantity"
                                                                       name="setting_coin_bitem__quantity" value="{{ config('options.server_'.$server_id.'_coin_bitem__quantity', 0) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bitem">
                                                            <a class="btn delete" data-bitem="bitem_" onClick="deleteBitem('bitem_')">{{ __('Удалить предмет') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group add-bitem">
                                                        <a class="btn add" onclick="addBitem('');">{{ __('Добавить предмет') }}</a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        </div>

                                        @for($i=0;$i<100;$i++)
                                            @if (config('options.server_'.$server_id.'_coin_donat_'.$i.'_amount', '') != '')
                                                <input type="hidden" name="setting_coin_donat_{{ $i }}_amount" value="" />
                                                <input type="hidden" name="setting_coin_donat_{{ $i }}_start" value="" />
                                                <input type="hidden" name="setting_coin_donat_{{ $i }}_end" value="" />

                                                <div class="g-4 donat" data-donat="{{ $i }}" id="donat_{{ $i }}">

                                                    <div class="row g-4">
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="coin_donat_{{ $i }}_start">{{ __('От суммы') }}, {{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="coin_donat_{{ $i }}_start"
                                                                       name="setting_coin_donat_{{ $i }}_start" value="{{ config('options.server_'.$server_id.'_coin_donat_'.$i.'_start', 1) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="coin_donat_{{ $i }}_end">{{ __('До суммы') }}, {{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="coin_donat_{{ $i }}_end"
                                                                       name="setting_coin_donat_{{ $i }}_end" value="{{ config('options.server_'.$server_id.'_coin_donat_'.$i.'_end', 1) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="coin_donat_{{ $i }}_amount">{{ __('Бонус') }} {{ $i }}, {{ config('options.server_'.$server_id.'_coin_short_name', 'CoL') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="coin_donat_{{ $i }}_amount"
                                                                       name="setting_coin_donat_{{ $i }}_amount" value="{{ config('options.server_'.$server_id.'_coin_donat_'.$i.'_amount', 1) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bonus">
                                                            <a class="btn delete" data-donat="donat_{{ $i }}" onClick="deletedonat('donat_{{ $i }}')">{{ __('Удалить донат') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                    <!-- donat Items -->

                                        <div class="g-4">
                                            <div id="bitems_{{ $i }}">

                                                <div class="row g-4 ditem_{{ $i }}" data-bitem="" id="bitem_{{ $i }}_"
                                                     style="display: none;">

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="coin_bitem_{{ $i }}__id">{{ __('Предмет') }}
                                                                (ID) </label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control"
                                                                       id="coin_bitem_{{ $i }}__id"
                                                                       name="setting_coin_bitem_{{ $i }}__id"
                                                                       value="{{ config('options.server_'.$server_id.'_coin_bitem_'.$i.'__id', 0) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="coin_bitem_{{ $i }}__name">{{ __('Название предмета') }} </label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control"
                                                                       id="coin_bitem_{{ $i }}__name"
                                                                       name="setting_coin_bitem_{{ $i }}__name"
                                                                       value="{{ config('options.server_'.$server_id.'_coin_bitem_'.$i.'__name', __('Предмет')) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="coin_bitem_{{ $i }}__quantity">{{ __('Количество') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control"
                                                                       id="coin_bitem_{{ $i }}__quantity"
                                                                       name="setting_coin_bitem_{{ $i }}__quantity"
                                                                       value="{{ config('options.server_'.$server_id.'_coin_bitem_'.$i.'__quantity', 0) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bitem">
                                                            <a class="btn delete" data-bitem="bitem_{{ $i }}_"
                                                               onClick="deleteBitem('bitem_{{ $i }}_')">{{ __('Удалить предмет') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                @for($it=0;$it<100;$it++)
                                                    @if (config('options.server_'.$server_id.'_coin_bitem_'.$i.'_'.$it.'_id', '') != '')
                                                        <input type="hidden" name="setting_coin_bitem_{{ $i }}_{{ $it }}_id" value=""/>
                                                        <input type="hidden" name="setting_coin_bitem_{{ $i }}_{{ $it }}_start" value=""/>
                                                        <input type="hidden" name="setting_coin_bitem_{{ $i }}_{{ $it }}_end" value=""/>

                                                        <div class="row g-4 ditem_{{ $i }}" data-bitem="{{ $it }}" id="bitem_{{ $i }}_{{ $it }}">


                                                            <div class="col-lg-3">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                           for="coin_bitem_{{ $i }}_{{ $it }}_id">{{ __('Предмет') }} {{ $it }}
                                                                        (ID)</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" class="form-control"
                                                                               id="coin_bitem_{{ $i }}_{{ $it }}_id"
                                                                               name="setting_coin_bitem_{{ $i }}_{{ $it }}_id"
                                                                               value="{{ config('options.server_'.$server_id.'_coin_bitem_'.$i.'_'.$it.'_id', 1) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                           for="coin_bitem_{{ $i }}_{{ $it }}_name">{{ __('Название предмета') }} </label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control"
                                                                               id="coin_bitem_{{ $i }}_{{ $it }}_name"
                                                                               name="setting_coin_bitem_{{ $i }}_{{ $it }}_name"
                                                                               value="{{ config('options.server_'.$server_id.'_coin_bitem_'.$i.'_'.$it.'_name', __('Предмет')) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group">
                                                                    <label class="form-label"
                                                                           for="coin_bitem_{{ $i }}_{{ $it }}_quantity">{{ __('Количество') }}</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="number" class="form-control"
                                                                               id="coin_bitem_{{ $i }}_{{ $it }}_quantity"
                                                                               name="setting_coin_bitem_{{ $i }}_{{ $it }}_quantity"
                                                                               value="{{ config('options.server_'.$server_id.'_coin_bitem_'.$i.'_'.$it.'_quantity', 1) }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-2">
                                                                <div class="form-group delete-bitem">
                                                                    <a class="btn delete"
                                                                       data-bitem="bitem_{{ $i }}_{{ $it }}"
                                                                       onClick="deleteBitem('bitem_{{ $i }}_{{ $it }}')">{{ __('Удалить предмет') }}</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    @endif
                                                @endfor

                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group add-bitem">
                                                        <a class="btn add"
                                                           onclick="addBitem({{ $i }});">{{ __('Добавить предмет') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                                </div>
                                        @endif
                                        @endfor

                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group add-bonus">
                                                <a class="btn add adddonat">{{ __('Добавить Донат') }}</a>
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


    <script>
        $( document ).ready(function() {

            //donat Cols
            let donat_id = 1;
            let donat_id_next = 1;
            let donat_html = '';
            let sear = '';
            let repl = '';
            $('.adddonat').on('click', function(){
                donat_id = $('.donat:last').data('donat');
                donat_id_next = donat_id + 1;
                donat_id = '';
                sear = new RegExp('donat_' + donat_id, 'g');
                repl = 'donat_' + donat_id_next;
                donat_html = $('#donat_'+donat_id).html().replace(sear,repl);
                sear = new RegExp('bitems_' + donat_id, 'g');
                repl = 'bitems_' + donat_id_next;
                donat_html = donat_html.replace(sear,repl);
                sear = new RegExp('ditem_' + donat_id, 'g');
                repl = 'ditem_' + donat_id_next;
                donat_html = donat_html.replace(sear,repl);
                sear = new RegExp('bitem_' + donat_id, 'g');
                repl = 'bitem_' + donat_id_next + '_';
                donat_html = donat_html.replace(sear,repl);
                sear = "addBitem('"+donat_id+"')";
                repl = "addBitem('"+donat_id_next+"')";
                donat_html = donat_html.replace(sear,repl);
                sear = new RegExp('{{ __("Донат") }} ' + donat_id, 'g');
                donat_html = donat_html.replace(sear,'{{ __("Донат") }} ' + donat_id_next);

                $('#donates').append('<div class="g-4 donat" data-donat="'+donat_id_next+'" id="donat_' + donat_id_next + '">' + donat_html + '</div>');
            });


            $('#server').on('change', function () {
                console.log($('#server').val());
                location.href = "{{ route('settings.donat', '') }}?server=" + $('#server').val();
            })

        });

        //donat Cols
        function deletedonat(donat){
            $('#'+donat).remove();
        }

        //donat Items
        function deleteBitem(bitem){
            $('#'+bitem).remove();
        }

        //donat Items
        function addBitem(donat){
            let bitem_id = 1;
            let bitem_id_next = 1;
            let bitem_html = '';
            let sear2 = '';
            let repl2 = '';
            console.log(donat);
            bitem_id = $('.ditem_'+donat+':last').data('bitem');
            bitem_id_next = bitem_id + 1;
            console.log(bitem_id_next);
            sear2 = new RegExp('bitem_' + donat + '_' + bitem_id, 'g');
            console.log(sear2);
            repl2 = 'bitem_' + donat + '_' + bitem_id_next;
            bitem_html = $('#bitem_'+donat+'_'+bitem_id).html().replace(sear2,repl2);
            sear2 = new RegExp('{{ __("Предмет") }} ' + bitem_id, 'g');
            bitem_html = bitem_html.replace(sear2,'{{ __("Предмет") }} ' + bitem_id_next);
            console.log('#bitems_'+donat);
            $('#bitems_'+donat).append('<div class="row g-4 ditem_'+donat+'" data-bitem="'+bitem_id_next+'" id="bitem_'+donat+'_' + bitem_id_next + '">' + bitem_html + '</div>');
        }
    </script>

@endsection
