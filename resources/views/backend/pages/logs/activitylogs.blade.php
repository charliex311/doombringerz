@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Логи Активности'))
@section('headerTitle', __('Логи Активности'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
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
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">IP</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Сообщение') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Дата') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Тип') }}</span></div>
                            </div>
                            @foreach($logs as $log)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead">{{ $log->ip }}</span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $log->message }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $log->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md" style="padding-right: 0px;">
                                    <span class="tb-sub activity-type-{{ $log->type }}">
                                        {{ getlogtype($log->type) }}
                                    </span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-inner">
                        {{ $logs->links('backend.layouts.pagination.backend') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
