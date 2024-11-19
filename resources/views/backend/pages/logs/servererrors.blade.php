@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Ошибки сервера'))
@section('headerTitle', __('Журналы и логи'))
@section('headerDesc', __('Ошибки сервера') . '.')

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title" style="display: flex;">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control"
                                                   id="date" name="date"
                                                   @if(request()->has('date'))
                                                   value="{{ str_replace(' ', 'T', date('Y-m-d', strtotime(request()->query('date')))) }}"
                                                   @else
                                                   value="{{ date('Y-m-d') }}"
                                                    @endif
                                            >
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('logs.servererrors') }}?period=day&date={{ date('Y-m-d') }}" class="btn btn-sm btn-primary" style="margin-right: 15px;">
                                    <em class="icon ni ni-calender-date mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Сегодня') }}</span>
                                </a>
                                <a href="{{ route('logs.servererrors') }}?period=week" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-calender-date mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Неделя') }}</span>
                                </a>

                            </h5>

                            <div class="card-tools d-none d-md-inline">
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Поиск') }}...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-bordered">
                    <div class="card-inner logs-block">
                        <pre>{{ $log }}</pre>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function(){
            $('#date').on('change', function() {
                document.location.replace('{{ route('logs.servererrors') }}?period=day&date='+$('#date').val());
            });
        });
    </script>
@endpush