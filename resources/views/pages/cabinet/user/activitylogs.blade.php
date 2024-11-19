@extends('layouts.cabinet')
@section('title', __('История Активности'))

@section('wrap')
    @include('partials.cabinet.settings-menu')

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head flex-row align-items-start">
                            <h5 class="card-title m-0" style="font-family: Nunito, sans-serif;">@yield('title')</h5>
                            <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#createTicket">
                                <span class="d-none d-sm-inline">{{ __('Сделать запрос в поддержку') }}</span>
                            </a>
                            <div class="card-title__info select-title" style="width: 200px;">
                                <select id="log_type" name="log_type" class="form-select">
                                    <option value="-1" selected>{{ __('Показать все') }}</option>
                                    @foreach(getlogtypes() as $index => $log_type)
                                        <option value="{{ $index }}" @if(request()->query('log_type') !== NULL && $index == request()->query('log_type')) selected @endif>{{ $log_type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <table class="table table-ulogs" style="font-family: Nunito, sans-serif;">
                            <thead class="thead-light">
                            <tr>
                                <th class="tb-col-os"><span class="overline-title">{{ __('Дата') }}</span></th>
                                <th class="tb-col-ip"><span class="overline-title">{{ __('Сообщение') }}</span></th>
                                <th class="tb-col-time"><span class="overline-title"></span>IP</th>
                                <th class="tb-col-action"><span class="overline-title">{{ __('Тип') }}</span></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($logs as $log)
                                <tr>
                                    <td class="tb-col-os" style="padding-left: 2px;">{{ $log->created_at }}</td>
                                    <td class="tb-col-ip"><span class="sub-text">{{ $log->message }}</span></td>
                                    <td class="tb-col-time"><span class="sub-text">{{ $log->ip }}</span></td>
                                    <td class="tb-col-action" style="padding-right: 0px;">
                                        <span class="activity-type-{{ $log->type }}">{{ getlogtype($log->type) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="card-inner">
                            {{ $logs->links('layouts.pagination.activitylogs') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#log_type').on('change', function() {
                document.location.replace('{{ route('activitylogs') }}?log_type='+$(this).val());
            });
        });
    </script>
@endpush
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