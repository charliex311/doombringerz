@extends('layouts.main')

@section('title', __('Создать запрос') . ' - ' . config('options.main_title_'.app()->getLocale(), ''))

@section('content')

    <div class="sparks-wrapper">
        <picture>
            <source type="image/webp" srcset="/img/bottom-sparks.webp">
            <img src="/img/bottom-sparks.png" alt="sparks">
        </picture>
    </div>

    <main class="main-padding news-body" style="background-image: url(/img/bug-tracker/bug-tracker-bg.webp);">

        <div class="top-wrapper">
            <div class="wrapper-form">

                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    <input type="hidden" name="subcategory_id" id="subcategory_id" value="-1">

                    <div class="form__wrapper bug__box">
                        <div class="form__inner">
                            <div class="form__heading">
                                <div class="form__head">
                                    {{ __('Создать отчет') }}
                                </div>
                                {!! config('options.reports_create_description_'.app()->getLocale()) !!}
                            </div>
                            <div class="form__inputs">
                                <div class="form__inputs-item">
                                    <input type="text" class="form-control form-control-lg"
                                           id="title" name="title" placeholder="{{ __('Заголовок') }}"
                                           value="{{ old('title') }}" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form__inputs-item">
                                    <div class="custom-select">
                                        <select name="server" id="server" class="form-control white-grey bs-select-hidden" required>
                                            <option class="disabled" value="-1" selected="">{{ __('Выберите игровой мир') }}</option>
                                            @foreach(getservers() as $server)
                                                <option value="{{ $server->id }}" @if(app('request')->input('server') == $server->id) selected @endif>{{ $server->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form__inputs-item">
                                    <div class="custom-select">
                                        <select name="category_id" id="category_id" class="form-control selectpicker white-grey bs-select-hidden" required>
                                            <option class="disabled" value="-1" selected="">{{ __('Выберите категорию') }}</option>
                                            @foreach(getListCategoryName() as $key => $value)
                                                <option value="{{ $key }}" @if(app('request')->input('category_id') == $key) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form__inputs-item">

                                        <div class="custom-select" id="select-subcategory_id_1" style="display: none;">
                                            <select id="subcategory_id_1" name="subcategory_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                                @foreach(getListClassesName() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="custom-select" id="select-subcategory_id_2" style="display: none;">
                                            <select id="subcategory_id_2" name="subcategory_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                                @foreach(getListExploitsName() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="custom-select" id="select-subcategory_id_3" style="display: none;">
                                            <select id="subcategory_id_3" name="subcategory_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                                @foreach(getListInstancesName() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="custom-select" id="select-subcategory_id_4" style="display: none;">
                                            <select id="subcategory_id_4" name="subcategory_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                                @foreach(getListOtherName() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="custom-select" id="select-subcategory_id_5" style="display: none;">
                                            <select id="subcategory_id_5" name="subcategory_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                                @foreach(getListProfessionsName() as $key => $value)
                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                </div>
                                <div class="form__inputs-item">
                                    <textarea id="question" name="question" placeholder="{{ __("Опишите здесь, в чем суть проблемы. Пожалуйста, подробно объясните проблему.") }}" required></textarea>
                                </div>

                                <div class="form__inputs-item">
                                    <span>{{ __('Репликация') }}:</span>
                                    <p>{{ __("Пожалуйста, предоставьте подробное описание вашей проблемы и, если возможно, добавьте шаги по воспроизведению проблемы для наших разработчиков.") }}</p>
                                </div>

                                <div id="steps">
                                    <div class="form__inputs-item step" data-id="1">
                                        <input type="text" name="step[]" class="step-input" placeholder="{{ __('Шаг') }} 1">
                                    </div>
                                    <div class="form__inputs-item step" data-id="2">
                                        <input type="text" name="step[]" class="step-input" placeholder="{{ __('Шаг') }} 2">
                                    </div>
                                </div>

                                <span class="form__add add-step">
                                    <span>
                                      <img src="/img/sprite/plus-icon.svg" alt="plus-icon">
                                    </span>
                                    {{ __('Добавить новый шаг') }}
                                </span>
                                <div class="form__inputs-item">
                                    <span>{{ __('Ожидаемый результат') }}:</span>
                                    <textarea id="expected_result" name="expected_result" placeholder="{{ __("Пожалуйста, расскажите, что ожидается, а не то, что у нас есть в настоящее время в игре.") }}" required style="margin-top: 15px;"></textarea>
                                    @error('expected_result')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form__inputs-item">
                                    <textarea id="comment" name="comment" placeholder="{{ __("Пожалуйста, напишите здесь ваш комментарий.") }}"></textarea>
                                    @error('comment')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form__inputs-item form__inputs-item--file">
                                    <label class="form__dd-file" for="upload">
                                        <img src="/img/sprite/paperclip-icon.svg" class="form__inputs-paper" alt="paperclip-icon">
                                        <span class="form__dd-file-drop">{{ __('Перетащите файлы сюда') }}</span>
                                        <span class="form__dd-file-max">{{ __('Максимальный размер файла 20МБ') }}</span>
                                        <span class="form__dd-file-max bug-alert-text">{{ __('Для изображений Вы можете использовать imgur.com, а для видео — YouTube') }}</span>
                                        <input type="file" id="upload" name="attachment" accept="image/*, video/*">
                                    </label>
                                </div>
                            </div>
                            <div class="form__agreement tracker__check">
                                <input id="closed-requests" type="checkbox" name="ok" required>
                                <label for="closed-requests">
                                    {!! config('options.reports_consent_description_'.app()->getLocale()) !!}
                                </label>
                            </div>
                            <div class="form__buttons tracker__buttons">
                                <a href="{{ route('reports') }}" class="tracker__reset">
                                    <span>{{ __('Отменить') }}</span>
                                </a>
                                <button class="tracker__create btn">
                                    <span>{{ __('Создать отчет') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>

        @include('partials.main.offer')

    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#category_id').click(function() {
                if ($('#category_id').val() == '3') { //Классы
                    $('#select-subcategory_id_2').hide();
                    $('#select-subcategory_id_3').hide();
                    $('#select-subcategory_id_4').hide();
                    $('#select-subcategory_id_5').hide();
                    $('#select-subcategory_id_1').show();
                } else if ($('#category_id').val() == '5') { //EXPLOITS
                    $('#select-subcategory_id_1').hide();
                    $('#select-subcategory_id_3').hide();
                    $('#select-subcategory_id_4').hide();
                    $('#select-subcategory_id_5').hide();
                    $('#select-subcategory_id_2').show();
                } else if ($('#category_id').val() == '6') { //Instances
                    $('#select-subcategory_id_1').hide();
                    $('#select-subcategory_id_2').hide();
                    $('#select-subcategory_id_4').hide();
                    $('#select-subcategory_id_5').hide();
                    $('#select-subcategory_id_3').show();
                } else if ($('#category_id').val() == '8') { //Other
                    $('#select-subcategory_id_1').hide();
                    $('#select-subcategory_id_2').hide();
                    $('#select-subcategory_id_3').hide();
                    $('#select-subcategory_id_5').hide();
                    $('#select-subcategory_id_4').show();
                } else if ($('#category_id').val() == '9') { //Professions
                    $('#select-subcategory_id_1').hide();
                    $('#select-subcategory_id_2').hide();
                    $('#select-subcategory_id_3').hide();
                    $('#select-subcategory_id_4').hide();
                    $('#select-subcategory_id_5').show();
                } else {
                    $('#select-subcategory_id_1').hide();
                    $('#select-subcategory_id_2').hide();
                    $('#select-subcategory_id_3').hide();
                    $('#select-subcategory_id_4').hide();
                    $('#select-subcategory_id_5').hide();
                }
                if ($('#category_id').val() == '11') { //Сайт
                    $('#select-realm_id').hide();
                } else {
                    $('#select-realm_id').show();
                }

            });

            $('.add-step').click(function () {
                let index = 1;
                let index_next = 1;
                let steps = $('.step');
                steps.each(function (i) {
                    index = i + 1;
                    index_next = index + 1;
                    $(this).attr('data-id', index);
                    $(this).find('.step-input').attr('placeholder', '{{ __('Шаг') }} '+index);
                });
                let html = '<div class="form__inputs-item step" data-id="'+index_next+'"><input type="text" name="step[]" class="step-input" placeholder="{{ __('Шаг') }} '+index_next+'"><button class="form__clear delete-step"><span></span><span></span></button></div>';
                $('#steps').append(html);
            });
            $(document).on("click",".delete-step",function() {
                if ($('.step').length > 1) {
                    $(this).parent().remove();

                    let index = 1;
                    let index_next = 1;
                    let steps = $('.step');
                    steps.each(function (i) {
                        index = i + 1;
                        index_next = index + 1;
                        $(this).attr('data-id', index);
                        $(this).find('.step-input').attr('placeholder', '{{ __('Шаг') }} '+index);
                    });
                }
            });
        });

        function CreateReport() {
            let error = false;

            $('#select-subcategory_id_1 .select-selected').removeClass('report-error');
            $('#select-subcategory_id_2 .select-selected').removeClass('report-error');
            $('#select-subcategory_id_3 .select-selected').removeClass('report-error');
            $('#select-subcategory_id_4 .select-selected').removeClass('report-error');
            $('#select-subcategory_id_5 .select-selected').removeClass('report-error');
            $('#select-priority .select-selected').removeClass('report-error');
            $('#select-category_id .select-selected').removeClass('report-error');
            $('#title').removeClass('report-error');

            if ($('#title').val() == '') {
                $('#title').addClass('report-error');
                error = true;
            }

            if ($('#select-subcategory_id_1').is(':visible')) {
                if ($('#subcategory_id_1').val() < 1) {
                    $('#select-subcategory_id_1 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_1').val());
            } else if ($('#select-subcategory_id_2').is(':visible')) {
                if ($('#subcategory_id_2').val() < 1) {
                    $('#select-subcategory_id_2 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_2').val());
            } else if ($('#select-subcategory_id_3').is(':visible')) {
                if ($('#subcategory_id_3').val() < 1) {
                    $('#select-subcategory_id_3 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_3').val());
            } else if ($('#select-subcategory_id_4').is(':visible')) {
                if ($('#subcategory_id_4').val() < 1) {
                    $('#select-subcategory_id_4 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_4').val());
            } else if ($('#select-subcategory_id_5').is(':visible')) {
                if ($('#subcategory_id_5').val() < 1) {
                    $('#select-subcategory_id_5 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_5').val());
            }

            $('#subcategory_id').val($('#subcategory_id_1').val());

            if ($('#priority').val() < 1) {
                $('#select-priority .select-selected').addClass('report-error');
                error = true;
            }
            if ($('#category_id').val() < 1) {
                $('#select-category_id .select-selected').addClass('report-error');
                error = true;
            }

            if (error === true) {
                $("html, body").animate({scrollTop:0},"slow");
                return false;
            }

            console.log($('#subcategory_id').val());
        }
    </script>
@endpush
