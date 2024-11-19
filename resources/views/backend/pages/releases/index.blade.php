@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Дорожная карта'))
@section('headerTitle', __('Дорожная карта'))
@section('headerDesc', __('Редактирование релизов') . '.')

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <a href="{{ route('releases.create') }}" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-plus-c mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Добавить релиз') }}</span>
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

                    @if(!empty($releases))
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">

                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Заголовок') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Порядок сортировки') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Дата релиза') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Дата создания') }}</span></div>
                                <div class="nk-tb-col tb-col-md" style="width: 350px;"><span class="sub-text"></span></div>
                            </div>

                            @foreach($releases as $release)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @php
                                            $title = "title_" .app()->getLocale();
                                            $description = "description_" .app()->getLocale();
                                        @endphp
                                        <a href="{{ route('releases.edit', $release) }}" target="_blank">
                                                {{ $release->$title }}
                                        </a>
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        @if ($release->is_release == 1)
                                            {{ __('Вышел') }}
                                        @else
                                            {{ __('Не вышел') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $release->sort }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ date('d-m-Y', strtotime($release->date)) }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $release->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>

                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('releases.edit', $release) }}">{{ __('Редактировать') }}</a></li>
                                                <form action="{{ route('releases.destroy', $release) }}" method="POST">
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
                        {{ $releases->links('layouts.pagination.cabinet') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
