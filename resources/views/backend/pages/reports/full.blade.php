@php
    if(isset($report) && $report->history !== NULL) {
        $histories = json_decode($report->history);
    }
@endphp

@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Баг трекер'))
@section('headerTitle', __('Баг трекер'))
@section('headerDesc', '')

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2" style="text-transform: uppercase;">{{ $report->title }}</span>
                                @if ($report->trashed())
                                    <span class="badge badge-gray">{{ __('Удалён') }}</span>
                                @elseif ($report->status === 1)
                                    <span class="badge badge-newreport">{{ getReportStatusNameById('1') }}</span>
                                @elseif ($report->status === 2)
                                    <span class="badge badge-needmore">{{ getReportStatusNameById('2') }}</span>
                                @elseif ($report->status === 3)
                                    <span class="badge badge-reportconfirmed">{{ getReportStatusNameById('3') }}</span>
                                @elseif ($report->status === 4)
                                    <span class="badge badge-inprogress">{{ getReportStatusNameById('4') }}</span>
                                @elseif ($report->status === 5)
                                    <span class="badge badge-underreview">{{ getReportStatusNameById('5') }}</span>
                                @elseif ($report->status === 6)
                                    <span class="badge badge-revieweddev">{{ getReportStatusNameById('6') }}</span>
                                @elseif ($report->status === 7)
                                    <span class="badge badge-invalid">{{ getReportStatusNameById('7') }}</span>
                                @elseif ($report->status === 8)
                                    <span class="badge badge-resolved">{{ getReportStatusNameById('8') }}</span>
                                @endif

                            </h5>
                        </div>
                    </div>

                    <div class="card-inner p-0 border-top">

                        <div class="nk-reply-item">
                            <div class="nk-reply-header">
                                <div class="user-card flex-column align-items-start">
                                    <div class="user-name text-left" style="font-size: 20px;margin-bottom: 26px;">{{ $report->title }}</div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Приоритет') }}: <span>{{ getReportPriorityNameById($report->priority) }}</span></div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Персонаж') }}: <span>@if($character = getGameCharacter($report->char_id)) {{ $character->name }} @else {{ __('не указан') }} @endif</span></div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Категория') }}: <span style="margin-right: 50px;">{{ getReportCategoryNameById($report->category_id) }}</span> {{ __('Подкатегория') }}: <span>{{ getSubcategoryNameById($report->category_id) }}</span></div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;"></div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('ID') }}: <span>
                                            @if($report->comment != '')
                                                @if($report->category_id == '1')
                                                    <a href="https://wowhead.com/achievement={{ $report->comment }}" target="_blank">https://wowhead.com/achievement={{ $report->comment }}</a>
                                                @elseif($report->category_id == '3')
                                                    <a href="https://wowhead.com/spell={{ $report->comment }}" target="_blank">https://wowhead.com/spell={{ $report->comment }}</a>
                                                @elseif($report->category_id == '7')
                                                    <a href="https://wowhead.com/item={{ $report->comment }}" target="_blank">https://wowhead.com/item={{ $report->comment }}</a>
                                                @elseif($report->category_id == '10')
                                                    <a href="https://wowhead.com/quest={{ $report->comment }}" target="_blank">https://wowhead.com/quest={{ $report->comment }}</a>
                                                @else
                                                    {{ $report->comment }}
                                                @endif
                                            @endif
                                        </span>
                                    </div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Ссылка') }}: <span>{{ $report->link }}</span></div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;color: #b90000;">Trello {{ __('Ссылка') }}: <span><a href="{{ $report->link_trello }}" target="_blank" style="color: #b90000;">{{ $report->link_trello }}</a></span></div>
                                    <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Доказательства') }}:</div>

                                </div>
                                <div class="date-time">{{ $report->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="nk-reply-body" style="margin-top: 10px;">
                                <div class="nk-reply-entry entry">
                                    <p>{!! str_replace("\r\n", "<br>", $report->question) !!}</p>
                                </div>
                                @if($report->attachment)
                                    <div class="attach-files">
                                        <ul class="attach-list">
                                            <li class="attach-item">
                                                <a class="download" href="{{ $report->attachment_url }}" target="_blank">
                                                    <em class="icon ni ni-img"></em>
                                                    <span>{{ __('Изображение') }}</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if(isset($histories))

                            @foreach($histories as $history)

                                @if($history->type == 'question')

                                    <div class="nk-reply-item" style="margin-bottom: 50px;">
                                        <div class="nk-reply-header">
                                            <div class="user-card flex-column align-items-start">
                                                <div class="user-name text-left">{{ getuser($history->user_id)->name}}</div>
                                            </div>
                                            <div class="date-time">{{ date('d/m/Y H:i', strtotime($history->updated_at)) }}</div>
                                        </div>
                                        <div class="nk-reply-body">
                                            <div class="nk-reply-entry entry">
                                                <form action="{{ route('backend.reports.reply.update', $report) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="reply_index" value="{{ $loop->iteration }}">

                                                    <textarea type="text" class="form-control" id="reply-{{ $loop->iteration }}" name="reply" style="min-height: auto;">{{ $history->text }}</textarea>
                                                    <ul class="nk-reply-form-actions g-1" style="display: flex;float: right;padding-top: 15px;">
                                                        <li class="mr-2">
                                                            <button class="btn btn-primary" type="submit">{{ __('Обновить') }}</button>
                                                        </li>
                                                    </ul>
                                                </form>

                                                @if(isset($history->attachment))
                                                    <div class="attach-files">
                                                        <ul class="attach-list">
                                                            <li class="attach-item">
                                                                <a class="download" href="{{ get_image_url($history->attachment) }}" target="_blank">
                                                                    <em class="icon ni ni-img"></em>
                                                                    <span>{{ __('Изображение') }}</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>


                                @else

                                    <div class="nk-reply-item" style="margin-bottom: 50px;">
                                        <div class="nk-reply-header">
                                            <div class="user-card flex-column align-items-start">
                                                <div class="user-name text-left">
                                                    {{ __('Ответ от') }} @if(getuser($history->user_id)->role == 'support') {{ '<GM>' }}
                                                    @elseif(getuser($history->user_id)->role == 'admin') {{ '<Administrator>' }} @endif {{ getuser($history->user_id)->name }}
                                                </div>
                                            </div>
                                            <div class="date-time">{{ date('d/m/Y H:i', strtotime($history->updated_at)) }}</div>
                                        </div>
                                        <div class="nk-reply-body">
                                            <div class="nk-reply-entry entry">
                                                <form action="{{ route('backend.reports.reply.update', $report) }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="reply_index" value="{{ $loop->iteration }}">

                                                    <textarea type="text" class="form-control" id="reply-{{ $loop->iteration }}" name="reply" style="min-height: auto;">{{ $history->text }}</textarea>
                                                    <ul class="nk-reply-form-actions g-1" style="display: flex;float: right;padding-top: 15px;">
                                                        <li class="mr-2">
                                                            <button class="btn btn-primary" type="submit">{{ __('Обновить') }}</button>
                                                        </li>
                                                    </ul>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @endif

                            @endforeach


                        @else


                            @if ($report->answer)
                                <div class="nk-reply-item">
                                    <div class="nk-reply-header">
                                        <div class="user-card flex-column align-items-start">
                                            <div class="user-name text-left">
                                                {{ __('Агент Поддержки') }} #{{ $report->answerer_id }}
                                                @can('support')
                                                    ({{ $report->answerer_id }})
                                                @endcan
                                            </div>
                                        </div>
                                        <div class="date-time">{{ $report->updated_at->format('d/m/Y H:i') }}</div>
                                    </div>
                                    <div class="nk-reply-body">
                                        <div class="nk-reply-entry entry">
                                            <p>{{ $report->answer }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endif

                        @if (auth()->user()->can('support') && !$report->trashed() && $report->status != 0)
                            <div class="col-12" style="padding: 2rem 2.5rem;margin-top: 25px;">
                                <div class="row g-4">
                                    <div class="col-lg-6">

                                        <form action="{{ route('backend.reports.answer', $report) }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label class="form-label" for="answer">{{ __('Ответ') }}</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control" id="answer"
                                                              name="answer"></textarea>
                                                </div>
                                            </div>
                                            <ul class="nk-reply-form-actions g-1">
                                                <li class="mr-2">
                                                    <button class="btn btn-primary"
                                                            type="submit">{{ __('Отправить') }}</button>
                                                </li>
                                            </ul>
                                        </form>
                                    </div>

                                    <div class="col-lg-6">

                                        <form action="{{ route('backend.reports.status.change') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="report_id" value="{{ $report->id }}">

                                            <div class="form-group">
                                                <label class="form-label" for="status">{{ __('Статус') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="status" name="status" class="form-select">
                                                        @foreach(getReportStatuses() as $key => $value)
                                                            <option value="{{ $key }}"
                                                                    @if(isset($report) && $report->status == $key) selected @endif>{{ $value }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="" id="link_trello-froup" style="@if ($report->status != 3) display: none; @endif margin-bottom: 20px;">
                                                <div class="form-group">
                                                    <label class="form-label" for="link_trello">Trello {{ __('Ссылка') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="link_trello" name="link_trello"
                                                               value="{{ $report->link_trello }}">
                                                        @error('link_trello')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <ul class="nk-reply-form-actions g-1">
                                                <li class="mr-2">
                                                    <button class="btn btn-primary btn-close"
                                                            type="submit">{{ __('Изменить') }}</button>
                                                </li>
                                            </ul>
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
    <!-- .nk-block -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#subcategory_id_1 option').each(function() {

                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_1_group').show();
                }
            });
            $('#subcategory_id_2 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_2_group').show();
                }
            });
            $('#subcategory_id_3 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_3_group').show();
                }
            });
            $('#subcategory_id_4 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_4_group').show();
                }
            });
            $('#subcategory_id_5 option').each(function() {
                if ($(this).prop('selected') == true && $(this).val() > 0) {
                    $('#subcategory_id_5_group').show();
                }
            });

            $('#status').change(function() {
                if ($('#status').val() == '3') { //Report confirmed
                    $('#link_trello-froup').show();
                } else {
                    $('#link_trello-froup').hide();
                }
            });
        });

    </script>
@endpush
