@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки соглашений/политик') . ".")

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <!-- Tabs -->
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="tab">
                                                    @foreach(getlangs() as $key => $value)
                                                        <a class="tablinks @if($loop->first) active @endif"
                                                           onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Tab content -->
                                        @foreach(getlangs() as $key => $value)
                                            <div id="{{ $key }}" class="tabcontent" @if($loop->first) style="display: block" @endif>

                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="privacy_{{ $key }}">{{ __('ПОЛИТИКА КОНФИДЕНЦИАЛЬНОСТИ') }}</label>
                                                    <div class="form-control-wrap">
                                                        <textarea type="text" class="form-control"
                                                          id="privacy_{{ $key }}" name="setting_privacy_{{ $key }}">{{ config('options.privacy_'.$key) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="terms_{{ $key }}">{{ __('УСЛОВИЯ ОБСЛУЖИВАНИЯ') }}</label>
                                                    <div class="form-control-wrap">
                                                        <textarea type="text" class="form-control"
                                                          id="terms_{{ $key }}" name="setting_terms_{{ $key }}">{{ config('options.terms_'.$key) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                                <hr>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="rules_{{ $key }}">{{ __('Правила и положения') }}</label>
                                                            <div class="form-control-wrap">
                                                            <textarea type="text" class="form-control"
                                                                id="rules_{{ $key }}" name="setting_rules_{{ $key }}">{{ config('options.rules_'.$key) }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                        <hr>
                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="refund_{{ $key }}">{{ __('ПОЛИТИКА ВОЗВРАТА') }}</label>
                                                    <div class="form-control-wrap">
                                                <textarea type="text" class="form-control"
                                                          id="refund_{{ $key }}" name="setting_refund_{{ $key }}">{{ config('options.refund_'.$key) }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                    <div class="row g-4" style="margin-top: 25px !important;">
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

        @if(session()->has('theme') && session()->get('theme') == 'dark')
            CKEDITOR.addCss('.cke_editable { background-color: #0e1014; color: #942f06 }');
        @endif

        @foreach(getlangs() as $key => $value)
        CKEDITOR.replace( 'setting_privacy_{{ $key }}', {
            language: '{{ app()->getLocale() }}'
        });
        CKEDITOR.replace( 'setting_terms_{{ $key }}', {
            language: '{{ app()->getLocale() }}'
        } );
        CKEDITOR.replace( 'setting_refund_{{ $key }}', {
            language: '{{ app()->getLocale() }}'
        } );
        CKEDITOR.replace( 'setting_rules_{{ $key }}', {
            language: '{{ app()->getLocale() }}'
        } );
        @endforeach
    </script>
@endpush
