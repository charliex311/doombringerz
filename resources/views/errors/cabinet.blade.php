@extends('layouts.cabinet')

@section('wrap')
    <div class="nk-block nk-block-middle wide-xs mx-auto">
        <div class="nk-block-content nk-error-ld text-center">
            <h1 class="nk-error-head">@yield('code')</h1>
            <h3 class="nk-error-title">@yield('message')</h3>
            <p class="nk-error-text">@yield('text')</p>
            <div class="btn-group-row">
            <a href="{{ route('index') }}" class="btn btn-lg btn-primary mt-2"><span>{{ __('Перейти на сайт') }}</span></a>
            <a href="{{ config('options.forum_link', '#') }}" class="btn btn-lg btn-primary mt-2"><span>{{ __('Перейти на форум') }}</span></a>
            </div>
        </div>
    </div>
@endsection
