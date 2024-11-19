@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Сгенерировать Промокоды'))
@section('headerDesc', __('Сгенерировать Промокоды') . '.')

@section('headerTitle', __('Промокоды'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="{{ route('promocodes.generate_store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($promocode)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                                <input type="hidden" name="id" value="{{ $promocode->id }}">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="title">{{ __('Общий Заголовок') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="title" name="title"
                                                   @isset($promocode) value="{{ $promocode->title }}" @else value="{{ old('title') }}" @endisset required>
                                            @error('title')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="amount">{{ __('Количество Промокодов') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" min="1" max="100" class="form-control" id="amount" name="amount"
                                                   value="{{ old('amount') }}" required>
                                            @error('amount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date_start">{{ __('Дата начала') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="datetime-local" class="form-control @error('date_start') is-invalid @enderror"
                                                   id="date_start" name="date_start"
                                                   @isset($promocode) value="{{ str_replace(' ', 'T', date('Y-m-d H:i', strtotime($promocode->date_start))) }}" @else value="{{ old('date_start') }}" @endisset required
                                            >
                                            @error('date_start')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date_end">{{ __('Дата окончания') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="datetime-local" class="form-control @error('date_end') is-invalid @enderror"
                                                   id="date_end" name="date_end"
                                                   @isset($promocode) value="{{ str_replace(' ', 'T', date('Y-m-d H:i', strtotime($promocode->date_end))) }}" @else value="{{ old('date_end') }}" @endisset required
                                            >
                                            @error('date_end')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="type">{{ __('Тип Промокода') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="type" name="type" class="form-select">
                                                <option value="2" selected>{{ __('Одноразовый') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="margin-bottom-50"></div>

                            <!-- items -->
                            <div class="payments-title">{{ __('Бонусные предметы') }}</div>

                            <div class="col-items">
                                <div class="margin-bottom-50"></div>
                                <div id="items">
                                    <div class="g-4 item" data-item="" id="item_" style="display: none;">
                                        <div class="row g-4">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="item__id">{{ __('ID предмета') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="number" class="form-control" id="item__id"
                                                               name="item__id" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label" for="item__name">{{ __('Название предмета') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="item__name"
                                                               name="item__name" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label class="form-label" for="item__amount">{{ __('Количество') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="item__amount"
                                                               name="item__amount" value="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group delete-bonus">
                                                    <a class="btn delete" data-donat="item_" onClick="deleteitem('item_')">{{ __('Удалить предмет') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    @if(isset($items) && is_array($items))
                                        @foreach($items as $item)
                                            <div class="g-4 item" data-item="{{ $loop->iteration }}" id="item_{{ $loop->iteration }}">
                                                <div class="row g-4">
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="item_{{ $loop->iteration }}_id">{{ __('ID предмета') }} ({{ $loop->iteration }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" class="form-control" id="item_{{ $loop->iteration }}_id"
                                                                       name="item_{{ $loop->iteration }}_id" value="{{ $item->id }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <label class="form-label" for="item_{{ $loop->iteration }}_name">{{ __('Название предмета') }} ({{ $loop->iteration }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="item_{{ $loop->iteration }}_name"
                                                                       name="item_{{ $loop->iteration }}_name" value="{{ $item->name }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <label class="form-label" for="item_{{ $loop->iteration }}_amount">{{ __('Количество') }} ({{ $loop->iteration }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="item_{{ $loop->iteration }}_amount"
                                                                       name="item_{{ $loop->iteration }}_amount" value="{{ $item->amount }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bonus">
                                                            <a class="btn delete" data-donat="item_{{ $loop->iteration }}" onClick="deleteitem('item_{{ $loop->iteration }}')">{{ __('Удалить предмет') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>

                                <div class="row g-4">
                                    <div class="col-lg-12">
                                        <div class="form-group add-bonus">
                                            <a class="btn add additem">{{ __('Добавить предмет') }}</a>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            {{-- end items --}}



                            {{--
                            <div id="items">
                                <div class="payments-title">{{ __('Бонусный предмет') }}</div>
                                <div class="g-4 item" data-step="" id="item_1">
                                    <div class="row g-4">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="item_1_id">{{ __('Предмет') }} (ID)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="item_1_id" name="item_1_id" @isset($item) value="{{ $item->id }}" @else value="" @endisset>
                                                </div>
                                                @if(session()->has('item_err_id'))
                                                    <div class="invalid-feedback">
                                                        {{ session()->get('item_err_id') }}
                                                    </div>
                                                    @php
                                                        session()->forget('item_err_id');
                                                    @endphp
                                                @endif

                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="item_1_name">{{ __('Название предмета') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="item_1_name" name="item_1_name"  @isset($item) value="{{ $item->name }}" @else value="" @endisset>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label class="form-label" for="item_1_amount">{{ __('Количество') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="item_1_amount" name="item_1_amount" @isset($item) value="{{ $item->amount }}" @else value="" @endisset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

 --}}


                            <div class="row g-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary ml-auto">{{ __('Отправить') }}</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#type').on('change', function () {
                console.log($(this).find('option:selected').val());
                if ($(this).find('option:selected').val() == '1') {
                    $('#user_id-block').hide();
                    $('#type_restriction-block').show();
                } else if ($(this).find('option:selected').val() == '2') {
                    $('#user_id-block').hide();
                    $('#type_restriction-block').hide();
                } else {
                    $('#user_id-block').show();
                    $('#type_restriction-block').show();
                }
            });
            $('#generate-code').on('click', function () {
                let code = '';
                let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
                for (var i = 0; i < 20; i++)
                    code += possible.charAt(Math.floor(Math.random() * possible.length));
                console.log(code);
                $('#code').val(code);
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            let item_id = 1;
            let item_id_next = 1;
            let item_html = '';
            let sear = '';
            let repl = '';
            $('.additem').on('click', function(){
                item_id = $('.item:last').data('item');
                item_id_next = item_id + 1;
                item_id = '';
                sear = new RegExp('item_' + item_id, 'g');
                repl = 'item_' + item_id_next;
                item_html = $('#item_'+item_id).html().replace(sear,repl);
                sear = new RegExp('{{ __("ID вариации") }} ' + item_id, 'g');
                item_html = item_html.replace(sear,'{{ __("ID вариации") }} ' + item_id_next);

                $('#items').append('<div class="g-4 item" data-item="'+item_id_next+'" id="item_' + item_id_next + '">' + item_html + '</div>');
            });

            if ($('#category_id').find('option:selected').val() == '4') {
                $('#service-items').show();
            }
        });

        //item
        function deleteitem(item){
            $('#'+item).remove();
        }
    </script>
@endpush