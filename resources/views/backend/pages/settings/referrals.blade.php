@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки рефералов') . ".")

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                    <div class="tab-pane" id="shop">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row g-4">

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="referral_percent_issued">{{ __('Размер бонуса для того, кто выдал код') }}, {{ config('options.server_0_coin_name', 'CoL') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="referral_percent_issued"
                                                               name="setting_referral_percent_issued"
                                                               value="{{ config('options.referral_percent_issued', "5") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="referral_percent_registered">{{ __('Размер бонуса  для зарегистрировавшегося') }}, {{ config('options.server_0_coin_name', 'CoL') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="referral_percent_registered"
                                                               name="setting_referral_percent_registered"
                                                               value="{{ config('options.referral_percent_registered', "5") }}">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>


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
                                                            <label class="form-label" for="referral_title_{{ $key }}">{{ __('Заголовок Помощи') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="referral_title_{{ $key }}" name="setting_referral_title_{{ $key }}" value="{{ config('options.referral_title_' . $key, '') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="referral_description_{{ $key }}">{{ __('Описание Помощи') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control"
                                                                    id="referral_description_{{ $key }}" name="setting_referral_description_{{ $key }}">{{ config('options.referral_description_'.$key) }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

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
        </div>
    <!-- .nk-block -->
@endsection

@push('scripts')
    <script>

        @if(session()->has('theme') && session()->get('theme') == 'dark')
            CKEDITOR.addCss('.cke_editable { background-color: #0e1014; color: #942f06 }');
        @endif

        @foreach(getlangs() as $key => $value)
            CKEDITOR.replace( 'setting_referral_description_{{ $key }}', {
                language: '{{ app()->getLocale() }}'
            });
        @endforeach
    </script>
@endpush
