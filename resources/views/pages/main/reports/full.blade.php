@extends('layouts.main')

@section('title', $report->title . ' - ' . config('options.main_title_'.app()->getLocale(), '') )

@section('content')

    <div class="sparks-wrapper">
        <picture>
            <source type="image/webp" srcset="img/bottom-sparks.webp">
            <img src="img/bottom-sparks.png" alt="sparks">
        </picture>
    </div>

    <main class="main-padding news-body">

        <div class="top-wrapper">
            <section class="bug">
                <div class="bug__container main-container">
                    <div class="bug__body">
                        <h1 class="bug__title main-title">
                            {{ __('Баг трекер') }}
                        </h1>

                        <a href="{{ route('reports') }}" class="bug__return">
                            <img src="/img/features/arrow-left.svg" alt="arrow-left">
                            <span>{{ __('Вернуться к Баг Трекеру') }}</span>
                        </a>

                        <div class="bug__box">

                            <div class="b-tracker__block b-tracker__block_details">

                                <div class="b-tracker__defs-grid grid-report-details">

                                    <div class="b-tracker__defs-col b-tracker_details">
                                        <div class="state__item state__item--pending">
                                            <span>ID</span>
                                        </div>
                                            <div class="b-tracker__defs-info">
                                                <p>{{ $report->id }}</p>
                                            </div>
                                    </div>
                                    <div class="b-tracker__defs-col b-tracker_details">
                                        <div class="state__item state__item--pending">
                                            <span>{{ __('Дата создания') }}</span>
                                        </div>
                                        <div class="b-tracker__defs-info">
                                            <p>{{ $report->created_at->format('d/m/Y H:i') }}</p>
                                        </div>
                                    </div>

                                    {{--
                                        <div class="b-tracker__defs-col b-tracker_details">
                                            <div class="state__item state__item--pending">
                                                <span>{{ __('Заголовок') }}</span>
                                            </div>
                                            <div class="b-tracker__defs-info">
                                                <p>{{ $report->title }}</p>
                                            </div>
                                        </div>

                                            <div class="b-tracker__defs-col b-tracker_details">
                                                <div class="state__item state__item--pending">
                                                    <span>{{ __('Создатель') }}</span>
                                                </div>
                                                <div class="b-tracker__defs-info">
                                                    <div class="bug__user report-full-bug__user">
                                                        <div class="bug__user-icon">
                                                            <img src="{{ getuser($report->user_id)->avatar_url }}" alt="user-icon">
                                                        </div>
                                                        <p>{{ getuser($report->user_id)->name }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        --}}
                                    <div class="b-tracker__defs-col b-tracker_details">
                                        <div class="state__item state__item--pending">
                                            <span>{{ __('Игровой мир') }}</span>
                                        </div>
                                        <div class="b-tracker__defs-info">
                                            <p>{{ getserver($report->server)->name }}</p>
                                        </div>
                                    </div>
                                    <div class="b-tracker__defs-col b-tracker_details">
                                        <div class="state__item state__item--pending">
                                            <span>{{ __('Категория') }}</span>
                                        </div>
                                        <div class="b-tracker__defs-info">
                                            <p>{{ getReportCategoryNameById($report->category_id) }}</p>
                                        </div>
                                    </div>
                                    <div class="b-tracker__defs-col b-tracker_details">
                                        <div class="state__item state__item--pending">
                                            <span>{{ __('Подкатегория') }}</span>
                                        </div>
                                        <div class="b-tracker__defs-info">
                                            <p>{{ getSubcategoryNameById($report->subcategory_id) }}</p>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="b-tracker__defs-col b-tracker_details flex-start">
                                <div class="state__item state__item--pending">
                                    <span>{{ __('Статус') }}</span>
                                </div>
                                <div class="b-tracker__defs-info">
                                    <div class="state__item state__item--{{ getReportStatusClassById($report->status) }}">
                                        <div class="state__icon">
                                            <svg width="10px" height="7px">
                                                <use href="/img/sprite/sprite.svg#{{ getReportStatusIconById($report->status) }}"></use>
                                            </svg>
                                        </div>
                                        <span>{{ getReportStatusNameById($report->status) }}</span>
                                        @if($report->is_lock === 1)
                                            <span class="lock"><img src="/img/info/lock.svg" alt="lock" title="lock"></span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if(auth()->check() && auth()->user()->isGMAdmin())
                                <div class="nk-reply-header" style="padding: 15px;">
                                    <div class="user-card flex-column align-items-start">
                                        <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Приоритет') }}: <span>{{ getReportPriorityNameById($report->priority) }}</span></div>
                                        <div class="user-name text-left" style="margin-bottom: 10px;">{{ __('Персонаж') }}: <span>@if($character = getGameCharacter($report->char_id)) {{ $character->name }} @else {{ __('не указан') }} @endif</span></div>
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
                                </div>
                            @endif

                            <div class="bug__chat">

                                    @foreach($histories as $history)
                                        @if($history->type == 'question')
                                            @php $user = getuser($history->user_id); @endphp

                                            <div class="bug__message @if($history->user_id === $report->user_id){{ 'bug__message_owner' }}@endif">
                                                @if($history->user_id === $report->user_id)
                                                    <div class="bug__message-original">{{ __('оригинальный постер') }}</div>
                                                @elseif($user->getAccountGMLvl() >= 2)
                                                    <div class="bug__message-original red">{{ __('поддержка') }}</div>
                                                @endif
                                                <div class="bug__message-bg"></div>
                                                <div class="bug__user">
                                                    <div class="bug__user-icon">
                                                        <img src="{{ getuser($history->user_id)->avatar_url }}" alt="user-icon">
                                                    </div>
                                                    <span class="bug__user-icon-name">{{ getuser($history->user_id)->name }}</span>
                                                </div>
                                                <div class="bug__output">
                                                    <div class="bug__message-text">
                                                        @if($loop->first)
                                                            <div class="bug__heading">
                                                                <div class="bug__box-head">
                                                                    {{ $report->title }}
                                                                </div>
                                                            </div>

                                                            <div class="b-tracker__block">
                                                                <div class="b-tracker__title">{{ __('Описание') }}:</div>
                                                                <div class="step-description">
                                                                    <p>{{ $report->question }}</p>
                                                                    @if($report->attachment !== NULL)
                                                                        <p><img src="{{ $report->attachment_url }}" alt="attachment"></p>
                                                                    @endif
                                                                </div>
                                                                <div class="step-description">
                                                                    <hr>
                                                                </div>
                                                            </div>

                                                            <div class="b-tracker__block">
                                                                <div class="b-tracker__title">{{ __('Репликация') }}:</div>

                                                                @foreach($steps as $step)
                                                                    <div class="step-description">
                                                                        <span>{{ __('Шаг') }} {{ $loop->iteration }}</span>
                                                                        <p>{{ $step }}</p>
                                                                    </div>
                                                                @endforeach

                                                                <div class="step-description">
                                                                    <span>{{ __('Ожидаемый результат') }}</span>
                                                                    <p>{{ $report->expected_result }}</p>
                                                                </div>

                                                                @if($report->comment !== NULL && $report->comment !== '')
                                                                <div class="step-description step-comments">
                                                                    <span>{{ __('Комментарий') }}</span>
                                                                    <p>{{ $report->comment }}</p>
                                                                </div>
                                                                @endif

                                                            </div>
                                                        @else
                                                            <p>{!! getFormatText($history->text) !!}</p>
                                                            @if(isset($history->attachment))
                                                                <div class="attach-files">
                                                                    <ul class="attach-list">
                                                                        <li class="attach-item">
                                                                            <a class="attachment" href="{{ get_image_url($history->attachment) }}" target="_blank">
                                                                                <img src="/img/sprite/paperclip-icon.svg" class="form__inputs-paper" alt="paperclip-icon">
                                                                                <span>{{ __('Изображение') }}</span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    <div class="bug__message-date">
                                                        {{ date('d/m/Y H:i', strtotime($history->updated_at)) }}
                                                    </div>
                                                    @if($loop->first)
                                                        <div class="bug__message-date actions">
                                                            <div class="info__fame">
                                                                <div class="info__fame-item like" data-report_uuid="{{ $report->id }}">
                                                                    <img src="/img/sprite/like-icon.png" alt="like-icon">
                                                                    <span class="like-count">{{ $report->like }}</span>
                                                                </div>
                                                                <div class="info__fame-item dislike" data-report_uuid="{{ $report->id }}">
                                                                    <img src="/img/sprite/dislike-icon.png" alt="dislike-icon">
                                                                    <span class="dislike-count">{{ $report->dislike }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="b-tracker__defs-info">
                                                                @php $replicate_users = json_decode($report->replicate_users); @endphp
                                                                <div class="info__replicate-block replicate replicate-full protip tracker__create btn @if(is_array($replicate_users) && in_array(auth()->id(), $replicate_users)){{ '' }}@else{{ 'btn-orange' }}@endif" data-pt-title="{{ __('нажмите здесь, если вы можете воспроизвести эту ошибку на своей стороне, как описано') }}" data-report_uuid="{{ $report->uuid }}">
                                                                    <span>{{ __('Я могу воспроизвести') }}</span>
                                                                    <span class="info__replicate-value replicate-count">{{ $report->replicate }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                        @else

                                            <div class="bug__message bug__message_answer">
                                                <div class="bug__message-original red">{{ __('поддержка') }}</div>

                                                <div class="bug__user">
                                                    <div class="bug__user-icon bug__user-icon-admin">
                                                        <img src="{{ getuser($history->user_id)->avatar_url }}" alt="user-icon">
                                                    </div>
                                                    <span class="bug__user-icon-name">{{ getuser($history->user_id)->name }}</span>
                                                </div>
                                                <div class="bug__output">
                                                    <div class="bug__message-text">
                                                        <p>
                                                            {{ $history->text }}
                                                        </p>
                                                        @if(isset($history->attachment))
                                                            <div class="attach-files">
                                                                <ul class="attach-list">
                                                                    <li class="attach-item">
                                                                        <a class="download" href="{{ get_image_url($history->attachment) }}" target="_blank">
                                                                            <img src="/img/sprite/paperclip-icon.svg" class="form__inputs-paper" alt="paperclip-icon">
                                                                            <span>{{ __('Изображение') }}</span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="bug__message-date">
                                                        {{ date('d/m/Y H:i', strtotime($history->updated_at)) }}
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                    @endforeach

                            </div>


                            @if(!in_array($report->status, [3,5]) && $report->is_lock !== 1)
                                <form action="{{ route('reports.reply', $report) }}" method="post" enctype="multipart/form-data">
                                    @csrf

                                    <div class="bug__send">
                                        <div class="bug__user">
                                            <div class="bug__user-icon">
                                                <img src="{{ auth()->user()->avatar_url }}" alt="user-icon">
                                            </div>
                                            <span class="bug__user-icon-name">{{ auth()->user()->name }}</span>
                                        </div>

                                        <div class="flex-column">
                                            <div class="bug__input">
                                                <textarea placeholder="{{ __('Ваш ответ') }}..." name="answer" id="answer"></textarea>
                                            </div>

                                            <div class="form__inputs-item form__inputs-item--file">
                                                <label class="form__dd-file" for="upload">
                                                    <img src="/img/sprite/paperclip-icon.svg" class="form__inputs-paper" alt="paperclip-icon">
                                                    <span class="form__dd-file-drop">{{ __('Перетащите файлы сюда') }}</span>
                                                    <span class="form__dd-file-max">{{ __('Максимальный размер файла 20МБ') }}</span>
                                                    <span class="form__dd-file-max bug-alert-text">{{ __('Для изображений Вы можете использовать imgur.com, а для видео — YouTube') }}</span>
                                                    <input type="file" id="upload" name="attachment" accept="image/*, video/*">
                                                </label>
                                            </div>
                                            <div class="bug__button">
                                                <button class="bug__send btn" id="bugSend" disabled>
                                                    <span>{{ __('Отправить сообщение') }}</span>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </div>

        @include('partials.main.offer')

    </main>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#like').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('reports.like', $report) }}",
                    dataType: "json",
                    data: { like: 'like', _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    console.log(data);
                    if(data.status == 'success') {
                        $('.like-count').text(data.count);
                    }
                });
            });
            $('#dislike').click(function() {
                $.ajax({
                    type: "POST",
                    url: "{{ route('reports.like', $report) }}",
                    dataType: "json",
                    data: { like: 'dislike', _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    console.log(data);
                    if(data.status == 'success') {
                        $('.dislike-count').text(data.count);
                    }
                });
            });

            $('.like').click(function() {
                let report = $(this);
                $.ajax({
                    type: "POST",
                    url: "/bugs/" + report.data('report_uuid') + "/like",
                    dataType: "json",
                    data: { like: 'like', _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    if(data.status == 'success') {
                        report.find('.like-count').text(data.count);
                    }
                });
            });
            $('.dislike').click(function() {
                let report = $(this);
                $.ajax({
                    type: "POST",
                    url: "/bugs/" + report.data('report_uuid') + "/like",
                    dataType: "json",
                    data: { like: 'dislike', _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    if(data.status == 'success') {
                        report.find('.dislike-count').text(data.count);
                    }
                });
            });
            $('.replicate').click(function() {
                let report = $(this);
                $.ajax({
                    type: "POST",
                    url: "/bugs/" + report.data('report_uuid') + "/replicate",
                    dataType: "json",
                    data: { _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    if(data.status == 'success') {
                        report.find('.replicate-count').text(data.count);
                        report.removeClass('btn-orange');
                    }
                });
            });

            $('#answer').keyup(function() {
                console.log($(this).val().length);
                if ($(this).val().length > 1) {
                    $('#bugSend').prop("disabled", false);
                } else {
                    $('#bugSend').prop("disabled", true);
                }
            });

        });

        function ShowEdit(index) {
            $('#reply-'+index).show();
            $('#answer-'+index).hide();
        }
    </script>
@endpush
