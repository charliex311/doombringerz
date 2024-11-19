@extends('layouts.cabinet')

@if(!request()->routeIs('tickets.all'))
    @section('title', __('Поддержка'))
@else
    @section('title', __('Обращения'))
@endif

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
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
                                                <div class="user-card">
                                                    <div class="user-name">
                                                        <div class="lead-text">{{ $ticket->user->name }}</div>
                                                        <span class="text-gray">{{ $ticket->user->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-ibx-item-elem nk-ibx-item-fluid">
                                                <div class="nk-ibx-context-group">
                                                    <div class="nk-ibx-context-badges">
                                                        @if ($ticket->trashed())
                                                            <span class="badge badge-gray">{{ __('Удалён') }}</span>
                                                        @elseif ($ticket->status === 1)
                                                            <span class="badge badge-success">{{ __('Открыт') }}</span>
                                                        @elseif ($ticket->status === 0)
                                                            <span class="badge badge-danger">{{ __('Закрыт') }}</span>
                                                        @endif
                                                    </div>
                                                    <div class="nk-ibx-context">
                                                        <span class="nk-ibx-context-text">
                                                            <span class="heading">{{ $ticket->title }}</span>
                                                            {{ Str::limit($ticket->question, 64) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($ticket->attachment)
                                                <div class="nk-ibx-item-elem nk-ibx-item-attach">
                                                    <a class="link link-light"> <em class="icon ni ni-clip-h"></em> </a>
                                                </div>
                                            @endif
                                            <div class="nk-ibx-item-elem nk-ibx-item-time">
                                                <div class="sub-text">{{ $ticket->created_at->format('d/m/y') }}</div>
                                                <div class="sub-text">{{ $ticket->created_at->format('H:i') }}</div>
                                            </div>
                                            <div class="nk-ibx-item-elem nk-ibx-item-tools">
                                                <div class="ibx-actions">
                                                    <ul class="ibx-actions-hidden gx-1">
                                                        <li>
                                                            <a href="{{ route('tickets.delete', $ticket) }}" class="btn btn-sm btn-icon btn-trigger" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{ __('Удалить') }}">
                                                                <em class="icon ni ni-trash"></em>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <ul class="ibx-actions-visible gx-2">
                                                        <li>
                                                            <div class="dropdown"> <a href="#" class="dropdown-toggle btn btn-sm btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a class="dropdown-item" href="{{ route('tickets.delete', $ticket) }}"><em class="icon ni ni-trash"></em><span>{{ __('Удалить') }}</span></a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
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
                                    <input type="file" class="custom-file-input" id="attachment" name="attachment">
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
                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Создать') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endprepend
