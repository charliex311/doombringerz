@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Статистика игровых предметов') . '.')

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="payments-title">{{ __('Предметы Игрового Сервера, по которым нужно отслеживать статистику') }}</div>

                                    <!-- itemitems -->
                                        <div class="col-items">
                                            <div class="margin-bottom-50"></div>
                                            <div id="items">
                                                <div class="g-4 item" data-item="" id="item_" style="display: none;">
                                                    <div class="row g-4">
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label class="form-label" for="statistics_game_item__id">{{ __('ID предмета') }}</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="number" class="form-control" id="statistics_game_item__id"
                                                                           name="setting_statistics_game_item__id" value="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <label class="form-label" for="statistics_game_item__name">{{ __('Название предмета') }}</label>
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" id="statistics_game_item__name"
                                                                           name="setting_statistics_game_item__name" value="">
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

                                                @for($it=0;$it<100;$it++)
                                                    @if (config('options.statistics_game_item_'.$it.'_id', 0) != 0)
                                                        <div class="g-4 item" data-item="{{ $it }}" id="item_{{ $it }}">
                                                            <div class="row g-4">
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="statistics_game_item_{{ $it }}_id">{{ __('ID предмета') }} ({{ $it }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="number" class="form-control" id="statistics_game_item_{{ $it }}_id"
                                                                                   name="setting_statistics_game_item_{{ $it }}_id" value="{{ config('options.statistics_game_item_' . $it . '_id', 0) }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="statistics_game_item_{{ $it }}_name">{{ __('Название предмета') }} ({{ $it }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" id="statistics_game_item_{{ $it }}_name"
                                                                                   name="setting_statistics_game_item_{{ $it }}_name" value="{{ config('options.statistics_game_item_' . $it . '_name', '') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-2">
                                                                    <div class="form-group delete-bonus">
                                                                        <a class="btn delete" data-donat="item_{{ $it }}" onClick="deleteitem('item_{{ $it }}')">{{ __('Удалить предмет') }}</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endfor

                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group add-bonus">
                                                        <a class="btn add additem">{{ __('Добавить предмет') }}</a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                        {{-- end WikiItem --}}


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
                sear = new RegExp('{{ __("ID предмета") }} ' + item_id, 'g');
                item_html = item_html.replace(sear,'{{ __("ID предмета") }} ' + item_id_next);

                $('#items').append('<div class="g-4 item" data-item="'+item_id_next+'" id="item_' + item_id_next + '">' + item_html + '</div>');
            });

        });

        //item
        function deleteitem(item){
            $('#'+item).remove();
        }
    </script>
@endpush