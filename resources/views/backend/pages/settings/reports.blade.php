@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки') . ' ' . __('Баг трекер'))

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
                                                <label class="form-label"
                                                       for="reports_description_{{ $key }}">{{ __('Описание статусов') }}
                                                    ({{ $key }})</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control" id="reports_description_{{ $key }}"
                                                        name="setting_reports_description_{{ $key }}">{{ config('options.reports_description_'.$key) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="reports_create_description_{{ $key }}">{{ __('Описание Создание отчета') }}
                                                    ({{ $key }})</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control" id="reports_create_description_{{ $key }}"
                                                              name="setting_reports_create_description_{{ $key }}">{{ config('options.reports_create_description_'.$key) }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label class="form-label"
                                                       for="reports_consent_description_{{ $key }}">{{ __('Описание Согласия') }}
                                                    ({{ $key }})</label>
                                                <div class="form-control-wrap">
                                                    <textarea type="text" class="form-control" id="reports_consent_description_{{ $key }}"
                                                              name="setting_reports_consent_description_{{ $key }}">{{ config('options.reports_consent_description_'.$key) }}</textarea>
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

    <!-- .nk-block -->
@endsection

@push('scripts')
    <script>

        @if(session()->has('theme') && session()->get('theme') == 'dark')
            CKEDITOR.addCss('.cke_editable { background-color: #0e1014; color: #942f06 }');
        @endif
        CKEDITOR.config.allowedContent=true;

        @foreach(getlangs() as $key => $value)
            CKEDITOR.replace( 'setting_reports_description_{{ $key }}', {
                language: '{{ app()->getLocale() }}'
            });
            CKEDITOR.replace( 'setting_reports_create_description_{{ $key }}', {
                language: '{{ app()->getLocale() }}'
            });
            CKEDITOR.replace( 'setting_reports_consent_description_{{ $key }}', {
                language: '{{ app()->getLocale() }}'
            });

        @endforeach
    </script>
@endpush
