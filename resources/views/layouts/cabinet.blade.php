@extends('layouts.dashlite')

@section('content')

    <div class="nk-wrap">

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

				{{-- Error --}}
                                    @error('login')
                                    <div class="alert alert-fill alert-danger alert-dismissible alert-icon">
					<em class="icon ni ni-cross-circle"></em>
                                        {{ $message }}
                                        <button class="close" data-dismiss="alert"></button>
                                    </div>
                                    @enderror
                                    @error('password')
                                    <div class="alert alert-fill alert-danger alert-dismissible alert-icon">
					<em class="icon ni ni-cross-circle"></em>
                                        {{ $message }}
                                        <button class="close" data-dismiss="alert"></button>
                                    </div>
                                    @enderror
                                    @error('password_confirmation')
                                    <div class="alert alert-fill alert-danger alert-dismissible alert-icon">
					<em class="icon ni ni-cross-circle"></em>
                                        {{ $message }}
                                        <button class="close" data-dismiss="alert"></button>
                                    </div>
                                    @enderror
                                    @error('new_password')
                                    <div class="alert alert-fill alert-danger alert-dismissible alert-icon">
					<em class="icon ni ni-cross-circle"></em>
                                        {{ $message }}
                                        <button class="close" data-dismiss="alert"></button>
                                    </div>
                                    @enderror
                                {{-- End Error --}}


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
                    <button type="submit" class="btn btn-lg btn-primary"><span>{{ __('Создать') }}</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endprepend

@push('scripts')
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

		console.log(prefix);
		$('#prefix').val(prefix);
		$('#prefix_refresh').toggleClass('transform');
                return false;
            });

        });
    </script>
@endpush
