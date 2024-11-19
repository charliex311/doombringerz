@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Баг трекер'))
@section('headerTitle', __('Баг трекер'))
@section('headerDesc', __('Обращения пользователей.'))


@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <div class="card-tools" style="width: 150px;">
                                <div class="form-control-wrap">
                                    <div class="form-icon form-icon-left">
                                        <em class="icon ni ni-search"></em>
                                    </div>

                                    <select class="form-select form-control" id="reports_status" name="reports_status">
                                        <option value="0" @if($reports_status == '0') selected @endif>{{ __('Все') }}</option>
                                        @foreach(getReportStatuses() as $key => $value)
                                            <option value="{{ $key }}" @if($reports_status == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="simplebar-mask" style="position: relative;">
                        <div class="simplebar-offset" style="position: relative;">
                            <div class="simplebar-content-wrapper"
                                 style="max-height: max-content;height: auto;">
                                <div class="simplebar-content" style="padding: 0px;">
                                    @foreach($reports as $report)
                                        <div class="nk-ibx-item is-unread">
                                            <a href="{{ route('backend.reports.show', $report) }}"
                                               class="nk-ibx-link"></a>
                                            <div class="nk-ibx-item-elem nk-ibx-item-user">
                                                <div class="user-card">
                                                    <div class="user-name">
                                                        <div class="lead-text">{{ $report->user->name }}</div>
                                                        <span class="text-gray">{{ $report->user->email }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="nk-ibx-item-elem nk-ibx-item-fluid">
                                                <div class="nk-ibx-context-group">
                                                    <div class="nk-ibx-context-badges">
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
                                                    </div>
                                                    <div class="nk-ibx-context">
                                                        <span class="nk-ibx-context-text">
                                                            <span class="heading">{{ $report->title }}</span>
                                                            {{ Str::limit($report->question, 64) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            @if ($report->attachment)
                                                <div class="nk-ibx-item-elem nk-ibx-item-attach">
                                                    <a class="link link-light"> <em
                                                        class="icon ni ni-clip-h"></em>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="nk-ibx-item-elem nk-ibx-item-time">
                                                <div class="sub-text">{{ getReportPriorityNameById($report->priority) }}</div>
                                            </div>
                                            <div class="nk-ibx-item-elem nk-ibx-item-time">
                                                <div class="sub-text">{{ $report->created_at->format('d/m/y') }}</div>
                                                <div class="sub-text">{{ $report->created_at->format('H:i') }}</div>
                                            </div>
                                            <div class="nk-ibx-item-elem nk-ibx-item-tools">
                                                <div class="ibx-actions">
                                                    <ul class="ibx-actions-hidden gx-1" style="display: none;">
                                                        <li>
                                                            <a href="{{ route('reports.delete', $report) }}"
                                                               class="btn btn-sm btn-icon btn-trigger"
                                                               data-toggle="tooltip"
                                                               data-placement="top" title=""
                                                               data-original-title="{{ __('Удалить') }}">
                                                                <em class="icon ni ni-trash"></em>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <ul class="ibx-actions-visible gx-2">
                                                        <li>
                                                            <div class="dropdown"><a href="#"
                                                                    class="dropdown-toggle btn btn-sm btn-icon btn-trigger"
                                                                    data-toggle="dropdown"><em
                                                                    class="icon ni ni-more-h"></em></a>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <ul class="link-list-opt no-bdr">
                                                                        <li><a href="{{ route('backend.reports.lock', $report) }}">
                                                                                <em class="icon ni ni-lock"></em><span>{{ __('Заблокировать') }}</span></a></li>
                                                                        <li><a href="{{ route('backend.reports.unlock', $report) }}">
                                                                                <em class="icon ni ni-unlock"></em><span>{{ __('Разблокировать') }}</span></a></li>
                                                                        <li><a href="{{ route('backend.reports.edit', $report) }}">
                                                                                <em class="icon ni ni-edit"></em><span>{{ __('Редактировать') }}</span></a></li>
                                                                        <li><a class="dropdown-item delete"
                                                                               href="{{ route('reports.delete', $report) }}" onClick="return Confirm();">
                                                                                <em class="icon ni ni-trash"></em><span>{{ __('Удалить') }}</span></a>
                                                                        </li>
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
                    {{ $reports->links('layouts.pagination.cabinet') }}
                </div>
            </div>
        </div>
    </div>

    <!-- .nk-block -->

@endsection

@prepend('scripts')
    <script>
        $('#reports_status').on('change', function() {
           document.location.replace('{{ route('reports.all') }}?status='+this.value);
        });

        function Confirm() {
            if (confirm("{{ __('Вы уверены, что хотите удалить обращение?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>
@endprepend