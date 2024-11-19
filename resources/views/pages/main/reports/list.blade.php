@extends('layouts.main')

@section('title', __('Баг трекер') . ' - ' . config('options.main_title_'.app()->getLocale(), '') )

@section('content')

    <div class="sparks-wrapper">
        <picture>
            <source type="image/webp" srcset="/img/bottom-sparks.webp">
            <img src="/img/bottom-sparks.png" alt="sparks">
        </picture>
    </div>

    <main class="main-padding news-body" style="background-image: url(/img/bug-tracker/bug-tracker-bg.webp);">

        <div class="top-wrapper">
            <section class="b-tracker">
                <div class="b-tracker__container main-container">
                    <div class="b-tracker__body">
                        <h1 class="b-tracker__head main-title">
                            {{ __('Баг трекер') }}
                        </h1>

                        {{-- Alert --}}
                        @foreach (['danger', 'warning', 'success', 'info'] as $type)
                            @if(Session::has('alert.' . $type))
                                @foreach(Session::get('alert.' . $type) as $message)
                                    <div class="alert alert-fill alert-{{ $type }} alert-dismissible alert-icon">
                                        @if ($type === 'danger')
                                            <em class="icon ni ni-cross-circle"></em>
                                        @elseif($type === 'success')
                                            <em class="icon ni ni-check-circle"></em>
                                        @else
                                            <em class="icon ni ni-alert-circle"></em>
                                        @endif
                                        {{ $message }}
                                        <button class="close" data-dismiss="alert"></button>
                                    </div>
                                @endforeach
                            @endif
                        @endforeach
                        {{-- End Alert --}}

                        <div class="b-tracker__box bug__box">

                            {!! config('options.reports_description_'.app()->getLocale()) !!}


                            <div class="b-tracker__block">
                                <form action="" method="POST">
                                    @csrf

                                    <div class="tracker__dropdowns">
                                        <div class="dropdowns">

                                            {{--
                                            <div class="custom-select">
                                                <select name="priority_id" id="priority_id" class="form-control selectpicker">
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите приоритет') }}</option>
                                                    @foreach(getListPriorityName() as $key => $value)
                                                        <option value="{{ $key }}" @if(app('request')->input('priority_id') == $key) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            --}}

                                            <div class="custom-select">
                                                <select name="priority_id" id="priority_id" class="form-control selectpicker">
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите приоритет') }}</option>
                                                    <option value="1" @if(app('request')->input('priority_id') == 1) selected @endif>{{ __('Самые срочные') }}</option>
                                                    <option value="2" @if(app('request')->input('priority_id') == 2) selected @endif>{{ __('Самые старые') }}</option>
                                                    <option value="3" @if(app('request')->input('priority_id') == 3) selected @endif>{{ __('Самые воспроизводимые') }}</option>
                                                </select>
                                            </div>
                                            <div class="custom-select">
                                                <select name="status_id" id="status_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите статус') }}</option>
                                                    @foreach(getReportStatuses() as $key => $value)
                                                        <option value="{{ $key }}" @if(app('request')->input('status_id') == $key) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="custom-select">
                                                <select name="category_id" id="category_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите категорию') }}</option>
                                                    @foreach(getListCategoryName() as $key => $value)
                                                        <option value="{{ $key }}" @if(app('request')->input('category_id') == $key) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="custom-select">
                                                <select name="subcategory_id" id="subcategory_id" class="form-control selectpicker white-grey bs-select-hidden">
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите подкатегорию') }}</option>
                                                    @if(app('request')->input('category_id') == 3)
                                                        @foreach(getListSubcategoryName(app('request')->input('category_id')) as $key => $value)
                                                            <option value="{{ $key }}" @if(app('request')->input('subcategory_id') == $key) selected @endif>{{ $value }}</option>
                                                        @endforeach
                                                    @elseif(app('request')->input('category_id') == 5)
                                                        @foreach(getListExploitsName() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    @elseif(app('request')->input('category_id') == 6)
                                                        @foreach(getListInstancesName() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    @elseif(app('request')->input('category_id') == 8)
                                                        @foreach(getListOtherName() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    @elseif(app('request')->input('category_id') == 9)
                                                        @foreach(getListProfessionsName() as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tracker__filter">
                                        <div class="tracker__search">
                                            <input type="search" id="search" name="search" placeholder="{{ __('Поиск') }}" value="{{ request()->query('search') }}">
                                            <div class="tracker__search-icon">
                                                <img src="/img/sprite/search-icon.svg" alt="search-icon">
                                            </div>
                                        </div>
                                        <div class="tracker__filter-options">
                                            <div class="tracker__check">
                                                <input id="opened" name="opened" type="checkbox" @if(request()->query('opened') == '1'){{ 'checked="checked"' }}@endif>
                                                <label for="opened-requests">
                                                    {{ __('Показать открытые запросы') }}
                                                </label>
                                            </div>
                                            <div class="tracker__check">
                                                <input id="closed" name="closed" type="checkbox" @if(request()->query('closed') == '1'){{ 'checked="checked"' }}@endif>
                                                <label for="opened-requests">
                                                    {{ __('Показать закрытые запросы') }}
                                                </label>
                                            </div>
                                            <div class="tracker__buttons">
                                                <a href="{{ route('reports') }}" class="tracker__reset">
                                                    <span>{{ __('Сбросить') }}</span>
                                                </a>
                                                <a href="{{ route('reports.create') }}" class="tracker__create btn">
                                                    <span>{{ __('Отправить ошибку') }}</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <div class="b-tracker__block">
                                <div class="info">

                                    @foreach($reports as $report)
                                        @php $histories = json_decode($report->history); @endphp
                                        <div class="info__row">
                                        <div class="info__index">
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
                                            <div class="info__data">
                                                <div class="info__top">
                                                    <div class="info__data-order">
                                                        [{{ $report->id }}]
                                                    </div>
                                                    <div class="info__data-content">
                                                        <a href="{{ route('reports.show', $report) }}">
                                                            <span class="report-title show-info"
                                                                  data-description="{{ Str::limit($report->question, 2000) }}"
                                                                  data-title="{{ Str::limit($report->title, 100) }}"
                                                                  data-user_avatar="{{ $report->user->avatar_url }}"
                                                                  data-user_name="{{ $report->user->name }}"
                                                                  data-created_at="{{ getmonthname(date('m', strtotime($report->created_at))) }} {{ date('d', strtotime($report->created_at)) }}, {{ date('Y', strtotime($report->created_at)) }}"
                                                            >{{ Str::limit($report->title, 100) }}
                                                                @if($report->is_lock === 1)
                                                                    <span class="lock"><img src="/img/info/lock.svg" alt="lock" title="lock"></span>
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="info__breadcrumbs">
                                                    <span>{{ getserver($report->server)->name }}</span>
                                                    <img src="/img/bug-tracker/arrow-right.svg" width="4px" alt="arrow-right">
                                                    <span>{{ getReportCategoryNameById($report->category_id) }}</span>
                                                    <img src="/img/bug-tracker/arrow-right.svg" width="4px" alt="arrow-right">
                                                    <span>{{ getSubcategoryNameById($report->subcategory_id) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                            {{--
                                            <div class="state__item state__item--pending">
                                                <span>{{ getReportPriorityNameById($report->priority) }}</span>
                                            </div>
                                            --}}

                                        <div class="state__item state__item--{{ getReportStatusClassById($report->status) }}">
                                            <div class="state__icon">
                                                <svg width="10px" height="7px">
                                                    <use href="/img/sprite/sprite.svg#{{ getReportStatusIconById($report->status) }}"></use>
                                                </svg>
                                            </div>
                                            <span>{{ getReportStatusNameById($report->status) }}</span>
                                        </div>

                                        <div class="info__messages">
                                            <div class="info__messages-icon">
                                                <img src="/img/sprite/chat-icon.svg" alt="chat-icon">
                                            </div>
                                            <span>@if(is_array($histories)){{ count($histories) }}@else{{ 0 }}@endif</span>
                                        </div>
                                        <div class="info__user">
                                            <div class="info__user-icon">
                                                <img src="{{ $report->user->avatar_url }}" alt="avatar-icon">
                                            </div>
                                            <div class="info__user-data">
                                                <div class="info__user-name">
                                                    {{ $report->user->name }}
                                                </div>
                                                <div class="info__user-date">
                                                    {{ __('Создано') }} {{ getmonthname(date('m', strtotime($report->created_at))) }} {{ date('d', strtotime($report->created_at)) }}, {{ date('Y', strtotime($report->created_at)) }}
                                                </div>
                                            </div>
                                        </div>
                                            @php $replicate_users = json_decode($report->replicate_users); @endphp
                                            <div class="info__replicate-block replicate protip tracker__create btn @if(is_array($replicate_users) && in_array(auth()->id(), $replicate_users)){{ '' }}@else{{ 'btn-orange' }}@endif" data-pt-title="{{ __('нажмите здесь, если вы можете воспроизвести эту ошибку на своей стороне, как описано') }}" data-report_uuid="{{ $report->uuid }}">
                                                <span>{{ __('Я могу воспроизвести') }}</span>
                                                <span class="info__replicate-value replicate-count">{{ $report->replicate }}</span>
                                            </div>

                                            @if(auth()->check() && auth()->user()->isGMAdmin())
                                                <div class="info__messages" style="justify-content: space-evenly; position: relative;">
                                                    <div class="dropdown-list">
                                                        <div class="dots">&#10247;</div>
                                                        <div class="dropdown-block">
                                                            <a href="{{ route('reports.lock', $report) }}">{{ __('Заблокировать') }}</a>
                                                            <a href="{{ route('reports.unlock', $report) }}">{{ __('Разблокировать') }}</a>
                                                            <a id="btnChangeStatus" data-report="{{ $report->id }}">{{ __('Изменить статус') }}</a>
                                                            <a href="{{ route('reports.delete', $report) }}" class="delete" onClick="return Confirm();">{{ __('Удалить') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif

                                    </div>
                                    @endforeach

                                </div>
                            </div>

                            <div class="pagination">
                                <div class="pagination__row">
                                      <span class="pagination__page">
                                        Page
                                      </span>
                                    <div class="pagination__order">
                                        <span>1</span>
                                        <img src="/img/sprite/arrow-down.svg" alt="arrow-down">
                                    </div>
                                    <span class="pagination__left">of 10</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        @include('partials.main.offer')

    </main>

    <div class="modal modal_success" id="report-info">
        <div class="modal__container">
            <div class="modal__body">
                <h1 class="modal__heading" id="report-title"></h1>
                <div class="info__user">
                    <div class="info__user-icon">
                        <img src="" alt="avatar-icon" id="report-user_avatar">
                    </div>
                    <div class="info__user-data">
                        <div class="info__user-name" id="report-user_name"></div>
                        <div class="info__user-date">
                            {{ __('Создано') }} <span id="report-created_at"></span>
                        </div>
                    </div>
                </div>
                <div class="modal__remember">
                    <div class="modal__check tracker__check">
                        <p id="report-description"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->check() && auth()->user()->isGMAdmin())
        <div class="modal modal_success" id="changeStatus">
            <div class="modal__container">
                <div class="modal__body">
                    <div class="modal__close">
                        <svg>
                            <use href="/img/sprite/sprite.svg#close-icon"></use>
                        </svg>
                    </div>
                    <div>
                        <h1 class="modal__heading">{{ __('Изменить статус репорта') }}</h1>
                        <form action="{{ route('reports.status.change') }}" method="POST" class="form">
                            @csrf
                            <input type="hidden" id="report_id" name="report_id" value="0">

                            <div class="form__wrapper bug__box">
                                <div class="form__inner">
                                    <div class="form__inputs">

                                        <div class="form__inputs-item">
                                            <div class="custom-select">
                                                <select name="status" id="status" class="form-control white-grey bs-select-hidden" required>
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите статус') }}</option>
                                                    @foreach(getReportStatuses() as $id => $status)
                                                        <option value="{{ $id }}" @if(app('request')->input('server') == $id) selected @endif>{{ $status }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form__buttons tracker__buttons">
                                        <button class="tracker__create btn">
                                            <span>{{ __('Изменить статус') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#category_id').change(function() {
                console.log($(this).val());
                $("#subcategory_id").empty();
                if ($(this).val() === '3') {
                    @foreach(getListSubcategoryName(app('request')->input('category_id')) as $key => $value)
                        $("#subcategory_id").append('<option value="{{ $key }}">{{ $value }}</option>');
                    @endforeach
                }
                else if ($(this).val() === '5') {
                    @foreach(getListExploitsName(app('request')->input('category_id')) as $key => $value)
                        $("#subcategory_id").append('<option value="{{ $key }}">{{ $value }}</option>');
                    @endforeach
                }
                else if ($(this).val() === '6') {
                    @foreach(getListInstancesName(app('request')->input('category_id')) as $key => $value)
                    $("#subcategory_id").append('<option value="{{ $key }}">{{ $value }}</option>');
                    @endforeach
                }
                else if ($(this).val() === '8') {
                    @foreach(getListOtherName(app('request')->input('category_id')) as $key => $value)
                    $("#subcategory_id").append('<option value="{{ $key }}">{{ $value }}</option>');
                    @endforeach
                }
                else if ($(this).val() === '9') {
                    @foreach(getListProfessionsName(app('request')->input('category_id')) as $key => $value)
                    $("#subcategory_id").append('<option value="{{ $key }}">{{ $value }}</option>');
                    @endforeach
                }
                else {
                    $("#subcategory_id").append('<option class="disabled" value="-1" selected="">{{ __('Подкатегии не доступны') }}</option>');
                }
            });

            let my_checked = '0';
            let my_opened = '0';
            let my_closed = '0';
            if($("#my").prop('checked')) {
                my_checked = '1';
            }
            if($("#opened").prop('checked')) {
                my_opened = '1';
            }
            if($("#closed").prop('checked')) {
                my_closed = '1';
            }
            $('#search').change(function() {
                window.location.href = '{{ route('reports') }}/?search=' + $('#search').val() + '&priority_id=' + $('#priority_id').val() + '&status_id=' + $('#status_id').val() + '&category_id=' + $('#category_id').val() + '&subcategory_id=' + $('#subcategory_id').val() + '&my=' + my_checked + '&opened=' + my_opened + '&closed=' + my_closed;
            });
            $('.selectpicker').change(function() {
                window.location.href = '{{ route('reports') }}/?search=' + $('#search').val() + '&priority_id=' + $('#priority_id').val() + '&status_id=' + $('#status_id').val() + '&category_id=' + $('#category_id').val() + '&subcategory_id=' + $('#subcategory_id').val() + '&my=' + my_checked + '&closed=' + my_closed;
            });
            $('#reset').click(function() {
                window.location.href = '{{ route('reports') }}';
            });
            $('#my').change(function() {
                if($("#my").prop('checked')) {
                    my_checked = '1';
                } else {
                    my_checked = '0';
                }
                window.location.href = '{{ route('reports') }}/?search=' + $('#search').val() + '&priority_id=' + $('#priority_id').val() + '&status_id=' + $('#status_id').val() + '&category_id=' + $('#category_id').val() + '&subcategory_id=' + $('#subcategory_id').val() + '&my=' + my_checked + '&opened=' + my_opened + '&closed=' + my_closed;
            });
            $('#opened').change(function() {
                if ($("#opened").prop('checked')) {
                    my_opened = '1';
                } else {
                    my_opened = '0';
                }
                my_closed = '0';
                $("#closed").prop('checked', false);
                window.location.href = '{{ route('reports') }}/?search=' + $('#search').val() + '&priority_id=' + $('#priority_id').val() + '&status_id=' + $('#status_id').val() + '&category_id=' + $('#category_id').val() + '&subcategory_id=' + $('#subcategory_id').val() + '&my=' + my_checked + '&opened=' + my_opened + '&closed=' + my_closed;
            });
            $('#closed').change(function() {
                if ($("#closed").prop('checked')) {
                    my_closed = '1';
                } else {
                    my_closed = '0';
                }
                my_opened = '0';
                $("#opened").prop('checked', false);
                window.location.href = '{{ route('reports') }}/?search=' + $('#search').val() + '&priority_id=' + $('#priority_id').val() + '&status_id=' + $('#status_id').val() + '&category_id=' + $('#category_id').val() + '&subcategory_id=' + $('#subcategory_id').val() + '&my=' + my_checked + '&opened=' + my_opened + '&closed=' + my_closed;
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
                    if(data.status === 'success') {
                        report.find('.replicate-count').text(data.count);
                        report.removeClass('btn-orange');
                    }
                });
            });


            $('#btnChangeStatus').click(function() {
                $('#changeStatus').addClass('show-modal');
                $('#report_id').val($(this).data('report'));
            });
            $('#changeStatus .modal__close').click(function() {
                $('#changeStatus').removeClass('show-modal');
            });


            //Всплытие окна с описанием
            let timeoutEnter; // Таймер для входа
            let timeoutLeave; // Таймер для выхода

            $('.show-info').mouseenter(function() {
                clearTimeout(timeoutLeave); // Очистить таймер выхода, чтобы окно не исчезло при наведении
                timeoutEnter = setTimeout(() => {
                    $('#report-info').addClass('show-modal');
                    $('#report-title').text($(this).data('title'));
                    $('#report-user_avatar').attr('src', $(this).data('user_avatar'));
                    $('#report-user_name').text($(this).data('user_name'));
                    $('#report-created_at').text($(this).data('created_at'));
                    $('#report-description').text($(this).data('description'));
                }, 1000); // Ожидание 3 секунд перед показом окна
            }).mouseleave(function() {
                clearTimeout(timeoutEnter); // Очистить таймер входа при выходе с элемента
                timeoutLeave = setTimeout(() => {
                    $('#report-info').removeClass('show-modal');
                }, 1000); // Ожидание 1 секунды перед скрытием окна
            });

            $('#report-info').mouseenter(function() {
                clearTimeout(timeoutLeave); // Очистить таймер выхода, чтобы окно осталось открытым
            }).mouseleave(function() {
                clearTimeout(timeoutEnter); // Очистить таймер входа, чтобы окно закрылось после выхода с окна
                timeoutLeave = setTimeout(() => {
                    $('#report-info').removeClass('show-modal');
                }, 1000); // Ожидание 1 секунды перед скрытием окна
            });

            // Дополнительно, чтобы окно скрывалось при клике вне него
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.show-info').length && !$(event.target).closest('#report-info .modal__body').length) {
                    $('#report-info').removeClass('show-modal');
                }
            });

        });

        function Confirm() {
            if (confirm("{{ __('Вы уверены, что хотите удалить обращение?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>


    <script>

        $('.dropdown-list').on('click', function(event) {
            $('.dropdown-block').hide();
            $(this).find('.dropdown-block').show();
        });

        // Закрыть выпадающее меню, если клик был вне его области
        window.onclick = function(event) {
            if (!event.target.matches('.dots')) {
                var dropdowns = document.getElementsByClassName("dropdown-block");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.style.display === "block") {
                        openDropdown.style.display = "none";
                    }
                }
            }
        }
    </script>
@endpush
