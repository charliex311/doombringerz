@extends('layouts.cabinet')

@isset($video)
    @section('title', 'Редактировать видео')
@else
    @section('title', 'Добавить видео')
@endisset

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">
                            <h5 class="card-title">@yield('title')</h5>
                        </div>
                        <form action="@isset($video){{ route('videos.update', $video) }}@else{{ route('videos.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($video)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">Заголовок</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="title" name="title"
                                                   @isset($video) value="{{ $video->title }}" @else value="{{ old('title') }}" @endisset required>
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
                                        <label class="form-label" for="language">Язык</label>
                                        <div class="form-control-wrap">
                                            <select id="language" name="language" class="form-select @error('language') is-invalid @enderror">
                                                <option value="ru" @if (isset($video) && $video->language === 'ru') selected @endif>Русский</option>
                                                <option value="en" @if (isset($video) && $video->language === 'en') selected @endif>English</option>
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
                                        <label class="form-label" for="url">ID Видео на YouTube (прим. 27JtRAIsaWO8)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                                   id="url" name="url"
                                                   @isset($video) value="{{ $video->url }}" @else value="{{ old('url') }}" @endisset required
                                            >
                                            @error('url')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">@isset($video) Заменить изображение @else Изображение @endisset</label>
                                        <div class="form-control-wrap">
                                            <div class="custom-file">
                                                <input class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" type="file" >
                                                <label class="custom-file-label" for="image">Изображение</label>
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
                                        <button type="submit" class="btn btn-lg btn-primary ml-auto">Отправить</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
