@php
    if(isset($ticket) && $ticket->history !== NULL) {
        $histories = json_decode($ticket->history);
    }
    $title = "title_" .app()->getLocale();
    $description = "description_" . app()->getLocale();
@endphp

@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Поддержка'))
@section('headerTitle', __('Поддержка'))
@section('headerDesc', $ticket->title)

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">@yield('title')</span>
                                @if($ticket->trashed())
                                    <span class="badge badge-gray">{{ __('Удалён') }}</span>
                                @elseif($ticket->status === 0)
                                    <span class="badge badge-danger">{{ __('Закрыт') }}</span>
                                @elseif($ticket->status === 5)
                                    <span class="badge badge-info">{{ __('Решено') }}</span>
                                @else
                                    <span class="badge badge-success">{{ __('Открыт') }}</span>
                                @endif

                                @if ($ticket->is_read == 1)
                                    <span class="badge badge-green">{{ __('Прочитано') }}</span>
                                @else
                                    <span class="badge badge-orange">{{ __('Новое сообщение') }}</span>
                                @endif
                            </h5>
                        </div>

                        <div class="card-title-group icon-text">
                            <span>{{ __('Время обновления') }}: <em class="icon ni ni-clock ticket-update-time" data-toggle="tooltip" data-bs-placement="top" title="{{ $ticket->updated_at->format('d/m/Y H:i') }}"></em>{{ time_diff_plural_forms($ticket->updated_at->timestamp) }}</span>
                        </div>
                        <div class="card-title-group icon-text">
                            <span class="priority-{{ $ticket->priority }}">{{ __('Приоритет') }}: {{ getReportPriorityNameById($ticket->priority) }}</span>
                        </div>
                    </div>

                    <div class="card-inner p-0 border-top">

                        <div class="nk-reply-item ticket-first" style="min-height: 230px;">

                            <div class="nk-reply-header">
                                <div class="user-card flex-column align-items-start">
                                    <div class="user-name text-left">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-primary">
                                                <span class="text-uppercase"> {{ substr(trim($ticket->user->name), 0, 2) }} </span>
                                            </div>
                                            <div class="user-name">
                                                <div class="user-name text-left">{{ $ticket->user->name }}</div>
                                                <a href="{{ route('backend.user.details', $ticket->user) }}">{{ $ticket->user->email }}</a>
                                                <span class="ticket-history-time"><em class="icon ni ni-clock ticket-update-time"></em>{{ time_diff_plural_forms($ticket->created_at->timestamp) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="date-time">{{ $ticket->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="nk-reply-body">
                                <div class="nk-reply-entry entry">
                                    <p>{{ $ticket->question }}</p>
                                </div>

                                @if($ticket->attachment)
                                    <div class="attach-files">
                                        <ul class="attach-list">
                                            <li class="attach-item">
                                                @php $allowedExtensions = ['jpeg', 'jpg', 'png', 'webp', 'bmp', 'gif'];
                                                     $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';
                                                @endphp
                                                @if(preg_match($pattern, $ticket->image_url))
                                                    <a class="download" href="{{ $ticket->image_url }}" target="_blank">
                                                        <em class="icon ni ni-img"></em>
                                                        <span>{{ __('Изображение') }}</span>
                                                    </a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>
                                @endif
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

                    <div class="card-inner p-0 border-top">
                        @if(isset($histories))
                            @foreach($histories as $history)

                                <div class="nk-reply-item {{ ($loop->iteration % 2 == 0) ? 'odd' : 'even' }}">
                                    <div class="nk-reply-header">
                                        <div class="user-card flex-column align-items-start">
                                            <div class="user-name text-left">
                                                <div class="user-card">
                                                    <div class="user-avatar xs bg-primary">
                                                        <span class="text-uppercase"> {{ substr(trim($ticket->user->name), 0, 2) }} </span>
                                                    </div>
                                                    <div class="user-name">
                                                        <span class="tb-lead">
                                                            @if($history->type == 'question')
                                                                {{ __('Агент Поддержки') }} #{{ $history->user_id }}
                                                                @can('support')
                                                                    ({{ $history->user_name }})
                                                                @endcan
                                                            @else
                                                                {{ $history->user_name}}
                                                            @endif
                                                        </span>
                                                        <span>{{ $ticket->user->email }}</span>
                                                        <span class="ticket-history-time"><em class="icon ni ni-clock ticket-update-time"></em>{{ time_diff_plural_forms(strtotime($history->updated_at)) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="date-time">{{ $history->updated_at }}</div>
                                    </div>

                                    <div class="nk-reply-body">

                                        <div class="nk-reply-entry entry">
                                            <p>{!! str_replace("<br>", "\r\n", $history->text) !!}</p>
                                        </div>

                                        @if(isset($history->attachment) && $history->attachment != '')
                                            <div class="attach-files">
                                                <ul class="attach-list">
                                                    <li class="attach-item">
                                                        @php $allowedExtensions = ['jpeg', 'jpg', 'png', 'webp', 'bmp', 'gif'];
                                                                         $pattern = '/\.(' . implode('|', $allowedExtensions) . ')$/i';
                                                        @endphp
                                                        @if(preg_match($pattern, $history->attachment))
                                                            <a class="download" href="/storage/{{ $history->attachment }}" target="_blank">
                                                                <em class="icon ni ni-img"></em>
                                                                <span>{{ __('Вложение') }}</span>
                                                            </a>
                                                        @endif
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(auth()->user()->can('support') && !$ticket->trashed() && $ticket->status != 0)

        <div class="nk-block">
            <div class="row g-gs">
                <div class="col-12">
                    <div class="card card-bordered">
                        <div class="card-inner">

                            <form action="{{ route('backend.tickets.update', $ticket) }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <textarea type="text" class="form-control" id="answer" name="answer" placeholder="{{ __('Ответить') }}"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label class="form-label" for="attachment">{{ __('Вложение') }}</label>
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
                                </div>

                                <div class="row g-4" style="margin-top: 25px !important;">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-lg btn-primary ml-auto" style="width: 230px;">{{ __('Ответить') }}</button>
                                        </div>
                                    </div>
                                </div>

                            </form>

                            <div class="nk-tb-col tb-col-md ticket-actions">
                                <div class="drodown">
                                    <a href="#"
                                       class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown" title="{{ __('Действия') }}">
                                        <em class="icon ni ni-more-h" style="transform: rotate(90deg);"></em>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li>
                                                <form action="{{ route('backend.tickets.isread', $ticket) }}" method="post">
                                                    @csrf
                                                    <a class="dropdown-item" href="{{ route('backend.tickets.show', $ticket) }}">
                                                        <em class="icon ni ni-alert-circle"></em><span>{{ __('Прочитано') }}</span>
                                                    </a>
                                                </form>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ route('backend.tickets.solve', $ticket) }}">
                                                    <em class="icon ni ni-check-circle"></em><span>{{ __('Пометить решённым') }}</span>
                                                </a>
                                            </li>
                                            <li>
                                                <form action="{{ route('backend.tickets.close', $ticket) }}" method="post">
                                                    @csrf
                                                    <a class="dropdown-item" href="{{ route('backend.tickets.show', $ticket) }}">
                                                        <em class="icon ni ni-alert-circle"></em><span>{{ __('Закрыть') }}</span>
                                                    </a>
                                                </form>
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
                    </div>

                    @endif

                </div>
            </div>
        </div>

<!-- .nk-block -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.msg-template').on('click', function () {
                let msg = $(this).data('text');
                console.log(msg);
                $('#answer-txt').val(msg);
            });
        });
    </script>
@endpush
