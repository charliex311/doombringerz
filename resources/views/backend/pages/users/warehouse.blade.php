@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Склад'))
@section('headerTitle', __('Пользователи'))
@section('headerDesc', $user->name)

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Склад пользователя') }} {{ $user->name }}</span>
                            </h5>
                        </div>
                    </div>

                    @foreach(getservers() as $server)
                        <div class="card-inner p-0 border-top">
                            <div class="card-title-group" style="padding: 10px 25px;justify-content: center;">
                                <h6 class="card-title">
                                    <span class="mr-2">{{ __('Сервер') }}: {{ $server->name }}</span>
                                </h6>
                            </div>
                            <div class="nk-tb-list nk-tb-ulist is-compact border-top">
                                <div class="nk-tb-item nk-tb-head">
                                    <div class="nk-tb-col"><span class="sub-text">{{ __('Предмет') }}</span></div>
                                    <div class="nk-tb-col"><span class="sub-text">{{ __('Количество') }}</span></div>
                                    <div class="nk-tb-col"><span class="sub-text"></span></div>
                                </div>
                                <!-- .nk-tb-item -->


                                @forelse($items[$server->id] as $item)

                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col">
                                            <div class="user-card">
                                                <div class="user-avatar sm bg-primary">
                                                    @if(strpos($item->icon, 'images') === FALSE)
                                                        <img src="{{ asset("images/items/{$item->icon}.png") }}" alt="" title="{{ $item->name }}">
                                                    @else
                                                        <img src="{{ asset("/storage/{$item->icon}") }}" alt="" title="{{ $item->name }}">
                                                    @endif
                                                </div>
                                                <div class="user-name"> <span class="tb-lead">{{ $item->name }} {{ $item->enchant > 0 ? "+{$item->enchant}" : '' }} ({{ $item->type }})</span> </div>
                                            </div>
                                        </div>
                                        <div class="nk-tb-col"> <span>{{ $item->amount }} {{ __('шт.') }}</span> </div>
                                        <div class="nk-tb-col nk-tb-col-tools">
                                            <div class="drodown">
                                                <a href="#" class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown">
                                                    <em class="icon ni ni-more-h"></em>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-plain">
                                                        <li><a href="#" class="updateitem" title="{{ __('Изменить количество') }}" data-serverid="{{ $item->server }}" data-itemid="{{ $item->id }}" data-itemamount="{{ $item->amount }}" data-username="{{ $user->name }}" data-userid="{{ $user->id }}">{{ __('Изменить') }}</a></li>
                                                        <form action="{{ route('backend.user.warehouse.delete') }}" method="POST">
                                                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                                                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                                                            <input type="hidden" name="server_id" value="{{ $item->server }}">
                                                            @csrf
                                                            <li><a href="#" class="text-danger" onclick="if (ConfirmDelete()) {this.closest('form').submit();return false;}">{{ __('Удалить') }}</a></li>
                                                        </form>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="nk-tb-item">
                                        <div class="nk-tb-col text-center">
                                            {{ __('Склад пуст') }}.
                                        </div>
                                        <div class="nk-tb-col">  </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach

                    <div id="popup-item" class="popup-balance-block">

                        <div class="nk-block">
                            <div class="row g-gs">
                                <div class="col-12">
                                    <div class="card card-bordered">
                                        <div class="card-inner">
                                            <div class="card-title-group">
                                                <h5 class="card-title">
                                                    <span class="mr-2">{{ __('Изменить количество предметов на складе МА') }} <span id="u_name"></span></span>
                                                </h5>
                                                <span class="popup-close" onClick="$('#popup-item').hide();">x</span>
                                            </div>
                                        </div>
                                        <div class="card-inner border-top">
                                            <form action="{{ route('backend.user.warehouse.update') }}" method="POST">
                                                @csrf
                                                <input id="item_user_id" name="user_id" type="hidden" value="">
                                                <input id="item_id" name="item_id" type="hidden" value="">
                                                <input id="server_id" name="server_id" type="hidden" value="1">

                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label class="form-label" for="item_quantity">{{ __('Введите новое количество') }} {{ __('шт.') }}</label>
                                                            <div class="form-control-wrap">
                                                                <input type="number" min="1" class="form-control" id="item_quantity" name="item_quantity"
                                                                       value="{{ old('item_quantity') ?: '0' }}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <button type="submit" class="btn btn-lg btn-primary">{{ __('Изменить') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {

            $('.updateitem').on('click', function () {
                $('#popup-item').show();
                $('#item_user_id').val($(this).data('userid'));
                $('#item_id').val($(this).data('itemid'));
                $('#server_id').val($(this).data('serverid'));
                $('#u_name').text($(this).data('username'));
                $('#item_quantity').val($(this).data('itemamount'));

                console.log($(this).data('username'));
            });
        });

        function ConfirmDelete() {
            if (confirm("{{ __('Вы уверены, что хотите удалить?') }}")) {
                return true;
            } else {
                return false;
            }
        }
    </script>

@endsection
