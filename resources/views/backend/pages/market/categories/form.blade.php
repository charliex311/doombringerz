@extends('backend.layouts.backend')

@isset($marketcategory)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать категорию'))
    @section('headerDesc', __('Редактирование категории.'))
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить категорию'))
    @section('headerDesc', __('Добавление категории.'))
@endisset

@section('headerTitle', __('Категории предметов'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($marketcategory){{ route('marketcategories.update', $marketcategory) }}@else{{ route('marketcategories.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($marketcategory)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="path">{{ __('Путь категории') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="path" name="path"
                                                   @isset($marketcategory) value="{{ $marketcategory->path }}" @else value="{{ old('path') }}" @endisset required>
                                            @error('path')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Tabs -->
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="tab">
                                        @foreach(getlangs() as $key => $value)
                                            @if($loop->index == 0)
                                                <a class="tablinks active" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                            @else
                                                <a class="tablinks" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Tab content -->
                            @foreach(getlangs() as $key => $value)
                                @if($loop->index == 0)
                                    <div id="{{ $key }}" class="tabcontent" style="display: block">
                                        @else
                                            <div id="{{ $key }}" class="tabcontent">
                                                @endif

                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            @php
                                                                $title = "title_" . $key;
                                                                $description = "description_" . $key;
                                                            @endphp
                                                            <label class="form-label" for="{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="{{ $title }}" name="{{ $title }}"
                                                                       @isset($marketcategory) value="{{ $marketcategory->$title }}" @else value="{{ old($title) }}" @endisset>
                                                                @error('{{ $title }}')
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
                                                            <label class="form-label" for="{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($marketcategory){{ $marketcategory->$description }}@else{{ old($description) }}@endisset</textarea>
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
                                                        <label class="form-label" for="sort">{{ __('Порядок сортировки') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="number" class="form-control @error('sort') is-invalid @enderror"
                                                                   id="sort" name="sort"
                                                                   @isset($marketcategory) value="{{ $marketcategory->sort }}" @else value="{{ old('sort') }}" @endisset required
                                                            >
                                                            @error('sort')
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
                                                        <label for="image" class="form-label">@isset($marketcategory) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                                        <div class="form-control-wrap" style="margin-top: 20px;">
                                                            @isset($marketcategory)
                                                                <span><img src="/storage/{{ $marketcategory->image }}" alt="{{ $marketcategory->image }}"/></span>
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