@php
    if(isset($ticket) && $ticket->history !== NULL) {
        $histories = json_decode($ticket->history);
    }
@endphp

@extends('layouts.cabinet')

@section('title', $ticket->title)

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered ticket-block">
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
                    </div>
                    <div class="card-inner p-0 border-top">

                        <div class="card-inner">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <div class="support-card flex-row align-items-start">
                                        <div class="user-profile">
                                            <p><span class="bold">{{ __("Тема обращения в службу поддержки") }}:</span> {{ $ticket->title }}</p>
                                            <p><span class="bold">{{ __('Сообщение') }}:</span> {{ $ticket->question }}</p>
                                            <p><span class="bold">{{ __('Дата') }}:</span> {{ getmonthname(date('m', strtotime($ticket->created_at))) }} {{ date('d', strtotime($ticket->created_at)) }}, {{ date('Y', strtotime($ticket->created_at)) }}</p>
                                            <div class="card-title-group icon-text">
                                                <span>{{ __('Время обновления') }}: <em class="icon ni ni-clock ticket-update-time" data-toggle="tooltip" data-bs-placement="top" title="{{ $ticket->updated_at->format('d/m/Y H:i') }}"></em>{{ time_diff_plural_forms($ticket->updated_at->timestamp) }}</span>
                                            </div>
                                            <div class="card-title-group icon-text">
                                                <span class="priority-{{ $ticket->priority }}">{{ __('Приоритет') }}: {{ getReportPriorityNameById($ticket->priority) }}</span>
                                            </div>
                                        </div>
                                        <div class="support-btns">
                                            <a href="{{ route('tickets.close', $ticket) }}" class="btn btn-sm btn-primary"><span>
                                                    @if(auth()->user()->isGMAdmin())
                                                        {{ __('Отменить тикет') }}
                                                    @else
                                                        {{ __('Отменить мой тикет') }}
                                                    @endif
                                                </span></a>
                                            <a href="{{ route('tickets.solve', $ticket) }}" class="btn btn-sm btn-primary btn-orange"><span>{{ __('Отметить как решенное') }}</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        <div class="nk-reply-item original-block">
                            <div class="nk-reply-header">
                                <div class="bug__user">
                                    <div class="bug__user-icon">
                                        <img src="{{ $ticket->user->avatar_url }}" alt="user-icon">
                                    </div>
                                    <span class="bug__user-icon-name">{{ $ticket->user->name }}</span>
                                    <span class="bug__user-icon-name">({{ $ticket->user->email }})</span>
                                </div>

                                <div class="user-card flex-column align-items-start">
                                    <div class="user-name text-left">
                                        <div class="nk-reply-entry entry">
                                            @php $texts = explode('<br>', $ticket->question); @endphp
                                            @foreach($texts as $text)
                                                <p>{{ $text }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="date-time">{{ $ticket->created_at->format('d.m.Y H:i') }}</div>
                            </div>
                            @if($ticket->attachment)
                                <div class="attach-files">
                                    <ul class="attach-list">
                                        <li class="attach-item">
                                            <a class="download" href="{{ $ticket->image_url }}" target="_blank">
                                                <em class="icon ni ni-img"></em>
                                                <span>{{ __('Изображение') }}</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>

                        @if(isset($histories))
                            @foreach($histories as $history)
                                @if($history->type == 'question')

                                    <div class="nk-reply-item">
                                        <div class="nk-reply-header">
                                            <div class="bug__user">
                                                <div class="bug__user-icon">
                                                    <img src="{{ getuser($history->user_id)->avatar_url }}" alt="user-icon">
                                                </div>
                                                <span class="bug__user-icon-name">{{ $history->user_name }}</span>
                                                <span class="bug__user-icon-name">({{ getuser($history->user_id)->email }})</span>
                                            </div>

                                            <div class="user-card flex-column align-items-start">
                                                <div class="user-name text-left">
                                                    <div class="nk-reply-entry entry">
                                                        @php $texts = explode('<br>', $history->text); @endphp
                                                        @foreach($texts as $text)
                                                            <p>{{ $text }}</p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="date-time">{{ $history->updated_at }}</div>
                                        </div>
                                        @if(isset($history->attachment) && $history->attachment != '')
                                            <div class="attach-files">
                                                <ul class="attach-list">
                                                    <li class="attach-item">
                                                        <a class="download" href="/storage/{{ $history->attachment }}" target="_blank">
                                                            <em class="icon ni ni-img"></em>
                                                            <span>{{ __('Вложение') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                @else

                                    <div class="nk-reply-item support-block">
                                        <div class="nk-reply-header">
                                            <div class="bug__user">
                                                <div class="bug__user-icon">
                                                    <img src="{{ getuser($history->user_id)->avatar_url }}" alt="user-icon">
                                                </div>
                                                <span class="bug__user-icon-name">{{ __('Агент Поддержки') }} #{{ $history->user_id }}</span>
                                                @can('support')
                                                    <span class="bug__user-icon-name">({{ $history->user_name }})</span>
                                                @endcan
                                            </div>

                                            <div class="user-card flex-column align-items-start">
                                                <div class="user-name text-left">
                                                    <div class="nk-reply-entry entry">
                                                        @php $texts = explode('<br>', $history->text); @endphp
                                                        @foreach($texts as $text)
                                                            <p>{{ $text }}</p>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="date-time">{{ $history->updated_at }}</div>
                                        </div>

                                        @if(isset($history->attachment) && $history->attachment != '')
                                            <div class="attach-files">
                                                <ul class="attach-list">
                                                    <li class="attach-item">
                                                        <a class="download" href="/storage/{{ $history->attachment }}" target="_blank">
                                                            <em class="icon ni ni-img"></em>
                                                            <span>{{ __('Вложение') }}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        @endif
                                    </div>

                                @endif

                            @endforeach


                        @else

                            <div class="nk-reply-item">
                                <div class="nk-reply-header">
                                    <div class="user-card flex-column align-items-start">
                                        <div class="user-name text-left">{{ $ticket->user->name }}</div>
                                        <div class="ml-3 text-gray">{{ $ticket->user->email }}</div>
                                    </div>
                                    <div class="date-time">{{ $ticket->created_at->format('d.m.Y H:i') }}</div>
                                </div>
                                <div class="nk-reply-body">
                                    <div class="nk-reply-entry entry">
                                        @php $texts = explode('<br>', $ticket->question); @endphp
                                        @foreach($texts as $text)
                                            <p>{{ $text }}</p>
                                        @endforeach
                                    </div>
                                    @if($ticket->attachment)
                                        <div class="attach-files">
                                            <ul class="attach-list">
                                                <li class="attach-item">
                                                    <a class="download" href="{{ $ticket->image_url }}" target="_blank">
                                                        <em class="icon ni ni-img"></em>
                                                        <span>{{ __('Изображение') }}</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                            </div>


                            @if($ticket->answer)
                                <div class="nk-reply-item">
                                    <div class="nk-reply-header">
                                        <div class="user-card flex-column align-items-start">
                                            <div class="user-name text-left">
                                                {{ __('Агент Поддержки') }} #{{ $ticket->answerer_id }}
                                                @can('support')
                                                    ({{ $ticket->answerer_id }})
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="date-time">{{ $ticket->updated_at->format('d.m.Y H:i') }}</div>
                                    </div>
                                    <div class="nk-reply-body">
                                        <div class="nk-reply-entry entry">
                                            @php $texts = explode('<br>', $ticket->answer); @endphp
                                            @foreach($texts as $text)
                                                <p>{{ $text }}</p>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endif


                        @if(!$ticket->trashed() && $ticket->status != 0)
                            <div class="nk-reply-form">
                                <div class="nk-reply-form-header">
                                    <ul class="nav nav-tabs-s2 nav-tabs nav-tabs-sm">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#reply-form">{{ __('Ваш ответ') }}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="reply-form">
                                        <form action="{{ route('tickets.update', $ticket) }}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="nk-reply-form-editor">
                                                <div class="nk-reply-form-field">
                                                    <textarea class="form-control form-control-simple no-resize p-3" name="answer" id="answer" placeholder="{{ __('Ваш ответ') }}..."></textarea>
                                                </div>
                                                <div class="nk-reply-form-field">
                                                    <div class="form-group">
                                                        <label class="form-label" for="attachment">{{ __('Вложение') }}</label>
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
                                                <div class="nk-reply-form-tools" style="justify-content: flex-end;">
                                                    <ul class="nk-reply-form-actions g-1">
                                                        <li class=""><button class="btn btn-primary" type="submit" disabled id="bugAnswer" style="width: 150px;"><span>{{ __('Ответить') }}</span></button></li>
                                                    </ul>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#answer').keyup(function() {
            console.log($(this).val().length);
            if ($(this).val().length > 1) {
                $('#bugAnswer').prop("disabled", false);
            } else {
                $('#bugAnswer').prop("disabled", true);
            }
        });
    </script>
@endpush
