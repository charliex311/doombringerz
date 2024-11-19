@extends('layouts.cabinet')

@if(!request()->routeIs('tickets.all'))
    @section('title', __('Поддержка'))
@else
    @section('title', __('Обращения'))
@endif

@section('wrap')

    @if(auth()->check() && auth()->user()->isGMAdmin())
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
    @endif
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title ticket-list-title">
                                <span class="mr-2">@yield('title')</span>
                                @if(!request()->routeIs('tickets.all'))
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createTicket">
                                        <span class="d-none d-sm-inline">{{ __('Создать запрос') }}</span>
                                    </a>
                                @endif
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="simplebar-mask" style="position: relative;">
                            <div class="simplebar-offset" style="position: relative;">
                                <div class="simplebar-content-wrapper" style="max-height: max-content;height: auto;">
                                    <div class="simplebar-content" style="padding: 0px;">
                                        @foreach($tickets as $ticket)
                                            <div class="nk-ibx-item is-unread">
                                                <a href="{{ route('tickets.show', $ticket) }}" class="nk-ibx-link"></a>
                                                <div class="nk-ibx-item-elem nk-ibx-item-user">
                                                    <div class="lead-text">{{ $ticket->title }}</div>
                                                </div>
                                                <div class="nk-ibx-item-elem nk-ibx-item-fluid">
                                                    <div class="nk-ibx-context-group">
                                                        <div class="nk-ibx-context-badges">
                                                            @if($ticket->trashed())
                                                                <span class="badge badge-gray">{{ __('Удалён') }}</span>
                                                            @elseif($ticket->status === 1)
                                                                <span class="badge badge-pending">{{ __('В ожидании') }}</span>
                                                            @elseif($ticket->status === 2)
                                                                <span class="badge badge-player">{{ __('Игрок ответил') }}</span>
                                                            @elseif($ticket->status === 3)
                                                                <span class="badge badge-staff">{{ __('Ответ персонала') }}</span>
                                                            @elseif($ticket->status === 4)
                                                                <span class="badge badge-closed">{{ __('Закрыт') }}</span>
                                                            @elseif($ticket->status === 5)
                                                                <span class="badge badge-solved">{{ __('Решено') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="nk-ibx-item-elem nk-ibx-item-user">
                                                    @if($ticket->getLastHistory() && isset(getuser($ticket->getLastHistory()->user_id)->avatar_url))
                                                        <div class="info__user">
                                                            <div class="info__user-icon">
                                                                <img src="{{ getuser($ticket->getLastHistory()->user_id)->avatar_url }}" alt="avatar-icon">
                                                            </div>
                                                            <div class="info__user-data">
                                                                <div class="info__user-name">
                                                                    {{ $ticket->getLastHistory()->user_name }}
                                                                </div>
                                                                <div class="info__user-date">
                                                                    {{ __('Создано') }} {{ getmonthname(date('m', strtotime($ticket->getLastHistory()->updated_at))) }} {{ date('d', strtotime($ticket->getLastHistory()->updated_at)) }}, {{ date('Y', strtotime($ticket->getLastHistory()->updated_at)) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="nk-ibx-item-elem nk-ibx-item-time">
                                                    <div class="sub-text">{{ $ticket->created_at->format('d/m/y H:i') }}</div>
                                                </div>
                                                <div class="nk-ibx-item-elem nk-ibx-item-tools">
                                                    <a href="{{ route('tickets.solve', $ticket) }}" class="btn btn-sm btn-primary btn-orange"><span>{{ __('Отметить как решенное') }}</span></a>
                                                </div>

                                                <div class="nk-ibx-item-elem nk-ibx-item-tools">
                                                    <a href="{{ route('tickets.delete', $ticket) }}"
                                                       class="nk-menu-icon delete" data-toggle="tooltip"
                                                       data-placement="top" title=""
                                                       data-original-title="{{ __('Удалить') }}" onClick="return Confirm();">
                                                        <span><em class="icon ni ni-trash"></em></span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-inner">
                    {{ $tickets->links('layouts.pagination.cabinet') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    <div class="modal fade zoom" tabindex="-1" id="createTicket">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('Создать запрос') }}</h5>
                </div>
                @if ($errors->any())
                    <script>
                        $(document).ready(function () {
                            $('#createTicket').modal('show');
                        });
                    </script>
                @endif
                <form method="POST" action="{{ route('tickets.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="form-label" for="title">{{ __('Тема запроса') }}</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control d-inline @error('title') is-invalid @enderror" id="title" name="title">
                                @error('title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="question">{{ __('Вопрос') }}</label>
                            <div class="form-control-wrap">
                                <textarea class="form-control d-inline @error('title') is-invalid @enderror" id="question" name="question">{{ old('question') }}</textarea>
                                @error('question')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="attachment">{{ __('Скриншот') }}</label>
                            <div class="form-control-wrap">
                                <div class="custom-file">
                                    <input type="file" accept=".png, .jpg, .jpeg, .webp" class="custom-file-input" id="attachment" name="attachment">
                                    <label class="custom-file-label" for="attachment">{{ __('Выбрать файл') }}</label>
                                </div>
                                @error('attachment')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="submit" class="btn btn-lg btn-primary"><span>{{ __('Создать') }}</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endprepend

@prepend('scripts')
    <script>
        function Confirm() {
            if (confirm("{{ __('Вы уверены, что хотите удалить обращение?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endprepend