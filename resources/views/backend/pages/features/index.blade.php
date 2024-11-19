@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Особенности'))
@section('headerTitle', __('Особенности'))
@section('headerDesc', __('Редактирование особенностей.'))

@section('wrap')

    @php
        $title = "title_" .app()->getLocale();
    @endphp

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <a href="{{ route('features.create') }}" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-plus-c mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Добавить особенность') }}</span>
                                </a>
                            </h5>
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

                    @if(!empty($features))
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Заголовок') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Порядок сортировки') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Дата создания') }}</span></div>
                                <div class="nk-tb-col tb-col-md" style="width: 350px;"><span class="sub-text"></span></div>
                            </div>

                            @foreach($features as $feature)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        <a href="{{ route('features.edit', $feature) }}" target="_blank">
                                                {{ $feature->$title }}
                                        </a>
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        @if($feature->status == '1')
                                            {{ __('Для всех') }}
                                        @else
                                            {{ __('Для админов') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $feature->sort }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $feature->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('features.edit', $feature) }}">{{ __('Редактировать') }}</a></li>
                                                <form action="{{ route('features.destroy', $feature) }}" method="POST">
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
                        {{ $features->links('backend.layouts.pagination.backend') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
