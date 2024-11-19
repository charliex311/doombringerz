@extends('backend.layouts.backend')

@isset($report)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать сообщение'))
    @section('headerDesc', __('Редактирование сообщения.'))
@endisset

@section('headerTitle', __('Баг трекер'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="{{ route('backend.reports.update', $report) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="realm_id" value="1">
                            <input type="hidden" name="subcategory_id" id="subcategory_id" value="-1">


                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="title">{{ __('Заголовок') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="title" name="title"
                                                   value="{{ $report->title }}">
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="priority">{{ __('Выберите приоритет') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="priority" name="priority" class="form-select">
                                                @foreach(getListPriorityName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->priority == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('priority')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="char_id">{{ __('Выберите персонажа') . ' (' . __('не обязательно') .')' }}</label>
                                        <div class="form-control-wrap">
                                            <select id="char_id" name="char_id" class="form-select">
                                                @if(count($characters) == 0)
                                                    <option value="0">{{ __('Нет персонажей') }}</option>
                                                @endif
                                                    @foreach($characters as $character)
                                                        <option value="{{ $character->guid }}" @if($report->char_id == $key) selected @endif>{{ $character->name }}</option>
                                                    @endforeach
                                            </select>
                                            @error('char_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">{{ __('Выберите категорию') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="category_id" name="category_id" class="form-select">
                                                @foreach(getListCategoryName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->category_id == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group" id="subcategory_id_1_group" style="display: none;">
                                        <label class="form-label" for="subcategory_id_1">{{ __('Выберите подкатегорию') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="subcategory_id_1" class="form-select">
                                                <option class="disabled" value="-1" selected=""></option>
                                                @foreach(getListClassesName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->subcategory_id == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('subcategory_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" id="subcategory_id_2_group" style="display: none;">
                                        <label class="form-label" for="subcategory_id_2">{{ __('Выберите подкатегорию') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="subcategory_id_2" class="form-select">
                                                <option class="disabled" value="-1" selected=""></option>
                                                @foreach(getListExploitsName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->subcategory_id == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('subcategory_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" id="subcategory_id_3_group" style="display: none;">
                                        <label class="form-label" for="subcategory_id_3">{{ __('Выберите подкатегорию') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="subcategory_id_3" class="form-select">
                                                <option class="disabled" value="-1" selected=""></option>
                                                @foreach(getListInstancesName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->subcategory_id == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('subcategory_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" id="subcategory_id_4_group" style="display: none;">
                                        <label class="form-label" for="subcategory_id_4">{{ __('Выберите подкатегорию') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="subcategory_id_4" class="form-select">
                                                <option class="disabled" value="-1" selected=""></option>
                                                @foreach(getListOtherName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->subcategory_id == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('subcategory_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group" id="subcategory_id_5_group" style="display: none;">
                                        <label class="form-label" for="subcategory_id_5">{{ __('Выберите подкатегорию') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="subcategory_id_5" class="form-select">
                                                <option class="disabled" value="-1" selected=""></option>
                                                @foreach(getListProfessionsName() as $key => $value)
                                                    <option value="{{ $key }}" @if($report->subcategory_id == $key) selected @endif>{{ $value }}</option>
                                                @endforeach
                                            </select>
                                            @error('subcategory_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>


                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="comment">{{ __('ID задания / НИП / предмета / достижения') . ' (' . __('не обязательно') .')' }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="comment" name="comment"
                                                   value="{{ $report->comment }}">
                                            @error('comment')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="question">{{ __('Описание') }}</label>
                                        <div class="form-control-wrap">
                                            <textarea type="text" class="form-control" id="question" name="question">{{ $report->question }}</textarea>
                                        </div>
                                        @error('question')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label" for="link">{{ __('ССЫЛКА НА WOWHEAD ИЛИ ИЗОБРАЖЕНИЕ/ВИДЕО') . ' (' . __('не обязательно') .')' }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="link" name="link"
                                                   value="{{ $report->link }}">
                                            @error('link')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="attachment" class="form-label">@isset($report->attachment) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                        <div class="form-control-wrap" style="margin-top: 20px;">
                                            @isset($report->attachment)
                                                <span><img src="/storage/{{ $report->attachment }}" alt="{{ $report->attachment }}"/></span>
                                            @endisset
                                            <div class="custom-file">
                                                <input class="custom-file-input @error('attachment') is-invalid @enderror" id="attachment" name="attachment" type="file" accept=".png, .jpg, .jpeg, .webp">
                                                <label class="custom-file-label" for="attachment">{{ __('Изображение') }}</label>
                                                @error('attachment')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary ml-auto" onclick="return CreateReport();">{{ __('Отправить') }}</button>
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
        $(document).ready(function() {

            $('#subcategory_id_1 option').each(function() {

                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_1_group').show();
                }
            });
            $('#subcategory_id_2 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_2_group').show();
                }
            });
            $('#subcategory_id_3 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_3_group').show();
                }
            });
            $('#subcategory_id_4 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_4_group').show();
                }
            });
            $('#subcategory_id_5 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_5_group').show();
                }
            });

            $('#category_id').change(function() {
                if ($('#category_id').val() == '3') { //Классы
                    $('#subcategory_id_2_group').hide();
                    $('#subcategory_id_3_group').hide();
                    $('#subcategory_id_4_group').hide();
                    $('#subcategory_id_5_group').hide();
                    $('#subcategory_id_1_group').show();
                } else if ($('#category_id').val() == '5') { //EXPLOITS
                    $('#subcategory_id_1_group').hide();
                    $('#subcategory_id_3_group').hide();
                    $('#subcategory_id_4_group').hide();
                    $('#subcategory_id_5_group').hide();
                    $('#subcategory_id_2_group').show();
                } else if ($('#category_id').val() == '6') { //Instances
                    $('#subcategory_id_1_group').hide();
                    $('#subcategory_id_2_group').hide();
                    $('#subcategory_id_4_group').hide();
                    $('#subcategory_id_5_group').hide();
                    $('#subcategory_id_3_group').show();
                } else if ($('#category_id').val() == '8') { //Other
                    $('#subcategory_id_1_group').hide();
                    $('#subcategory_id_2_group').hide();
                    $('#subcategory_id_3_group').hide();
                    $('#subcategory_id_5_group').hide();
                    $('#subcategory_id_4_group').show();
                } else if ($('#category_id').val() == '9') { //Professions
                    $('#subcategory_id_1_group').hide();
                    $('#subcategory_id_2_group').hide();
                    $('#subcategory_id_3_group').hide();
                    $('#subcategory_id_4_group').hide();
                    $('#subcategory_id_5_group').show();
                } else {
                    $('#subcategory_id_1_group').hide();
                    $('#subcategory_id_2_group').hide();
                    $('#subcategory_id_3_group').hide();
                    $('#subcategory_id_4_group').hide();
                    $('#subcategory_id_5_group').hide();
                }
                if ($('#category_id').val() == '11') { //Сайт
                    $('#realm_id').hide();
                } else {
                    $('#realm_id').show();
                }
                if ($('#category_id').val() > 0) {
                    $('#comment').show();
                } else {
                    $('#comment').hide();
                }
            });
        });

        function CreateReport() {
            let error = false;

            $('#subcategory_id_1 .select-selected').removeClass('report-error');
            $('#subcategory_id_2 .select-selected').removeClass('report-error');
            $('#subcategory_id_3 .select-selected').removeClass('report-error');
            $('#subcategory_id_4 .select-selected').removeClass('report-error');
            $('#subcategory_id_5 .select-selected').removeClass('report-error');
            $('#priority .select-selected').removeClass('report-error');
            $('#category_id .select-selected').removeClass('report-error');
            $('#title').removeClass('report-error');

            if ($('#title').val() == '') {
                $('#title').addClass('report-error');
                error = true;
            }

            if ($('#subcategory_id_1').is(':visible')) {
                if ($('#subcategory_id_1').val() < 1) {
                    $('#subcategory_id_1 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_1').val());
            } else if ($('#subcategory_id_2').is(':visible')) {
                if ($('#subcategory_id_2').val() < 1) {
                    $('#subcategory_id_2 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_2').val());
            } else if ($('#subcategory_id_3').is(':visible')) {
                if ($('#subcategory_id_3').val() < 1) {
                    $('#subcategory_id_3 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_3').val());
            } else if ($('#subcategory_id_4').is(':visible')) {
                if ($('#subcategory_id_4').val() < 1) {
                    $('#subcategory_id_4 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_4').val());
            } else if ($('#subcategory_id_5').is(':visible')) {
                if ($('#subcategory_id_5').val() < 1) {
                    $('#subcategory_id_5 .select-selected').addClass('report-error');
                    error = true;
                }
                $('#subcategory_id').val($('#subcategory_id_5').val());
            }

            $('#subcategory_id').val($('#subcategory_id_1').val());

            if ($('#priority').val() < 1) {
                $('#priority .select-selected').addClass('report-error');
                error = true;
            }
            if ($('#category_id').val() < 1) {
                $('#category_id .select-selected').addClass('report-error');
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