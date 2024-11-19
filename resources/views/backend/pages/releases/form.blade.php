@extends('backend.layouts.backend')

@isset($release)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать релиз'))
    @section('headerDesc', __('Редактирование релиза') . '.')
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить релиз'))
    @section('headerDesc', __('Добавление релиза') . '.')
@endisset

@section('headerTitle', __('Дорожная карта'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($release){{ route('releases.update', $release) }}@else{{ route('releases.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($release)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="is_release">{{ __('Состояние') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="is_release" name="is_release" class="form-select">
                                                <option value="0"
                                                        @if(isset($release) && $release->is_release == 0) selected @endif>{{ __('Не вышел') }}</option>
                                                <option value="1"
                                                        @if(isset($release) && $release->is_release == 1) selected @endif>{{ __('Вышел') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="category">{{ __('Категория') }}</label>
                                        <div class="form-control-wrap">
                                            <select id="category" name="category" class="form-select">
                                                @foreach(getRoadmapCategories() as $index => $category)
                                                    <option value="{{ $index }}" @if(isset($release) && $release->category == $index) selected @endif>{{ $category }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="link">{{ __('Ссылка на релиз') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control @error('link') is-invalid @enderror"
                                                   id="link" name="link"
                                                   @isset($release) value="{{ $release->link }}" @else value="{{ old('link') }}" @endisset
                                            >
                                            @error('link')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="date">{{ __('Дата релиза') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="datetime-local" class="form-control @error('date') is-invalid @enderror"
                                                   id="date" name="date"
                                                   @isset($release) value="{{ $release->date }}" @else value="{{ old('date') }}" @endisset required
                                            >
                                            @error('date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Tabs -->
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="tab">
                                        @foreach(getlangs() as $key => $value)
                                            <a class="tablinks @if($loop->first) active @endif" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
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
                                                            @php
                                                                $title = "title_" . $key;
                                                                $description = "description_" . $key;
                                                            @endphp
                                                            <label class="form-label" for="{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="{{ $title }}" name="{{ $title }}"
                                                                       @isset($release) value="{{ $release->$title }}" @else value="{{ old($title) }}" @endisset>
                                                                @error($title)
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-4" style="display: none;">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($release) {{ $release->$description }} @else {{ old($description) }} @endisset</textarea>
                                                            </div>
                                                            @error($description)
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            @endforeach


                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="image" class="form-label">@isset($release) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                            <div class="form-control-wrap">
                                                @isset($release)
                                                    <span><img src="/storage/{{ $release->image }}" alt="{{ $release->image }}"/></span>
                                                @endisset
                                                <div class="custom-file">
                                                    <input class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" type="file" >
                                                    <label class="custom-file-label" for="image">{{ __('Изображение') }}</label>
                                                    @error('image')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            <!-- donat Cols -->
                            <div class="margin-bottom-50"></div>
                            <div id="donates">

                                <div class="g-4 donat" data-donat="" id="donat_" style="display: none;">
                                    <div class="row g-4">
                                        <div class="col-lg-10">
                                            <div class="form-group">
                                                <label class="form-label" for="road_donat__groups">{{ __('Тип группы') }}</label>
                                                <div class="form-control-wrap">
                                                    <select id="road_donat__groups" name="road_donat__groups"  style="width: 300px;">
                                                        @foreach(getRoadmapGroups() as $index => $group)
                                                            <option value="{{ $index }}" @if(isset($release) && $release->is_release == 0) selected @endif>{{ $group }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <div class="form-group delete-bonus">
                                                <a class="btn delete" data-donat="donat_" onClick="deletedonat('donat_')">{{ __('Удалить группу') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- donat Items -->

                                    <div class="g-4">
                                        <div id="bitems_">

                                            <div class="g-4 group_ditem ditem_" data-bitem="" id="bitem_" style="display: none;">

                                                <!-- Tabs -->
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="tab">
                                                            @foreach(getlangs() as $key => $value)
                                                                <a class="tablinks_bitem__ @if($loop->first) active @endif" onclick="openTab_bitem__(event, '{{ $key }}_bitem__')">{{ $value }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Tab content -->
                                                @foreach(getlangs() as $key => $value)

                                                    <div id="{{ $key }}_bitem__" class="tabcontent_tab tabcontent_bitem__" @if($loop->first) style="display: block" @endif>

                                                        <div class="row g-4">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    @php
                                                                        $title = "title_" . $key;
                                                                        $description = "description_" . $key;
                                                                        $short_description = "short_description_" . $key;
                                                                    @endphp
                                                                    <label class="form-label" for="road_bitem__{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" class="form-control" id="road_bitem__{{ $title }}" name="road_bitem__{{ $title }}"
                                                                               value="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-4">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="road_bitem__{{ $short_description }}">{{ __('Краткое Описание') }} ({{ $key }})</label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea type="text" class="form-control" id="road_bitem__{{ $short_description }}" name="road_bitem__{{ $short_description }}"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-4">
                                                            <div class="col-lg-12">
                                                                <div class="form-group">
                                                                    <label class="form-label" for="road_bitem__{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                                    <div class="form-control-wrap">
                                                                        <textarea type="text" class="form-control" id="road_bitem__{{ $description }}" name="road_bitem__{{ $description }}"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach

                                                <div class="row g-4">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="road_bitem__image" class="form-label">@isset($release) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                                            <div class="form-control-wrap">
                                                                @isset($release)
                                                                    <span><img src="/storage/{{ $release->image }}" alt="{{ $release->image }}"/></span>
                                                                @endisset
                                                                <div class="custom-file">
                                                                    <input class="custom-file-input" id="road_bitem__image" name="road_bitem__image" type="file" >
                                                                    <label class="custom-file-label" for="road_bitem__image">{{ __('Изображение') }}</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-2">
                                                    <div class="form-group delete-bitem">
                                                        <a class="btn delete" data-bitem="bitem_" onClick="deleteBitem('bitem_')">{{ __('Удалить запись') }}</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="row g-4">
                                            <div class="col-lg-12">
                                                <div class="form-group add-bitem">
                                                    <a class="btn add" onclick="addBitem('');">{{ __('Добавить запись') }}</a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>


                            @php $road_groups = (isset($release) && $release->road_groups !== NULL) ? json_decode($release->road_groups) : []; @endphp

                            @if(!empty($road_groups))
                            @foreach($road_groups as $road_group)


                                    <div class="margin-bottom-50"></div>
                                    <div class="g-4 donat" data-donat="{{ $loop->iteration }}" id="donat_{{ $loop->iteration }}">
                                        <div class="row g-4">
                                            <div class="col-lg-10">
                                                <div class="form-group">
                                                    <label class="form-label" for="road_donat_{{ $loop->iteration }}_groups">{{ __('Тип группы') }}</label>
                                                    <div class="form-control-wrap">
                                                        <select id="road_donat_{{ $loop->iteration }}_groups" name="road_donat_{{ $loop->iteration }}_groups" style="width: 300px;">
                                                            @foreach(getRoadmapGroups() as $index => $group)
                                                                <option value="{{ $index }}" @if($road_group->id == $index) selected @endif>{{ $group }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="form-group delete-bonus">
                                                    <a class="btn delete" data-donat="donat_{{ $loop->iteration }}" onClick="deletedonat('donat_{{ $loop->iteration }}')">{{ __('Удалить группу') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- donat Items -->


                                        <div class="g-4">
                                            <div id="bitems_{{ $loop->iteration }}">

                                                <div class="g-4 group_ditem ditem_{{ $loop->iteration }}" data-bitem="" id="bitem_{{ $loop->iteration }}_" style="display: none;">

                                                    <!-- Tabs -->
                                                    <div class="row g-4">
                                                        <div class="col-lg-12">
                                                            <div class="tab">
                                                                @foreach(getlangs() as $key => $value)
                                                                    <a class="tablinks_bitem__ @if($loop->first) active @endif" onclick="openTab_bitem__(event, '{{ $key }}_bitem__')">{{ $value }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tab content -->
                                                    @foreach(getlangs() as $key => $value)

                                                        <div id="{{ $key }}_bitem__" class="tabcontent_tab tabcontent_bitem__" @if($loop->first) style="display: block" @endif>

                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        @php
                                                                            $title = "title_" . $key;
                                                                            $description = "description_" . $key;
                                                                            $short_description = "short_description_" . $key;
                                                                        @endphp
                                                                        <label class="form-label" for="road_bitem__{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" id="road_bitem__{{ $title }}" name="road_bitem__{{ $title }}"
                                                                                   value="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="road_bitem__{{ $short_description }}">{{ __('Краткое Описание') }} ({{ $key }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea type="text" class="form-control" id="road_bitem__{{ $short_description }}" name="road_bitem__{{ $short_description }}"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="road_bitem__{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea type="text" class="form-control" id="road_bitem__{{ $description }}" name="road_bitem__{{ $description }}"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach

                                                    <div class="row g-4">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="road_bitem__image" class="form-label">@isset($release) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                                                <div class="form-control-wrap">
                                                                    @isset($release)
                                                                        <span><img src="/storage/{{ $release->image }}" alt="{{ $release->image }}"/></span>
                                                                    @endisset
                                                                    <div class="custom-file">
                                                                        <input class="custom-file-input" id="road_bitem__image" name="road_bitem__image" type="file" >
                                                                        <label class="custom-file-label" for="road_bitem__image">{{ __('Изображение') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bitem">
                                                            <a class="btn delete" data-bitem="bitem_" onClick="deleteBitem('bitem_')">{{ __('Удалить запись') }}</a>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach($road_group->items as $item)

                                                    <div class="g-4 group_ditem ditem_{{ $loop->parent->iteration }}" data-bitem="{{ $loop->iteration }}" id="bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}">

                                                    <!-- Tabs -->
                                                    <div class="row g-4">
                                                        <div class="col-lg-12">
                                                            <div class="tab">
                                                                @foreach(getlangs() as $key => $value)
                                                                    <a class="tablinks_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_ @if($loop->first) active @endif" onclick="openTab_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_(event, '{{ $key }}_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_')">{{ $value }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Tab content -->
                                                    @foreach(getlangs() as $key => $value)

                                                        <div id="{{ $key }}_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_" class="tabcontent_tab tabcontent_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_" @if($loop->first) style="display: block" @endif>

                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        @php
                                                                            $title = "title_" . $key;
                                                                            $description = "description_" . $key;
                                                                            $short_description = "short_description_" . $key;
                                                                        @endphp
                                                                        <label class="form-label" for="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <input type="text" class="form-control" id="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $title }}" name="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $title }}"
                                                                                   value="@isset($release){{ $item->$title }}@endisset">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $short_description }}">{{ __('Краткое Описание') }} ({{ $key }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea type="text" class="form-control" id="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $short_description }}" name="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $short_description }}">@isset($release){{ $item->$short_description }}@endisset</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row g-4">
                                                                <div class="col-lg-12">
                                                                    <div class="form-group">
                                                                        <label class="form-label" for="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                                        <div class="form-control-wrap">
                                                                            <textarea type="text" class="form-control" id="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $description }}" name="road_bitem_{{ $loop->parent->parent->iteration }}_{{ $loop->parent->iteration }}_{{ $description }}">@isset($release){{ $item->$description }}@endisset</textarea>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    @endforeach

                                                    <div class="row g-4">
                                                        <div class="col-lg-6">
                                                            <div class="form-group">
                                                                <label for="road_bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}_image" class="form-label">@isset($release) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                                                <div class="form-control-wrap">
                                                                    @if(isset($release) && isset($item->image))
                                                                        <span><img src="/storage/{{ $item->image }}" alt="{{ $release->image }}"/></span>
                                                                    @endif
                                                                    <div class="custom-file">
                                                                        <input class="custom-file-input" id="road_bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}_image_old" name="road_bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}_image_old" value="@if(isset($release) && isset($item->image)){{ $item->image }}@endif" type="hidden" >
                                                                        <input class="custom-file-input" id="road_bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}_image" name="road_bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}_image" type="file">
                                                                        <label class="custom-file-label" for="road_bitem_{{ $loop->parent->iteration }}_{{ $loop->iteration }}_image">{{ __('Изображение') }}</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-2">
                                                        <div class="form-group delete-bitem">
                                                            <a class="btn delete" data-bitem="bitem_{{ $loop->iteration }}" onClick="deleteBitem('bitem_{{ $loop->iteration }}')">{{ __('Удалить запись') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>

                                            <div class="row g-4">
                                                <div class="col-lg-12">
                                                    <div class="form-group add-bitem">
                                                        <a class="btn add" onclick="addBitem('{{ $loop->iteration }}');">{{ __('Добавить запись') }}</a>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>

                            @endforeach

                            @endif
                            </div>
                                    <div class="row g-4">
                                        <div class="col-lg-12">
                                            <div class="form-group add-bonus">
                                                <a class="btn add adddonat">{{ __('Добавить группу') }}</a>
                                            </div>
                                        </div>
                                    </div>











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

        CKEDITOR.replace( 'description_{{ $key }}', {
            language: '{{ app()->getLocale() }}'
        });
        @endforeach

        //donat Cols
        function deletedonat(donat){
            $('#'+donat).remove();
        }

        //donat Cols
        let donat_id = 1;
        let donat_id_next = 1;
        let donat_html = '';
        let sear = '';
        let repl = '';
        $('.adddonat').on('click', function(){
            donat_id = $('.donat:last').data('donat');
            console.log($('.donat:last').data('donat')  );
            donat_id_next = donat_id + 1;
            donat_id = '';
            sear = new RegExp('donat_' + donat_id, 'g');
            repl = 'donat_' + donat_id_next;
            donat_html = $('#donat_'+donat_id).html().replace(sear,repl);
            sear = new RegExp('bitems_' + donat_id, 'g');
            repl = 'bitems_' + donat_id_next;
            donat_html = donat_html.replace(sear,repl);
            sear = new RegExp('ditem_' + donat_id, 'g');
            repl = 'ditem_' + donat_id_next;
            donat_html = donat_html.replace(sear,repl);
            sear = new RegExp('bitem_' + donat_id, 'g');
            repl = 'bitem_' + donat_id_next + '_';
            donat_html = donat_html.replace(sear,repl);
            sear = "addBitem('"+donat_id+"')";
            repl = "addBitem('"+donat_id_next+"')";
            donat_html = donat_html.replace(sear,repl);
            sear = new RegExp('{{ __("Донат") }} ' + donat_id, 'g');
            donat_html = donat_html.replace(sear,'{{ __("Донат") }} ' + donat_id_next);

            $('#donates').append('<div class="g-4 donat" data-donat="'+donat_id_next+'" id="donat_' + donat_id_next + '">' + donat_html + '</div>');
        });


        function deleteBitem(bitem){
            $('#'+bitem).remove();
        }

        function addBitem(donat){
            let bitem_id = 1;
            let bitem_id_next = 1;
            let bitem_html = '';
            let sear2 = '';
            let repl2 = '';
            bitem_id = $('.ditem_'+donat+':last').data('bitem');
            bitem_id_next = bitem_id + 1;
            sear2 = new RegExp('bitem_' + donat + '_' + bitem_id, 'g');
            repl2 = 'bitem_' + donat + '_' + bitem_id_next;
            bitem_html = $('#bitem_'+donat+'_'+bitem_id).html().replace(sear2,repl2);
            sear2 = new RegExp('{{ __("Предмет") }} ' + bitem_id, 'g');
            bitem_html = bitem_html.replace(sear2,'{{ __("Предмет") }} ' + bitem_id_next);
            $('#bitems_'+donat).append('<div class="g-4 group_ditem ditem_'+donat+'" data-bitem="'+bitem_id_next+'" id="bitem_'+donat+'_' + bitem_id_next + '">' + bitem_html + '</div>');
        }

    </script>
@endpush
