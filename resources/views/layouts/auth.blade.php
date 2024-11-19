@extends('layouts.dashlite')
@section('content')

    <style>
        .nk-app-root {
            background-image: url(../img/home/bg-home.png) !important;
        }
    </style>

    <div class="nk-wrap nk-wrap-nosidebar">
        <div class="nk-content">
            <div class="nk-split nk-split-page nk-split-md">
                <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
                    <div class="nk-block nk-block-middle nk-auth-body">
                        <div class="brand-logo pb-5" style="padding-bottom: 20px !important;">
                            @include('partials.cabinet.auth-logo')
                        </div>

                        <div class="form-note-s2 pt-4" style="margin-bottom: 50px;">
                            <a href="{{ route('index') }}" class="back-to-home"><em class="icon ni ni-back-arrow"></em><strong>{{ __('Вернуться на Главную') }}</strong></a>
                        </div>

                        <div class="nk-block-head">
                            <div class="nk-block-head-content">
                                <h5 class="nk-block-title">@yield('title')</h5>
                            </div>
                        </div>
                        @yield('form')
                    </div>
                    <div class="nk-block nk-auth-footer">
                        <div class="mt-3">
                            @include('partials.cabinet.footer-copyright')
                        </div>
                    </div>
                </div>
                <div class="nk-split-content nk-split-stretch man-auth d-none d-md-block">
                    <div class="nk-footer-links-auth-logo">
                        <ul class="nav nav-sm">
                            <li class="nav-item logo-link">
                                <a class="nav-link" href="https://wizardcp.com" title="WizardCP — Control panel for magical game projects"  target="_blank" rel="dofollow"><img src="/assets/images/wizardcp-logo-light.png"/></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
