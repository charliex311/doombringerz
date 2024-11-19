@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки страницы Welcome.'))

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
                                        <label class="form-label" for="landing_status">{{ __('Статус') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="landing_status" name="setting_landing_status" class="form-select">
                                                <option value="0" @if (config('options.landing_status', '0') == '0') selected @endif>{{ __('Отключено') }}</option>
                                                <option value="1" @if (config('options.landing_status', '0') == '1') selected @endif>{{ __('Включено') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Tabs -->
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="tab">
                                        @foreach(getlangs() as $key => $value)
                                            <a class="tablinks @if($loop->index == 0) active @endif" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Tab content -->
                            @foreach(getlangs() as $key => $value)
                                    <div id="{{ $key }}" class="tabcontent" @if($loop->index == 0) style="display: block" @endif>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="landing_title_{{ $key }}">{{ __('Заголовок') }}
                                                                ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="landing_title_{{ $key }}" name="setting_landing_title_{{ $key }}" value="{{ config('options.landing_title_' . $key, '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="landing_subtitle_{{ $key }}">{{ __('Подзаголовок') }}
                                                                ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="landing_subtitle_{{ $key }}" name="setting_landing_subtitle_{{ $key }}" value="{{ config('options.landing_subtitle_' . $key, '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="landing_about_left_{{ $key }}">{{ __('About') }} {{ __('Левая колонка') }}
                                                                ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control" id="landing_about_left_{{ $key }}" name="setting_landing_about_left_{{ $key }}">{{ config('options.landing_about_left_' . $key, '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label"
                                                                   for="landing_about_right_{{ $key }}">{{ __('About') }} {{ __('Правая колонка') }}
                                                                ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control" id="landing_about_right_{{ $key }}" name="setting_landing_about_right_{{ $key }}">{{ config('options.landing_about_right_' . $key, '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @endforeach

                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="landing_link_home">{{ __('Ссылка') }} Go to Home</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="landing_link_home" name="setting_landing_link_home" value="{{ config('options.landing_link_home', '#') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="landing_link_website">{{ __('Ссылка') }} Go to Website</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="landing_link_website" name="setting_landing_link_website" value="{{ config('options.landing_link_website', '#') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="landing_link_join_discord">{{ __('Ссылка') }} Join our discord</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="landing_link_join_discord" name="setting_landing_link_join_discord" value="{{ config('options.landing_link_join_discord', '#') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="landing_link_join_now">{{ __('Ссылка') }} Join free now</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="landing_link_join_now" name="setting_landing_link_join_now" value="{{ config('options.landing_link_join_now', '#') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="landing_link_youtube_video">{{ __('Ссылка') }} {{ __('Видео YouTube') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="landing_link_youtube_video" name="setting_landing_link_youtube_video" value="{{ config('options.landing_link_youtube_video', '#') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                            <div class="col-items section-title" style="margin-top: 20px; padding-top: 10px;">
                                <hr>
                                <span>{{ __('Особенности') }}</span>
                            </div>

                            <!-- peculiarities -->
                            <div class="col-items">
                                <div class="margin-bottom-50"></div>
                                <div id="peculs">
                                    <div class="g-4 pecul" data-pecul="" id="pecul_" style="display: none;">
                                        <div class="row g-4">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="landing_pecul__title">{{ __('Заголовок') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="landing_pecul__title"
                                                               name="setting_landing_pecul__title" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="landing_pecul__description">{{ __('Описание') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="landing_pecul__description"
                                                               name="setting_landing_pecul__description" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="landing_pecul__link">{{ __('Ссылка') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="landing_pecul__link"
                                                               name="setting_landing_pecul__link" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group">
                                                    <label class="form-label" for="landing_pecul__image">{{ __('Изображение') }}</label>
                                                    <div class="form-control-wrap form-input-file">
                                                        <input type="file" class="custom-file-input" id="landing_pecul__image"
                                                               name="setting_landing_pecul__image" value="">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="form-group delete-bonus">
                                                    <a class="btn delete" data-donat="pecul_" onClick="deletepecul('pecul_')">{{ __('Удалить особенность') }}</a>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    @for($i=0;$i<20;$i++)
                                        @if (config('options.landing_pecul_'.$i.'_title', '') != '')

                                            <input type="hidden" name="setting_landing_pecul_{{ $i }}_title" value="" />
                                            <input type="hidden" name="setting_landing_pecul_{{ $i }}_description" value="" />
                                            <input type="hidden" name="setting_landing_pecul_{{ $i }}_link" value="" />
                                            <input type="hidden" name="setting_landing_pecul_{{ $i }}_image" value="" />

                                            <div class="g-4 pecul" data-pecul="{{ $i }}" id="pecul_{{ $i }}">
                                                <div class="row g-4">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="landing_pecul_{{ $i }}_title">{{ __('Заголовок') }} ({{ $i }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="landing_pecul_{{ $i }}_title"
                                                                       name="setting_landing_pecul_{{ $i }}_title" value="{{ config('options.landing_pecul_'.$i.'_title', '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="landing_pecul_{{ $i }}_description">{{ __('Описание') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="landing_pecul_{{ $i }}_description"
                                                                       name="setting_landing_pecul_{{ $i }}_description" value="{{ config('options.landing_pecul_'.$i.'_description', '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="landing_pecul_{{ $i }}_link">{{ __('Ссылка') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="landing_pecul_{{ $i }}_link"
                                                                       name="setting_landing_pecul_{{ $i }}_link" value="{{ config('options.landing_pecul_'.$i.'_link', '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group">
                                                            <label class="form-label" for="landing_pecul_{{ $i }}_image">@if(config('options.landing_pecul_'.$i.'_image', '') != ''){{ __('Заменить изображение') }} <img style="width: 30px;" src="/storage/{{ config('options.landing_pecul_'.$i.'_image', '') }}"/>@else{{ __('Изображение') }}@endif</label>
                                                            <div class="form-control-wrap form-input-file">
                                                                <input type="file" class="custom-file-input" id="landing_pecul_{{ $i }}_image"
                                                                       name="setting_landing_pecul_{{ $i }}_image" value="{{ config('options.landing_pecul_'.$i.'_image', '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bonus">
                                                            <a class="btn delete" data-donat="pecul_{{ $i }}" onClick="deletepecul('pecul_{{ $i }}')">{{ __('Удалить особенность') }}</a>
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
                                            <a class="btn add addpecul">{{ __('Добавить особенность') }}</a>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{-- end peculiarities --}}

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

@push('scripts')
    <script>
        $(document).ready(function () {

            let pecul_id = 1;
            let pecul_id_next = 1;
            let pecul_html = '';
            let pecul_sear = '';
            let pecul_repl = '';
            $('.addpecul').on('click', function(){
                pecul_id = $('.pecul:last').data('pecul');
                pecul_id_next = pecul_id + 1;
                pecul_id = '';
                pecul_sear = new RegExp('pecul_' + pecul_id, 'g');
                pecul_repl = 'pecul_' + pecul_id_next;
                pecul_html = $('#pecul_'+pecul_id).html().replace(pecul_sear,pecul_repl);
                pecul_sear = new RegExp('{{ __("ID предмета") }} ' + pecul_id, 'g');
                pecul_html = pecul_html.replace(pecul_sear,'{{ __("ID предмета") }} ' + pecul_id_next);

                $('#peculs').append('<div class="g-4 pecul" data-pecul="'+pecul_id_next+'" id="pecul_' + pecul_id_next + '">' + pecul_html + '</div>');
                $('#pecul_'+pecul_id_next+'_sort').val(pecul_id_next);
            });

        });

        function deletepecul(pecul){
            $('#'+pecul).remove();
        }
    </script>
@endpush