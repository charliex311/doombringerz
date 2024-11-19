@extends('backend.layouts.backend')

@isset($stream)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать стрим'))
    @section('headerDesc', __('Редактирование стрима') . ".")
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить стрим'))
    @section('headerDesc', __('Добавление стрима') . ".")
@endisset

@section('headerTitle', __('Стрим'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                        </div>
                        <form action="@isset($stream){{ route('streams.update', $stream) }}@else{{ route('streams.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($stream)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">{{ __('Заголовок') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="title" name="title"
                                                   @isset($stream) value="{{ $stream->title }}" @else value="{{ old('title') }}" @endisset required>
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
                                        <label class="form-label" for="language">{{ __('Язык') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="language" name="language" class="form-select @error('language') is-invalid @enderror">
                                                <option value="ru" @if (isset($video) && $video->language === 'ru') selected @endif>{{ __('Русский') }}</option>
                                                <option value="en" @if (isset($video) && $video->language === 'en') selected @endif>{{ __('Английский') }}</option>
                                                <option value="br" @if (isset($video) && $video->language === 'br') selected @endif>{{ __('Бразильский') }}</option>
                                                <option value="es" @if (isset($video) && $video->language === 'es') selected @endif>{{ __('Испанский') }}</option>
                                            </select>
                                            @error('language')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="url">{{ __('Ссылка на канал YouTube / Twitch') }}</label>
                                        <br>
                                        <label class="form-label" for="url"><small>({{ __('вида') }} https://www.youtube.com/channel/UCHPbrkmgqJpoKaGxrUmbMvA)</small></label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                                   id="url" name="url"
                                                   @isset($stream) value="{{ $stream->url }}" @else value="{{ old('url') }}" @endisset required
                                            >
                                            @error('url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6" style="display: none;">
                                    <div class="form-group">
                                        <label class="form-label" for="image">@isset($stream) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                        <br>
                                        <label class="form-label" for="image" style="height: 15px;"><small></small></label>
                                        <div class="form-control-wrap">
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
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title" style="height: 23px;display: block;"><small></small></label>
                                        <label class="form-label" for="title">{{ __('Порядок сортировки') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="sort" name="sort"
                                                   @isset($stream->sort) value="{{ $stream->sort }}" @else value="{{ old('sort') }}" @endisset required>
                                            @error('sort')
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
