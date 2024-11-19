@extends('backend.layouts.backend')

@section('title', 'Панель управления - ' . __('Бонусные предметы'))
@section('headerTitle', __('Бонусные предметы'))
@section('headerDesc', __('Выдать бонусный предмет'))

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                    <div class="tab-pane" id="shop">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.bonusitems.set') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="user_id" value="0">
                                    <input type="hidden" name="server_id" value="1">

                                    <div class="row g-4">

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="item_id">{{ __('ID предмета') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="item_id" name="item_id" value="">
                                                    @error('item_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="amount">{{ __('Количество, шт.') }}</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" min="1" class="form-control" id="amount" name="amount" value="1">
                                                    @error('amount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-label" for="type">{{ __('Кому выдать предмет') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="type" name="type" class="form-select">
                                                        <option value="0">{{ __('Всем Мастер Аккаунтам') }}</option>
                                                        <option value="1">{{ __('Одному Мастер Аккаунту') }}</option>
                                                    </select>
                                                    @error('user_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div id="col-user" class="col-lg-6" style="display: none;">
                                            <div class="form-group">
                                                <label class="form-label" for="user_name">{{ __('Мастер Аккаунт') }} ({{ __('введите имя МА и выберите из выпадающего списка') }})</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" class="form-control" id="user_name" name="user_name">
                                                    <div class="form-icon form-icon-right" style="cursor: pointer;">
                                                        <em class="icon ni ni-search"></em>
                                                    </div>
                                                    @error('user_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div id="users-find" style="display: none;"></div>
                                            </div>
                                        </div>


                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary ml-auto">{{ __('Выдать предмет') }}</button>
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
    <!-- .nk-block -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#type').on('change', function () {
                console.log($(this).find('option:selected').val());
                if ($(this).find('option:selected').val() == '1') {
                    $('#col-user').show();
                } else {
                    $('#col-user').hide();
                    $('input[name="user_id"]').val('0');
                    $('input[name="user_name"]').val('');
                }
            });

            $('input[name="user_name"]').change(function() {
                let input = $(this);
                let html = '';
                input.removeClass('success-input');
                input.removeClass('error-input');
                $.ajax({
                    type: "POST",
                    url: "{{ route('backend.users.getuserbyname') }}",
                    dataType: "json",
                    data: { user_name: $(this).val(), _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#users-find').addClass('find-active');
                        $.each(data.users,function(index, user){
                            console.log(user);
                            html = html + '<span class="user-find" onClick="UserSelect(\''+user.id+'\',\''+user.name+'\');">'+user.name+'</span>';
                            $('#users-find').html(html);
                            $('#users-find').show();
                        });
                    } else {
                        input.addClass('error-input');
                    }
                });
            });
        });

        function UserSelect(user_id, user_name) {
            console.log(user_id);
            $('input[name="user_id"]').val(user_id);
            $('input[name="user_name"]').val(user_name);
            $('#users-find').removeClass('find-active');
            $('#users-find').hide();
        }

    </script>
@endpush