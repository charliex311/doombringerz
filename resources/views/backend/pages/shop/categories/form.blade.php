@extends('backend.layouts.backend')

@isset($shopcategory)
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
                        <form action="@isset($shopcategory){{ route('shopcategories.update', $shopcategory) }}@else{{ route('shopcategories.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($shopcategory)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="path">{{ __('Путь категории') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="path" name="path"
                                                   @isset($shopcategory) value="{{ $shopcategory->path }}" @else value="{{ old('path') }}" @endisset required>
                                            @error('path')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="main_category_id">{{ __('Главная категория') }}</label>
                                        <div class="form-control-wrap">
                                            @php $title = "title_" .app()->getLocale(); @endphp
                                            <select id="main_category_id" name="main_category_id" class="form-select">
                                                <option value="0">{{ __('Все') }}</option>
                                                @foreach(getshopcategories() as $key => $cat_1)

                                                    <option value="{{ getshopcategory($key)->id }}" @if(isset($shopcategory) && $shopcategory->main_category_id == getshopcategory($key)->id) selected @endif>{{ getshopcategory($key)->$title }}</option>
                                                    @if(!empty($cat_1))
                                                        @foreach($cat_1 as $key => $cat_2)
                                                            <option value="{{ getshopcategory($key)->id }}" @if(isset($shopcategory) && $shopcategory->main_category_id == getshopcategory($key)->id) selected @endif>- {{ getshopcategory($key)->$title }}</option>
                                                            @if(!empty($cat_2))
                                                                @foreach($cat_2 as $key => $cat_3)
                                                                    <option value="{{ getshopcategory($key)->id }}" @if(isset($shopcategory) && $shopcategory->main_category_id == getshopcategory($key)->id) selected @endif>-- {{ getshopcategory($key)->$title }}</option>
                                                                    @if(!empty($cat_3))
                                                                        @foreach($cat_3 as $key => $cat_4)
                                                                            <option value="{{ getshopcategory($key)->id }}" @if(isset($shopcategory) && $shopcategory->main_category_id == getshopcategory($key)->id) selected @endif>--- {{ getshopcategory($key)->$title }}</option>
                                                                            @if(!empty($cat_4))
                                                                                @foreach($cat_4 as $key => $cat_5)
                                                                                    <option value="{{ getshopcategory($key)->id }}" @if(isset($shopcategory) && $shopcategory->main_category_id == getshopcategory($key)->id) selected @endif>---- {{ getshopcategory($key)->$title }}</option>
                                                                                    @if(!empty($cat_5))
                                                                                        @foreach($cat_5 as $key => $cat_6)
                                                                                            <option value="{{ getshopcategory($key)->id }}" @if(isset($shopcategory) && $shopcategory->main_category_id == getshopcategory($key)->id) selected @endif>----- {{ getshopcategory($key)->$title }}</option>
                                                                                        @endforeach
                                                                                    @endif
                                                                                @endforeach
                                                                            @endif
                                                                        @endforeach
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @endforeach
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
                                                                       @isset($shopcategory) value="{{ $shopcategory->$title }}" @else value="{{ old($title) }}" @endisset>
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
                                                                <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($shopcategory) {{ $shopcategory->$description }} @else {{ old($description) }} @endisset</textarea>
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
                                                            <input type="text" class="form-control @error('sort') is-invalid @enderror"
                                                                   id="sort" name="sort"
                                                                   @isset($shopcategory) value="{{ $shopcategory->sort }}" @else value="{{ old('sort') }}" @endisset required
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