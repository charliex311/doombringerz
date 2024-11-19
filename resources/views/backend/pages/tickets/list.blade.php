@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Поддержка'))
@section('headerTitle', __('Поддержка'))
@section('headerDesc', __('Поддержка пользователей.'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-xxl-3 col-sm-3">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="block card-inner">
                            <div class="card-title-group">
                                <div class="card-title"><h6 class="title">{{ __('Всего Тикетов') }}</h6></div>
                            </div>
                            <div class="data">
                                <div class="info">
                                    <span class="ticket-info-total"><em class="icon ni ni-money"></em> {{ $counts->total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-3">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="block card-inner">
                            <div class="card-title-group">
                                <div class="card-title"><h6 class="title">{{ __('Открытые Тикеты') }}</h6></div>
                            </div>
                            <div class="data">
                                <div class="info">
                                    <span class="ticket-info-open"><em class="icon ni ni-money"></em> {{ $counts->open }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-3">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="block card-inner">
                            <div class="card-title-group">
                                <div class="card-title"><h6 class="title">{{ __('Не прочитанные Тикеты') }}</h6></div>
                            </div>
                            <div class="data">
                                <div class="info">
                                    <span class="ticket-info-unread"><em class="icon ni ni-money"></em> {{ $counts->unread }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-sm-3">
                <div class="card">
                    <div class="nk-ecwg nk-ecwg6">
                        <div class="block card-inner">
                            <div class="card-title-group">
                                <div class="card-title"><h6 class="title">{{ __('Удалённые Тикеты') }}</h6></div>
                            </div>
                            <div class="data">
                                <div class="info">
                                    <span class="ticket-info-delete"><em class="icon ni ni-money"></em> {{ $counts->delete }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-tools" style="width: 150px;display: flex;width: 450px;">
                                <div class="form-control-wrap" style="width: 150px;">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search"></em>
                                    </div>
                                    <select class="form-select form-control" id="tickets_status" name="tickets_status">
                                        <option value="0" @if($tickets_status == '0') selected @endif>{{ __('Все') }}</option>
                                        <option value="1" @if($tickets_status == '1') selected @endif>{{ __('Открытые') }}</option>
                                        <option value="2" @if($tickets_status == '2') selected @endif>{{ __('Закрытые') }}</option>
                                        <option value="3" @if($tickets_status == '3') selected @endif>{{ __('Удалённые') }}</option>
                                        <option value="4" @if($tickets_status == '4') selected @endif>{{ __('Не прочитанные') }}</option>
                                    </select>
                                </div>
                                <div class="form-control-wrap" style="margin-left: 15px;">
                                    <form method="GET">
                                        <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-search"></em>
                                            </div>
                                            <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Поиск пользователя') }}...">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-tools d-none d-md-inline">
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search_in" value="{{ request()->query('search_in') }}" placeholder="{{ __('Поиск в переписке') }}...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-ulist is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">{{ __('ID') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Пользователь') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Детали тикета') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Описание') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Приоритет') }}</span></div>
                                <div class="nk-tb-col"><span class="sub-text">{{ __('Статус') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Вложение') }}</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">{{ __('Время обновления') }}</span></div>
                                <div class="nk-tb-col tb-col-md">{{ __('Действия') }}<span class="sub-text"></span></div>
                            </div>
                            @foreach($tickets as $ticket)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col"> <span>{{ $ticket->id }}</span> </div>
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-primary">
                                                <span class="text-uppercase"> {{ substr(trim($ticket->user->name), 0, 2) }} </span>
                                            </div>
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $ticket->user->name }}</span>
                                                <a href="{{ route('backend.user.details', $ticket->user) }}">{{ $ticket->user->email }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="nk-ibx-context-badges">
                                            @if($ticket->is_read == 1)
                                                <span class="badge badge-green">{{ __('Прочитано') }}</span>
                                            @else
                                                <span class="badge badge-orange">{{ __('Новое сообщение') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        <a href="{{ route('backend.tickets.show', $ticket) }}" class="nk-ibx-context-group">
                                            <div class="nk-ibx-context">
                                                <span class="nk-ibx-context-text">
                                                    <span class="heading">{{ $ticket->title }}</span>
                                                    {{ Str::limit($ticket->question, 30) }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="nk-tb-col tb-col-md">
                                        <span class="priority-{{ $ticket->priority }}">{{ getReportPriorityNameById($ticket->priority) }}</span>
                                    </div>
                                    <div class="nk-tb-col">
                                        <div class="nk-ibx-context-badges">
                                            @if($ticket->trashed())
                                                <span class="badge badge-gray">{{ __('Удалён') }}</span>
                                            @elseif($ticket->status === 0)
                                                <span class="badge badge-danger">{{ __('Закрыт') }}</span>
                                            @elseif($ticket->status === 5)
                                                <span class="badge badge-info">{{ __('Решено') }}</span>
                                            @else
                                                <span class="badge badge-success">{{ __('Открыт') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="nk-tb-col">
                                        @if($ticket->attachment)
                                            <a class="link link-light"> <em class="icon ni ni-clip-h"></em> </a>
                                        @endif
                                    </div>
                                    <div class="nk-tb-col tb-col-md icon-text">
                                        <span><em class="icon ni ni-clock" data-toggle="tooltip" data-bs-placement="top" title="{{ $ticket->updated_at->format('d/m/Y H:i') }}"></em>{{ time_diff_plural_forms($ticket->updated_at->timestamp) }}</span>
                                    </div>

                                    <div class="nk-tb-col tb-col-md">
                                        <div class="drodown">
                                            <a href="#"
                                               class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown" title="{{ __('Действия') }}">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('backend.tickets.show', $ticket) }}">
                                                            <em class="icon ni ni-alert-circle"></em><span>{{ __('Информация') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('backend.tickets.solve', $ticket) }}">
                                                            <em class="icon ni ni-check-circle"></em><span>{{ __('Пометить решённым') }}</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item text-danger" href="{{ route('tickets.delete', $ticket) }}">
                                                            <em class="icon ni ni-trash"></em><span>{{ __('Удалить') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="card-inner">
                        {{ $tickets->links('backend.layouts.pagination.tickets') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->

@endsection
@prepend('scripts')
    <script>
        $('#tickets_status').on('change', function() {
            document.location.replace('{{ route('tickets.all') }}?status='+this.value+'&search={{ request()->query('search') }}'+'&search_in={{ request()->query('search_in') }}');
        });
    </script>
@endprepend
