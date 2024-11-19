@extends('backend.layouts.backend')

@isset($releasenote)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать лог'))
    @section('headerDesc', __('Редактирование лога') . '.')
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить лог'))
    @section('headerDesc', __('Добавление лога') . '.')
@endisset

@section('headerTitle', __('Логи Релизов'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($releasenote){{ route('releasenotes.update', $releasenote) }}@else{{ route('releasenotes.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($releasenote)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                        <!-- Tabs -->
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="tab">
                                        @foreach(getlangs() as $key => $value)
                                            <a class="tablinks @if($loop->first) active @endif" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Tab content -->
                            @foreach(getlangs() as $key => $value)
                                <div id="{{ $key }}" class="tabcontent" @if($loop->first) style="display: block @endif">

                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                @php
                                                    $title = "title_" . $key;
                                                    $description = "description_" . $key;
                                                @endphp
                                                <label class="form-label" for="{{ $title }}">{{ __('Заголовок') }}
                                                    ({{ $key }})</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="{{ $title }}"
                                                           name="{{ $title }}"
                                                           @isset($releasenote) value="{{ $releasenote->$title }}"
                                                           @else value="{{ old($title) }}" @endisset>
                                                    @error('{{ $title }}')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4 col-description">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label" for="{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($releasenote){{ $releasenote->$description }}@else{{ old($description) }}@endisset</textarea>
                                                </div>
                                                @error('{{ $description }}')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach


                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">{{ __('Статус') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="status" name="status" class="form-select">
                                                <option value="0" @if(isset($releasenote) && $releasenote->status == '0') selected @endif>{{ __('Не активно') }}</option>
                                                <option value="1" @if(isset($releasenote) && $releasenote->status == '1' || !isset($releasenote)) selected @endif>{{ __('Активно') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category_id">{{ __('Категория') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="category_id" name="category_id" class="form-select">
                                                @foreach(getReleaseNotesCategories() as $index => $category)
                                                    <option value="{{ $index }}" @if(isset($releasenote) && $releasenote->category_id == $index) selected @endif>{{ $category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="server">{{ __('Игровой мир') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="server" name="server" class="form-select">
                                                @foreach(getservers() as $server)
                                                    <option value="{{ $server->id }}" @if(isset($releasenote) && $releasenote->server == $server->id) selected @endif>{{ $server->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date">{{ __('Дата релиза') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="datetime-local" class="form-control @error('date') is-invalid @enderror"
                                                   id="date" name="date"
                                                   @isset($releasenote) value="{{ $releasenote->date }}" @else value="{{ old('date') }}" @endisset required
                                            >
                                            @error('date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
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
@push('scripts')
    <script>
        @foreach(getlangs() as $key => $value)
            CKEDITOR.config.allowedContent=true;

        @if(session()->has('theme') && session()->get('theme') == 'dark')
        CKEDITOR.addCss('.cke_editable { background-color: #0e1014; color: #942f06 }');
        @endif

        CKEDITOR.replace( 'description_{{ $key }}', {
            language: '{{ app()->getLocale() }}'
        });
        @endforeach
    </script>
@endpush
