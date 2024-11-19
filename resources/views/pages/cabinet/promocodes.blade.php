@extends('layouts.cabinet')
@section('title', __('Активировать Промокод') . ".")

@push('head')
    <link rel="stylesheet" href="/css/box.css?ver=1.11">
@endpush
@section('wrap')

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Активировать Промокод') }}</span>
                            </h5>
                            <div class="card-title__info btn-help">
                                <img src="/img/info-icon.svg" alt="info-icon">
                                <span class="promocode-help">{{ __('Помощь') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">

                        </div>
                    </div>
                    <div class="card-inner">
                        <div class="box">

                            <div class="row g-4" style="justify-content: center;">
                                <div class="col-lg-6">
                                    <div id="promocode-msg-block" class="form-group">
                                        <div class="alert promocode-alert alert-fill alert-dismissible alert-icon">
                                            <em class="icon ni ni-check-circle"></em>
                                            <span id="promocode-msg" class=""></span>
                                            <button class="close" id="promocode-msg-block-close"></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-container" style="margin-top: 25px">

                                <form action="{{ route('promocodes.apply') }}" method="POST" class="box-actions">
                                    @csrf

                                    <div class="box-actions__input">
                                        <input class="text-upper" type="text" id="code" name="code" placeholder="{{ __('Введите Промокод') }}"
                                               value="{{ old('code') ? old('code') : '' }}">
                                    </div>

                                    <div id="char-select" class="form-group">
                                        <label class="form-label" for="char_id">{{ __('Выбрать персонажа') }}</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select form-control form-control-lg" data-search="on" id="char_id" name="char_id">
                                                @forelse ($characters as $character)
                                                    <option value="{{ $character->char_id }}">{{ $character->account_name }} - {{ $character->char_name }}</option>
                                                @empty
                                                    <option>{{ __('Нет доступных персонажей') }}</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="box-actions__options">
                                        <a class="box-actions__copy btn check-block">
                                            <span id="btn-check">{{ __('Проверить') }}</span>
                                        </a>
                                    </div>
                                    <div class="box-actions__options">
                                        <button class="box-actions__copy btn apply-block hide">
                                            <span id="promocode-apply">{{ __('Активировать') }}</span>
                                        </button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Активировать Промокод') }}</span></span>
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner border-top">
                        <div class="row g-4">
                            <div class="col-lg-6">
                                <div id="promocode-msg-block" class="form-group">
                                    <div class="alert promocode-alert alert-fill alert-dismissible alert-icon">
                                        <em class="icon ni ni-check-circle"></em>
                                        <span id="promocode-msg" class=""></span>
                                        <button class="close" id="promocode-msg-block-close"></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ route('promocodes.apply') }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="code">{{ __('Введите Промокод') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="code" name="code"
                                                   value="{{ old('code') ? old('code') : '' }}">
                                        </div>
                                    </div>

                                    <div id="char-select" class="form-group">
                                        <label class="form-label" for="char_id">{{ __('Выбрать персонажа') }}</label>
                                        <div class="form-control-wrap">
                                            <select class="form-select form-control form-control-lg" data-search="on" id="char_id" name="char_id">
                                                @forelse ($characters as $character)
                                                    <option value="{{ $character->char_id }}">{{ $character->account_name }} - {{ $character->char_name }}</option>
                                                @empty
                                                    <option>{{ __('Нет доступных персонажей') }}</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-12 promocode-apply">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary btn-wight-150"><span>{{ __('Активировать') }}</span></button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="promocode-check">
                            <div class="form-group">
                                <a id="btn-check" class="btn btn-lg btn-primary btn-wight-150"><span>{{ __('Проверить') }}</span></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}

@endsection

@prepend('scripts')
    <div class="modal fade zoom" tabindex="-1" id="PromocodesHelp" style="opacity:1;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border: 1px solid;">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close" OnClick="$('#PromocodesHelp').hide();">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ config('options.promocodes_title_' . app()->getLocale(), '') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            {!! config('options.promocodes_description_' . app()->getLocale()) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endprepend

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#btn-check').click(function() {

                $.ajax({
                    type: "POST",
                    url: "{{ route('promocodes.check') }}",
                    dataType: "json",
                    data: { code: $('input[name="code"]').val(), _token: $('input[name="_token"]').val() }
                }).done(function( data ) {

                    $('#alertModalMsg').removeClass('alertModal-success');
                    $('#alertModalMsg').removeClass('alertModal-error');
                    console.log(data.status);
                    if (data.status == 'success') {

                        console.log(data.type);
                        $('#promocode-msg').html(data.msg);

                        $('#promocode-msg-block').show();
                        $('.promocode-alert em').removeClass('ni-cross-circle');
                        $('.promocode-alert em').addClass('ni-check-circle');
                        $('.promocode-alert').removeClass('alert-danger');
                        $('.promocode-alert').addClass('alert-success');

                        if (data.type == 1) {
                            $('#char-select').show();
                        }

                        $('.apply-block').removeClass('hide');
                        $('.check-block').hide();

                    } else {
                        $('#promocode-msg-block').show();
                        $('#promocode-msg').html(data.msg);

                        $('.promocode-alert em').removeClass('ni-check-circle');
                        $('.promocode-alert em').addClass('ni-cross-circle');
                        $('.promocode-alert').removeClass('alert-success');
                        $('.promocode-alert').addClass('alert-danger');
                    }
                });
            });

            $('#promocode-msg-block-close').click(function() {
                $('#promocode-msg-block').hide();
            });
            $('.btn-help').on('click', function() {
                $('#PromocodesHelp').modal('show');
            });

        });
    </script>

@endpush
