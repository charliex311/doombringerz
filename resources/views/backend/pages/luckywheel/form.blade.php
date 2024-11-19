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

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="type">{{ __('Тип записи') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="type" name="type" class="form-select">
                                                <option value="promotions" @if ( (isset($article) && $article->type === 'promotions') || (old('type') === 'promotions')) selected @endif>{{ __('Акции') }}</option>
                                                <option value="news" @if ( (isset($article) && $article->type === 'news') || (old('type') === 'news') ) selected @endif>{{ __('Новости') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title_ru">{{ __('Заголовок') }} (RU)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="title_ru" name="title_ru"
                                                   @isset($article) value="{{ $article->title_ru }}" @else value="{{ old('title_ru') }}" @endisset>
                                            @error('title_ru')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title_en">{{ __('Заголовок') }} (EN)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="title_en" name="title_en"
                                                   @isset($article) value="{{ $article->title_en }}" @else value="{{ old('title_en') }}" @endisset>
                                            @error('title_en')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>



                                <div class="col-lg-6 col-description" @if ( (isset($article) && $article->type === 'news') || (old('type') === 'news')) style="display: none;" @endif>
                                    <div class="form-group">
                                        <label class="form-label" for="description_ru">{{ __('Описание') }} (RU)</label>
                                        <div class="form-control-wrap">
                                            <textarea type="text" class="form-control" id="description_ru" name="description_ru">@isset($article) {{ $article->description_ru }} @else {{ old('description_ru') }} @endisset</textarea>
                                        </div>
                                        @error('description_ru')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 col-description" @if ( (isset($article) && $article->type === 'news') || (old('type') === 'news')) style="display: none;" @endif>
                                    <div class="form-group">
                                        <label class="form-label" for="description_en">{{ __('Описание') }} (EN)</label>
                                        <div class="form-control-wrap">
                                            <textarea type="text" class="form-control" id="description_en" name="description_en">@isset($article) {{ $article->description_en }} @else {{ old('description_en') }} @endisset</textarea>
                                        </div>
                                        @error('description_en')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="url">{{ __('Ссылка на полную новость') }} (RU)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                                   id="url" name="url"
                                                   @isset($article) value="{{ $article->url }}" @else value="{{ old('url') }}" @endisset required
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
                                        <label class="form-label" for="url">{{ __('Ссылка на полную новость') }} (EN)</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                                   id="url" name="url"
                                                   @isset($article) value="{{ $article->url }}" @else value="{{ old('url') }}" @endisset required
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
                                        <label for="image" class="form-label">@isset($article) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                        @isset($article)
                                            <span>{{ $article->image }}</span>
                                        @endisset
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
                                        <label for="image" class="form-label">@isset($article) {{ __('Заменить дополнительное изображение') }} @else {{ __('Дополнительное изображение') }} @endisset</label>
                                        @isset($article)
                                            <span>{{ $article->add_image }}</span>
                                        @endisset
                                        <div class="form-control-wrap">
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