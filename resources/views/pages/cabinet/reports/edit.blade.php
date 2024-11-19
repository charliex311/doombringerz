@extends('layouts.cabinet')

@section('title', __('Создать запрос') . ' - ' . config('options.main_title_'.app()->getLocale(), ''))

@section('content')

    <div class="cp-content">

        <div class="support">
            <h1>{{ __('Аккаунт') }} - {{ __('Редактировать запрос') }}</h1>
            <p></p>

            @include('partials.main.alert')

            <div class="form report-form">
                <form action="{{ route('reports.update', $report) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="realm_id" value="1">
                    <input type="hidden" name="subcategory_id" id="subcategory_id" value="-1">

                    <div class="row g-4">
                        <div class="col-lg-12">
                            <input type="text" class="form-control form-control-lg"
                                   id="title" name="title" placeholder="{{ __('Заголовок') }}"
                                   value="{{ $report->title }}">
                            @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="custom-select" id="select-priority">
                                <select name="priority" id="priority" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите приоритет') }}</option>
                                    @foreach(getListPriorityName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->priority) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="custom-select" id="select-realm_id">
                                <select name="char_id" id="char_id" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите персонажа') . ' (' . __('не обязательно') .')' }}</option>
                                    @if(count($characters) == 0)
                                        <option value="0">{{ __('Нет персонажей') }}</option>
                                    @endif
                                    @foreach($characters as $character)
                                            <option value="{{ $character->guid }}" @if($character->guid == $report->char_id) selected @endif>{{ $character->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="custom-select" id="select-category_id">
                                <select name="category_id" id="category_id" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите категорию') }}</option>
                                    @foreach(getListCategoryName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->category_id) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="custom-select" id="select-subcategory_id_1" style="display: none;">
                                <select id="subcategory_id_1" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                    @foreach(getListClassesName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->subcategory_id) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-select" id="select-subcategory_id_2" style="display: none;">
                                <select id="subcategory_id_2" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                    @foreach(getListExploitsName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->subcategory_id) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-select" id="select-subcategory_id_3" style="display: none;">
                                <select id="subcategory_id_3" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                    @foreach(getListInstancesName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->subcategory_id) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-select" id="select-subcategory_id_4" style="display: none;">
                                <select id="subcategory_id_4" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                    @foreach(getListOtherName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->subcategory_id) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="custom-select" id="select-subcategory_id_5" style="display: none;">
                                <select id="subcategory_id_5" class="form-control selectpicker white-grey bs-select-hidden">
                                    <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                    @foreach(getListProfessionsName() as $key => $value)
                                        <option value="{{ $key }}" @if($key == $report->subcategory_id) selected @endif>{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <input type="text" class="form-control form-control-lg" id="comment" name="comment"
                                   placeholder="{{ __('ID задания / НИП / предмета / достижения') . ' (' . __('не обязательно') .')' }}"
                                   value="{{ $report->comment }}" style="display: none;">
                            @error('comment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-12">
                            <textarea id="question" name="question" placeholder="">{{ $report->question }}</textarea>
                            @error('question')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-6">
                            <input type="text" class="form-control form-control-lg"
                                   id="link" name="link"
                                   placeholder="{{ __('ССЫЛКА НА WOWHEAD ИЛИ ИЗОБРАЖЕНИЕ/ВИДЕО') . ' (' . __('не обязательно') .')' }}"
                                   value="{{ $report->link }}">
                            @error('link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="col-lg-6">
                            <input type="file" accept=".png, .jpg, .jpeg, .webp" class="form-control form-control-lg"
                                   id="attachment" name="attachment"
                                   placeholder="{{ __('Скриншот')  . ' (' . __('не обязательно') .')' }}"
                                   value="{{ old('attachment') }}">
                            @error('attachment')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-lg-12" style="text-align: center;margin-top: 30px;">
                            <button onclick="return CreateReport();">{{ __('Изменить') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#subcategory_id_1 option').each(function() {

                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#select-subcategory_id_1').show();
                }
            });
            $('#subcategory_id_2 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#select-subcategory_id_2').show();
                }
            });
            $('#subcategory_id_3 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#select-subcategory_id_3').show();
                }
            });
            $('#subcategory_id_4 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#select-subcategory_id_4').show();
                }
            });
            $('#subcategory_id_5 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#select-subcategory_id_5').show();
                }
            });

            $('.select-items > div').click(function() {
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
                if ($('#category_id').val() > 0) { //Сайт
                    $('#comment').show();
                } else {
                    $('#comment').hide();
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