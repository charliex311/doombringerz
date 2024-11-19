@extends('layouts.main')

@section('title', __('Логи Релизов') . ' - ' . config('options.main_title_'.app()->getLocale(), '') )
@php
    $title = "title_" .app()->getLocale();
    $description = "description_" .app()->getLocale();
@endphp
@section('content')

    <div class="sparks-wrapper">
        <picture>
            <source type="image/webp" srcset="/img/bottom-sparks.webp">
            <img src="/img/bottom-sparks.png" alt="sparks">
        </picture>
    </div>

    <main class="main-padding news-body" style="background-image: url(/img/bug-tracker/bug-tracker-bg.webp);">

        <div class="top-wrapper">
            <section class="notes">
                <div class="notes__container main-container">
                    <div class="notes__body bug__box">
                        <div class="notes__head">
                            <div class="notes__date">
                                <div class="notes__date-since">
                                    {{ __('Дата от') }}
                                </div>
                                <div class="notes__date-num">
                                    <input type="date" id="date_start" name="date_start" value="{{ request()->query('date_start') }}">
                                </div>
                            </div>
                            <div class="notes__date">
                                <div class="notes__date-since">
                                    {{ __('Дата до') }}
                                </div>
                                <div class="notes__date-num">
                                    <input type="date" id="date_end" name="date_end" value="{{ request()->query('date_end') }}">
                                </div>
                            </div>

                                <div class="custom-select">
                                    <select name="category_id" id="category_id" class="form-control selectpicker white-grey bs-select-hidden">
                                        <option class="disabled" value="-1" selected="">{{ __('Выберите категорию') }}</option>
                                        @foreach(getReleaseNotesCategories() as $key => $value)
                                            <option value="{{ $key }}" @if(app('request')->input('category_id') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            <div class="tracker__buttons">
                                <button class="tracker__reset" id="reset">
                                    <span>{{ __('Сбросить') }}</span>
                                </button>
                                <button class="tracker__create btn" id="apply-btn">
                                    <span>{{ __('Применить') }}</span>
                                </button>

                                @if(auth()->check() && auth()->user()->isGMAdmin())
                                    <button class="tracker__create btn" id="created-btn">
                                        <span>{{ __('Добавить релиз') }}</span>
                                    </button>
                                @endif
                            </div>
                        </div>

                        @foreach($releasenotes as $date => $releasenote)
                            <div class="notes__box">
                            <div class="notes__block-heading">
                                {{ getmonthname(date('m', strtotime($date))) }} {{ date('d', strtotime($date)) }}, {{ date('Y', strtotime($date)) }}
                            </div>
                            <div class="notes__col notes__col--2">

                                @foreach($releasenote as $release)
                                    <div class="notes__block notes__block--color-{{ $release->category_id }}">
                                    <div class="notes__block-inner">
                                        <div class="notes__block-name">
                                            {{ getReleaseNotesCategory($release->category_id) }}:
                                        </div>
                                        <div class="notes__block-content">
                                            {!! $release->$description !!}
                                        </div>
                                    </div>
                                    <div class="notes__bottom">
                                        <div class="notes__author">
                                            <div class="notes__author-icon">
                                                <img src="{{ $release->user->avatar_url }}" alt="author-icon">
                                            </div>
                                            <div class="notes__author-name">
                                                {{ Str::limit($release->$title, 80) }}
                                            </div>
                                        </div>
                                        <div class="notes__author">
                                            <div class="notes__author-name">
                                                {{ getserver($release->server)->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </section>

        </div>

        @include('partials.main.offer')

    </main>

    @if(auth()->check() && auth()->user()->isGMAdmin())
        <div class="modal modal_success" id="add-release-note">
            <div class="modal__container">
                <div class="modal__body">
                    <div class="modal__close">
                        <svg>
                            <use href="/img/sprite/sprite.svg#close-icon"></use>
                        </svg>
                    </div>
                    <div>
                        <h1 class="modal__heading">{{ __('Добавить новый релиз') }}</h1>
                        <form action="{{ route('notes.store') }}" method="POST" enctype="multipart/form-data"
                              class="form">
                            @csrf
                            <input type="hidden" name="subcategory_id" id="subcategory_id" value="-1">

                            <div class="form__wrapper bug__box">
                                <div class="form__inner">
                                    <div class="form__inputs">
                                        <div class="form__inputs-item">
                                            <input type="text" class="form-control form-control-lg" id="title_en" name="title_en" placeholder="{{ __('Заголовок') }}" value="{{ old('title') }}" required>
                                            @error('title')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form__inputs-item">
                                            <div class="custom-select">
                                                <select name="server" id="server" class="form-control white-grey bs-select-hidden" required>
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите игровой мир') }}</option>
                                                    @foreach(getservers() as $server)
                                                        <option value="{{ $server->id }}" @if(app('request')->input('server') == $server->id) selected @endif>{{ $server->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form__inputs-item">
                                            <div class="custom-select">
                                                <select name="category_id" id="category_id" class="form-control selectpicker white-grey bs-select-hidden" required>
                                                    <option class="disabled" value="-1" selected="">{{ __('Выберите категорию') }}</option>
                                                    @foreach(getReleaseNotesCategories() as $key => $value)
                                                        <option value="{{ $key }}" @if(app('request')->input('category_id') == $key) selected @endif>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form__inputs-item">
                                            <textarea id="description_en" name="description_en" placeholder="{{ __("Описание") }}" required></textarea>
                                        </div>
                                    </div>
                                    <div class="form__buttons tracker__buttons">
                                        <button class="tracker__create btn">
                                            <span>{{ __('Добавить релиз') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#apply-btn').click(function() {
                console.log($(this).val());
                window.location.href = '{{ route('releasenotes') }}/?category_id=' + $('#category_id').val() + '&date_start=' + $('#date_start').val() + '&date_end=' + $('#date_end').val();
            });

            $('#reset').click(function() {
                window.location.href = '{{ route('releasenotes') }}';
            });

            $('#created-btn').click(function() {
                $('#add-release-note').addClass('show-modal');
            });
            $('#add-release-note .modal__close').click(function() {
                $('#add-release-note').removeClass('show-modal');
            });
        });
    </script>
@endpush
