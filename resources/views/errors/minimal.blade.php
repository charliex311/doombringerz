@extends('layouts.dashlite')

@section('content')
    <div class="nk-wrap nk-wrap-nosidebar">
        <div class="nk-content ">
            <div class="nk-block nk-block-middle wide-xs mx-auto">
                <div class="nk-block-content nk-error-ld text-center">
                    <h1 class="nk-error-head">@yield('code')</h1>
                    <h3 class="nk-error-title">@yield('message')</h3>
                    <p class="nk-error-text">@yield('text')</p>
                    <a href="{{ route('index') }}" class="btn btn-lg btn-primary mt-2"><span>{{ __('Вернуться') }}</span></a>
                </div>
            </div>
        </div>
    </div>
@endsection
