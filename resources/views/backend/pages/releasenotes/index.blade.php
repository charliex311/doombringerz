@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Логи Релизов'))
@section('headerTitle', __('Логи Релизов'))
@section('headerDesc', __('Редактирование логов') . '.')

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <a href="{{ route('releasenotes.create') }}" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-plus-c mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Добавить лог') }}</span>
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

                    @if(!empty($releasenotes))
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">

                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Заголовок') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Игровой мир') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Дата') }}</span></div>
                                <div class="nk-tb-col tb-col-md" style="width: 350px;"><span class="sub-text"></span></div>
                            </div>

                            @foreach($releasenotes as $releasenote)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @php
                                            $title = "title_" .app()->getLocale();
                                            $description = "description_" .app()->getLocale();
                                        @endphp
                                        <a href="{{ route('releasenotes.edit', $releasenote) }}" target="_blank">
                                                {{ $releasenote->$title }}
                                        </a>
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        @if($release->is_release == 1)
                                            {{ __('Активно') }}
                                        @else
                                            {{ __('Не активно') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ getserver($releasenote->server)->name }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ date('d/m/Y H:i', strtotime($releasenote->date)) }}
                                    </span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('releasenotes.edit', $releasenote) }}">{{ __('Редактировать') }}</a></li>
                                                <form action="{{ route('releasenotes.destroy', $releasenote) }}" method="POST">
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
                        {{ $releasenotes->links('layouts.pagination.cabinet') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
