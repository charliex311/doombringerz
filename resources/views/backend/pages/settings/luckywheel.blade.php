@extends('backend.layouts.backend')

@section('title', 'Панель управления - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки Колеса удачи') . '.')

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

                                    <div class="row g-4">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lwitems_active">{{ __('Состояние') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="lwitems_active" name="setting_lwitems_active" class="form-select">
                                                        <option value="0" @if(config('options.lwitems_active', 0) == 0) selected @endif>{{ __('Выключить') }}</option>
                                                        <option value="1" @if(config('options.lwitems_active', 1) == 1) selected @endif>{{ __('Включить') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="lwitems_cost">{{ __('Стоимость одной попытки/кручения колеса') }}, {{ config('options.server_0_coin_name', 'CoL') }} </label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="lwitems_cost" name="setting_lwitems_cost"
                                                           value="{{ config('options.lwitems_cost', '1') }}">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="margin-bottom-50"></div>

                                    <div id="lwitems">

                                        <div class="row g-4 lwitem" data-lwitem="" id="lwitem_" style="display: none;">

                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="lwitem__id">{{ __('Призовой предмет') }}  (ID) </label>
                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="lwitem__id"
                                                               name="setting_lwitem__id" value="{{ config('options.lwitem__id', 1) }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="lwitem__name">{{ __('Название предмета') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="lwitem__name"
                                                               name="setting_lwitem__name" value="{{ config('options.lwitem__name', 1) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="lwitem__chance">{{ __('Шанс получить предмет') }} (%)</label>
                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="lwitem__chance"
                                                               name="setting_lwitem__chance" value="{{ config('options.lwitem__chance', 1) }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="lwitem__image" class="form-label">@if(config('options.lwitem__image', '') !== '') {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endif</label>
                                                    @if(config('options.lwitem__image', '') !== '')
                                                        <span>{{ config('options.lwitem__image', '') }}</span>
                                                    @endif
                                                    <div class="form-control-wrap">
                                                        <div class="custom-file">
                                                            <input class="custom-file-input @error('lwitem__image') is-invalid @enderror" id="lwitem__image" name="setting_lwitem__image" type="file" >
                                                            <label class="custom-file-label" for="lwitem__image">{{ __('Изображение') }}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-1">
                                                <div class="form-group delete-lwitem">
                                                    <a class="btn delete" data-lwitem="lwitem_" onClick="deleteLwitem('lwitem_')">{{ __('Удалить') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                        @for($i=0;$i<1000;$i++)
                                            @if (config('options.lwitem_'.$i.'_chance', '') != '')

                                                <input type="hidden" name="setting_lwitem_{{ $i }}_name" value="" />
                                                <input type="hidden" name="setting_lwitem_{{ $i }}_image" value="" />
                                                <input type="hidden" name="setting_lwitem_{{ $i }}_chance" value="" />

                                                <div class="row g-4 lwitem" data-lwitem="{{ $i }}" id="lwitem_{{ $i }}">


                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="lwitem_{{ $i }}_id">{{ __('Призовой предмет') }}  (ID) </label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="lwitem_{{ $i }}_id"
                                                                       name="setting_lwitem_{{ $i }}_id" value="{{ config('options.lwitem_'.$i.'_id', 1) }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="lwitem_{{ $i }}_name">{{ __('Название предмета') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="lwitem_{{ $i }}_name"
                                                                       name="setting_lwitem_{{ $i }}_name" value="{{ config('options.lwitem_'.$i.'_name', 1) }}">
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="lwitem_{{ $i }}_chance">{{ __('Шанс получить предмет') }} (%)</label>

                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="lwitem_{{ $i }}_chance"
                                                                       name="setting_lwitem_{{ $i }}_chance" value="{{ config('options.lwitem_'.$i.'_chance', 1) }}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            @if(config('options.lwitem_'.$i.'_image', '') !== '')
                                                                <input type="hidden" name="setting_lwitem_{{ $i }}_image_old" value="{{ config('options.lwitem_'.$i.'_image', '') }}" />
                                                                <span><img src="/storage/{{ config('options.lwitem_'.$i.'_image', '') }}"/></span>
                                                            @endif
                                                            <label for="lwitem_{{ $i }}_image" class="form-label">@if(config('options.lwitem_'.$i.'_image', '') !== '') {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endif</label>

                                                            <div class="form-control-wrap">
                                                                <div class="custom-file">
                                                                    <input class="custom-file-input @error('lwitem_{{ $i }}_image') is-invalid @enderror" id="lwitem_{{ $i }}_image" name="setting_lwitem_{{ $i }}_image" type="file" >
                                                                    <label class="custom-file-label" for="lwitem_{{ $i }}_image">{{ __('Изображение') }}</label>
                                                                    @error('lwitem_{{ $i }}_image')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-1">
                                                        <div class="form-group delete-lwitem">
                                                            <a class="btn delete" data-lwitem="lwitem_{{ $i }}" onClick="deleteLwitem('lwitem_{{ $i }}')">{{ __('Удалить') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            @endif
                                        @endfor

                                    </div>

                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group add-lwitem">
                                                    <a id="add" class="btn add">{{ __('Добавить предмет') }}</a>
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
            let lwitem_id = 1;
            let lwitem_id_next = 1;
            let lwitem_html = '';
            let sear = '';
            let repl = '';
            $('#add').on('click', function(){

                if ($('.lwitem').length > 12) {
                    alert('{{ __("Максимальное количество предметов не может быть больше 12!") }}');
                } else {

                    lwitem_id = $('.lwitem:last').data('lwitem');
                    lwitem_id_next = lwitem_id + 1;
                    sear = new RegExp('lwitem_' + lwitem_id, 'g');
                    console.log(sear);
                    repl = 'lwitem_' + lwitem_id_next;
                    lwitem_html = $('#lwitem_' + lwitem_id).html().replace(sear, repl);
                    sear = new RegExp('{{ __("Итем") }} ' + lwitem_id, 'g');
                    lwitem_html = lwitem_html.replace(sear, '{{ __("Итем") }} ' + lwitem_id_next);
                    $('#lwitems').append('<div class="row g-4 lwitem" data-lwitem="' + lwitem_id_next + '" id="lwitem_' + lwitem_id_next + '">' + lwitem_html + '</div>');
                }
            });
        });

        function deleteLwitem(lwitem){
            if ($('.lwitem').length < 6) {
                alert('{{ __("Минимальное количество предметов не может быть меньше 4!") }}');
            } else {
                $('#' + lwitem).remove();
            }
        }

    </script>

@endsection
