@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Категории предметов'))
@section('headerTitle', __('Категории предметов'))
@section('headerDesc', __('Редактирование категорий.'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title" style="display: flex;">
                                <a href="{{ route('shopitems.index') }}" class="btn btn-sm btn-primary" style="margin-right: 15px;">
                                    <em class="icon ni ni-cart mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Предметы') }}</span>
                                </a>
                                <a href="{{ route('shopcategories.create') }}" class="btn btn-sm btn-primary" style="margin-right: 15px;">
                                    <em class="icon ni ni-plus-c mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Добавить категорию') }}</span>
                                </a>
                            </h5>
                            <div class="card-tools d-none d-md-inline" style="width: 200px;">
                                @php $title = "title_" .app()->getLocale(); @endphp
                                <select id="main_category_id" name="main_category_id" class="form-select">
                                    <option value="0">{{ __('Все') }}</option>
                                    @foreach(getshopcategories() as $key => $cat_1)

                                        <option value="{{ getshopcategory($key)->id }}" @if($main_category_id == getshopcategory($key)->id) selected @endif>{{ getshopcategory($key)->$title }}</option>
                                        @if(!empty($cat_1))
                                            @foreach($cat_1 as $key => $cat_2)
                                                <option value="{{ getshopcategory($key)->id }}" @if($main_category_id == getshopcategory($key)->id) selected @endif>- {{ getshopcategory($key)->$title }}</option>
                                                @if(!empty($cat_2))
                                                    @foreach($cat_2 as $key => $cat_3)
                                                        <option value="{{ getshopcategory($key)->id }}" @if($main_category_id == getshopcategory($key)->id) selected @endif>-- {{ getshopcategory($key)->$title }}</option>
                                                        @if(!empty($cat_3))
                                                            @foreach($cat_3 as $key => $cat_4)
                                                                <option value="{{ getshopcategory($key)->id }}" @if($main_category_id == getshopcategory($key)->id) selected @endif>--- {{ getshopcategory($key)->$title }}</option>
                                                                @if(!empty($cat_4))
                                                                    @foreach($cat_4 as $key => $cat_5)
                                                                        <option value="{{ getshopcategory($key)->id }}" @if($main_category_id == getshopcategory($key)->id) selected @endif>---- {{ getshopcategory($key)->$title }}</option>
                                                                        @if(!empty($cat_5))
                                                                            @foreach($cat_5 as $key => $cat_6)
                                                                                <option value="{{ getshopcategory($key)->id }}" @if($main_category_id == getshopcategory($key)->id) selected @endif>----- {{ getshopcategory($key)->$title }}</option>
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
                            <div class="card-tools d-none d-md-inline">
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Поиск') }}...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if(!empty($shopcategories))
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            @foreach($shopcategories as $shopcategory)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @php
                                            $title = "title_" .app()->getLocale();
                                            $description = "description_" .app()->getLocale();
                                        @endphp
                                        <a href="{{ route('shopcategories.edit', $shopcategory) }}" target="_blank">
                                            {{ $shopcategory->$title }}
                                        </a>
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $shopcategory->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        @if($shopcategory->main_category_id != 0)
                                            {{ getshopcategory($shopcategory->main_category_id)->$title }}
                                        @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $shopcategory->sort }}
                                    </span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('shopcategories.edit', $shopcategory) }}">{{ __('Редактировать') }}</a></li>
                                                <form action="{{ route('shopcategories.destroy', $shopcategory) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf

                                                    <li><a href="#" class="text-danger" onclick="this.closest('form').submit();return false;">{{ __('Удалить') }}</a></li>
                                                </form>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-inner">
                        {{ $shopcategories->links('layouts.pagination.cabinet') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->

    <script>
        $(document).ready(function(){
            $('#main_category_id').on('change', function() {
                document.location.replace('{{ config('app.url', '/') }}/backend/shopcategories?cat='+$('#main_category_id').val());
            });
        });
    </script>
@endsection
