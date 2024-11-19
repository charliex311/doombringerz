@extends('backend.layouts.backend')

@isset($article)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать новость'))
    @section('headerDesc', __('Редактирование новости.'))
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить новость'))
    @section('headerDesc', __('Добавление новости.'))
@endisset

@section('headerTitle', __('Новости'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($article){{ route('articles.update', $article) }}@else{{ route('articles.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($article)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset
                            <input type="hidden" name="type" value="news">

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
                                                                       @isset($article) value="{{ $article->$title }}" @else value="{{ old($title) }}" @endisset>
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
                                                                <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($article){{ $article->$description }}@else{{ old($description) }}@endisset</textarea>
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
                                                                <option value="0" @if (isset($article) && $article->status == '0') selected @endif>{{ __('Для админов') }}</option>
                                                                <option value="1" @if (isset($article) && $article->status == '1') selected @endif>{{ __('Для всех') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                            <div class="row g-4">

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">@isset($article) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                        <div class="form-control-wrap">
                                            @isset($article)
                                                <span><img src="{{ $article->image_url }}" alt="{{ $article->image }}"/></span>
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

                                <div class="col-lg-6" style="display: none;">
                                    <div class="form-group">
                                        <label for="image" class="form-label">@isset($article) {{ __('Заменить дополнительное изображение') }} @else {{ __('Дополнительное изображение') }} @endisset</label>
                                        <div class="form-control-wrap">
                                            @isset($article)
                                                <span><img src="{{ $article->add_image_url }}" alt="{{ $article->add_image }}"/></span>
                                            @endisset
                                            <div class="custom-file">
                                                <input class="custom-file-input @error('add_image') is-invalid @enderror" id="add_image" name="add_image" type="file" >
                                                <label class="custom-file-label" for="add_image">{{ __('Изображение') }}</label>
                                                @error('add_image')
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
                                        <button type="submit" class="btn btn-lg btn-primary ml-auto">{{ __('Отправить') }}</button>
                                    </div>
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
    <script>
        $(document).ready(function () {
            $('#type').on('change', function () {
                console.log($(this).find('option:selected').val());
                if ($(this).find('option:selected').val() == 'news') {
                    $('.col-description').hide();
                } else {
                    $('.col-description').show();
                }
            });
        });
    </script>
@endpush
