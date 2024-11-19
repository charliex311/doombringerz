@extends('backend.layouts.backend')

@isset($feature)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать особенность'))
    @section('headerDesc', __('Редактирование особенности.'))
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить особенность'))
    @section('headerDesc', __('Добавление особенности.'))
@endisset

@section('headerTitle', __('Особенности'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($feature){{ route('features.update', $feature) }}@else{{ route('features.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($feature)
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
                                    @php
                                        $title = "title_" . $key;
                                        $description = "description_" . $key;
                                    @endphp

                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">

                                                            <label class="form-label" for="{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="{{ $title }}" name="{{ $title }}"
                                                                       @isset($feature) value="{{ $feature->$title }}" @else value="{{ old($title) }}" @endisset>
                                                                @error($title)
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
                                                                <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($feature){{ $feature->$description }}@else{{ old($description) }}@endisset</textarea>
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
                                                                <option value="0" @if (isset($feature) && $feature->status == '0') selected @endif>{{ __('Для админов') }}</option>
                                                                <option value="1" @if (isset($feature) && $feature->status == '1') selected @endif>{{ __('Для всех') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="sort">{{ __('Порядок сортировки') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control @error('sort') is-invalid @enderror" id="sort" name="sort"
                                                                   @isset($feature) value="{{ $feature->sort }}" @else value="{{ old('sort') }}" @endisset required>
                                                            @error('sort')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="link">{{ __('Ссылка') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control @error('link') is-invalid @enderror" id="link" name="link"
                                                                   @isset($feature) value="{{ $feature->link }}" @else value="{{ old('link') }}" @endisset required>
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
                                            <label for="image" class="form-label">@isset($feature) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                            <div class="form-control-wrap" style="margin-top: 20px;">
                                                @isset($feature)
                                                    <span><img src="/storage/{{ $feature->image }}" alt="{{ $feature->image }}"/></span>
                                                @endisset
                                                <div class="custom-file">
                                                    <input class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" type="file" >
                                                    <label class="custom-file-label" for="image">{{ __('Изображение') }}</label>
                                                    @error('image')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
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
