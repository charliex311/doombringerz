@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки') . ' ' . __('О Серверах'))

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
                                                       for="about_servers_description_{{ $key }}">{{ __('Описание') }}</label>
                                                <div class="form-control-wrap">
                                                     <textarea type="text" class="form-control"
                                                         id="about_servers_description_{{ $key }}"
                                                         name="setting_about_servers_description_{{ $key }}">{{ config('options.about_servers_description_'.$key) }}</textarea>
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
        @foreach(getlangs() as $key => $value)
            CKEDITOR.config.allowedContent=true;

            @if(session()->has('theme') && session()->get('theme') == 'dark')
            CKEDITOR.addCss('.cke_editable { background-color: #0e1014; color: #942f06 }');
            @endif

            CKEDITOR.replace( 'about_servers_description_{{ $key }}', {
                language: '{{ app()->getLocale() }}'
            });
        @endforeach
    </script>
@endpush
