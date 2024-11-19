@extends('backend.layouts.backend')

@isset($shopitem)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать предмет'))
    @section('headerDesc', __('Редактирование предмета.'))
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить предмет'))
    @section('headerDesc', __('Добавление предмета.'))
@endisset

@section('headerTitle', __('Предметы магазина'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($shopitem){{ route('shopitems.update', $shopitem) }}@else{{ route('shopitems.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($shopitem)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                                <input type="hidden" name="type" value="news">
                            @endisset

                            <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="category_id">{{ __('Категория') }}</label>
                                    <div class="form-control-wrap">
                                        @php $title = "title_" .app()->getLocale(); @endphp
                                        <select id="category_id" name="category_id" class="form-select">
                                            @foreach(getshopcategories() as $category)
                                                <option value="{{ $category->id }}"
                                                        @if(isset($shopitem) && $shopitem->category_id == $category->id) selected @endif>{{ $category->$title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="l2_id">{{ __('L2 ID') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="l2_id" name="l2_id"
                                                   @isset($shopitem) value="{{ $shopitem->l2_id }}" @else value="{{ old('l2_id') }}" @endisset required>
                                            @error('l2_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="class">{{ __('Класс') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="class" name="class" class="form-select">
                                                <option value="weapon" @if(isset($shopitem) && $shopitem->class == 'weapon') selected @endif>{{ __('оружие') }}</option>
                                                <option value="armor" @if(isset($shopitem) && $shopitem->class == 'armor') selected @endif>{{ __('броня') }}</option>
                                                <option value="accessary" @if(isset($shopitem) && $shopitem->class == 'accessary') selected @endif>{{ __('аксессуар') }}</option>
                                                <option value="etc" @if(isset($shopitem) && $shopitem->class == 'etc') selected @endif>{{ __('другое') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="price">{{ __('Цена') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="price" name="price"
                                                   @isset($shopitem) value="{{ $shopitem->price }}" @else value="{{ old('price') }}" @endisset required>
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="status">{{ __('Состояние') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="status" name="status" class="form-select">
                                                <option value="0" @if(isset($shopitem) && $shopitem->status == '0') selected @endif>{{ __('Выключить') }}</option>
                                                <option value="1" @if(isset($shopitem) && $shopitem->status == '1') selected @endif>{{ __('Включить') }}</option>
                                            </select>
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

                                @php
                                    $title = "title_" . $key;
                                    $description = "description_" . $key;
                                @endphp

                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="{{ $title }}">{{ __('Заголовок') }}
                                                        ({{ $key }})</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="{{ $title }}"
                                                               name="{{ $title }}"
                                                               @isset($shopitem) value="{{ $shopitem->$title }}"
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
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="{{ $description }}">{{ __('Описание') }} ({{ $key }}
                                                        )</label>
                                                    <div class="form-control-wrap">
                                                        <textarea type="text" class="form-control"
                                                                  id="{{ $description }}"
                                                                  name="{{ $description }}">@isset($shopitem){{ $shopitem->$description }}@else{{ old($description) }}@endisset</textarea>
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
                                        <label for="image" class="form-label">@isset($shopitem) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                        <div class="form-control-wrap">
                                            @isset($shopitem)
                                                <span><img src="/storage/{{ $shopitem->image }}" alt="{{ $shopitem->id }}"></span>
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