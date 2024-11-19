@extends('layouts.dashlite')

@push('styles')
    <link rel="stylesheet" href="/css/cabinet.css">
    <link rel="stylesheet" href="/css/header.css">
    <link rel="stylesheet" href="/css/box.css">
    <link rel="stylesheet" href="/css/basket.css">
    <link rel="stylesheet" href="/css/category.css">
    <link rel="stylesheet" href="/css/layout.css">
    <link rel="stylesheet" href="/css/block.css">
    <link rel="stylesheet" href="/css/panel.css">
    <link rel="stylesheet" href="/css/info.css">

    <link rel="shortcut icon" href="https://hellreach.loc/favicon.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
@endpush

@section('content')
<style>
#prefix_refresh {
    margin-left: -26px;
    z-index: 9;
    position: absolute;
    margin-top: 7px;
    transition: all 0.5s linear;
    width: 23px;
    height: 23px;
}

.transform {
  transform: rotate(180deg);
}
</style>

    <div class="nk-wrap">

        {{--
        @include('partials.cabinet.header')
        --}}

        <div class="nk-content ">
            <div class="container wide-xl">
                <div class="nk-content-inner">

                    <div class="nk-aside bg-transparent" data-content="sideNav" data-toggle-overlay="true" data-toggle-screen="lg" data-toggle-body="true">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu nk-menu-main">
                                @include('partials.cabinet.header-menu')
                            </ul>

                            @include('partials.cabinet.main-menu')
                        </div>
                        <div class="nk-aside-close">
                            <a href="#" class="toggle" data-target="sideNav"><em class="icon ni ni-cross"></em></a>
                        </div>
                    </div>

                    <div class="nk-content-body">
                        <div class="nk-content-wrap">

                            @yield('wrap')
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        @include('partials.cabinet.footer')


                </div>
            </div>
        </div>
    </div>
@endsection

@prepend('scripts')
    <div class="modal fade zoom" tabindex="-1" id="ShopHelp" style="opacity:1;">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="border: 1px solid;">
                <a href="#" class="close" data-dismiss="modal" aria-label="Close" OnClick="$('#ShopHelp').hide();">
                    <em class="icon ni ni-cross"></em>
                </a>
                <div class="modal-header">
                    <h5 class="modal-title">{{ config('options.referral_title_' . app()->getLocale(), '') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="form-control-wrap">
                            {!! config('options.referral_description_' . app()->getLocale()) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endprepend

@prepend('scripts')
<div class="modal fade zoom" tabindex="-1" id="createAccount">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Создать аккаунт') }}</h5>
            </div>

            <form method="POST" action="{{ route('account.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label" for="login">{{ __('Логин') }} <small style="display: block;font-size: 11px;">({{ __('используйте латинские буквы и введите не более 14 символов') }})</small></label>
                        <div class="form-control-wrap">
                            @if (config('options.prefix') !== NULL && config('options.prefix') === "1")
                                <input type="text" class="form-control col-2 d-inline" name="prefix" id="prefix" value="{{ session()->get('prefix') }}" readonly><span id="prefix_refresh" class="nk-menu-icon"><em class="icon ni ni-reload-alt" style="font-size: 22px"></em></span>
                                <input type="text" class="form-control col-9 d-inline @error('login') is-invalid @enderror" id="login" name="login">
                            @else
                                <input type="hidden" class="form-control col-2 d-inline" name="prefix" id="prefix" disabled value="" readonly>
                                <input type="text" class="form-control col-11 d-inline @error('login') is-invalid @enderror" id="login" name="login">
                            @endif

                            @error('login')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password">{{ __('Пароль') }} <small style="display: block;font-size: 11px;">({{ __('используйте латинские буквы и введите не менее 6 символов и не более 20') }})</small></label>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control col-11 @error('password') is-invalid @enderror" id="password" name="password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password_confirmation">{{ __('Подтвердите пароль') }}</label>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control col-11 @error('password_confirmation') is-invalid @enderror"
                                   id="password_confirmation" name="password_confirmation">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="submit" class="btn btn-lg btn-primary">{{ __('Создать') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endprepend

@push('scripts')

    <script src="/assets/js/shop/swiper-bundle.min.js"></script>
    <script src="/assets/js/shop/main.js"></script>
    <script src="/assets/js/shop/addition.js"></script>

    <script>
        $(document).ready(function () {
            $('#select-server').on('change', function () {
                console.log($('#select-server').val());
                location.href = "{{ route('setserver', '') }}/" + $('#select-server').val();
            });
            $('.server-click').on('click', function () {
                console.log($(this).data('server'));
                location.href = "{{ route('setserver', '') }}/" + $(this).data('server');
                return false;
            });

            $('#prefix_refresh').on('click', function () {

		let prefix = "";
    		let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

    		for( var i=0; i < 3; i++ )
        		prefix += possible.charAt(Math.floor(Math.random() * possible.length));

		$('#prefix').val(prefix);
		$('#prefix_refresh').toggleClass('transform');
                return false;
            });

        });

        $('.btn-help').on('click', function() {
            $('#ShopHelp').modal('show');
        });
    </script>
@endpush
