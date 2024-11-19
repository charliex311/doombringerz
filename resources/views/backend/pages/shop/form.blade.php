@extends('backend.layouts.backend')

@isset($shopitem)
    @section('title', __('Панель управления') . ' - ' . __('Редактировать предмет'))
    @section('headerDesc', __('Редактирование предмета.'))
@else
    @section('title', __('Панель управления') . ' - ' . __('Добавить предмет'))
    @section('headerDesc', __('Добавление предмета.'))
@endisset

@section('headerTitle', __('Предметы магазина'))

@section('wrap')
    <style>
        .selected-products {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
    </style>
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-head">

                        </div>
                        <form action="@isset($shopitem){{ route('shopitems.update', $shopitem) }}@else{{ route('shopitems.store') }}@endisset"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @isset($shopitem)
                                @method('PATCH')
                                <input type="hidden" name="edit" value="1">
                            @endisset

                            <div class="row g-4">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label class="form-label" for="category_id">{{ __('Категория') }}</label>
                                    <div class="form-control-wrap">
                                        @php $title = "title_" .app()->getLocale(); @endphp
                                        <select id="category_id" name="category_id" class="form-select">
                                            <option value="0">{{ __('Все') }}</option>
                                            @foreach(getshopcategories() as $key => $cat_1)

                                                <option value="{{ getshopcategory($key)->id }}" @if(isset($shopitem) && $shopitem->category_id == getshopcategory($key)->id) selected @endif>{{ getshopcategory($key)->$title }}</option>
                                                @if(!empty($cat_1))
                                                    @foreach($cat_1 as $key => $cat_2)
                                                        <option value="{{ getshopcategory($key)->id }}" @if(isset($shopitem) && $shopitem->category_id == getshopcategory($key)->id) selected @endif>- {{ getshopcategory($key)->$title }}</option>
                                                        @if(!empty($cat_2))
                                                            @foreach($cat_2 as $key => $cat_3)
                                                                <option value="{{ getshopcategory($key)->id }}" @if(isset($shopitem) && $shopitem->category_id == getshopcategory($key)->id) selected @endif>-- {{ getshopcategory($key)->$title }}</option>
                                                                @if(!empty($cat_3))
                                                                    @foreach($cat_3 as $key => $cat_4)
                                                                        <option value="{{ getshopcategory($key)->id }}" @if(isset($shopitem) && $shopitem->category_id == getshopcategory($key)->id) selected @endif>--- {{ getshopcategory($key)->$title }}</option>
                                                                        @if(!empty($cat_4))
                                                                            @foreach($cat_4 as $key => $cat_5)
                                                                                <option value="{{ getshopcategory($key)->id }}" @if(isset($shopitem) && $shopitem->category_id == getshopcategory($key)->id) selected @endif>---- {{ getshopcategory($key)->$title }}</option>
                                                                                @if(!empty($cat_5))
                                                                                    @foreach($cat_5 as $key => $cat_6)
                                                                                        <option value="{{ getshopcategory($key)->id }}" @if(isset($shopitem) && $shopitem->category_id == getshopcategory($key)->id) selected @endif>----- {{ getshopcategory($key)->$title }}</option>
                                                                                    @endforeach
                                                                                @endif
                                                                            @endforeach
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="wow_id">{{ __('Wow ID или Название') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" id="wow_id" name="wow_id"
                                                   @isset($shopitem) value="{{ $shopitem->wow_id }}" @else value="{{ old('wow_id') }}" @endisset>
                                            @error('wow_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="price">{{ __('Цена') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="price" name="price"
                                                   @isset($shopitem) value="{{ $shopitem->price }}" @else value="{{ old('price') }}" @endisset>
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="sale">{{ __('Цена со скидкой') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="sale" name="sale"
                                                   @isset($shopitem) value="{{ $shopitem->sale }}" @else value="{{ old('sale') }}" @endisset>
                                            @error('sale')
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
                                            @if($loop->index == 0)
                                                <a class="tablinks active" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                            @else
                                                <a class="tablinks" onclick="openTab(event, '{{ $key }}')">{{ $value }}</a>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Tab content -->
                            @foreach(getlangs() as $key => $value)
                                @if($loop->index == 0)
                                    <div id="{{ $key }}" class="tabcontent" style="display: block">
                                        @else
                                            <div id="{{ $key }}" class="tabcontent">
                                                @endif

                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            @php
                                                                $title = "title_" . $key;
                                                                $description = "description_" . $key;
                                                                $description_add = "description_add_" . $key;
                                                            @endphp
                                                            <label class="form-label" for="{{ $title }}">{{ __('Заголовок') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <input type="text" class="form-control" id="{{ $title }}" name="{{ $title }}"
                                                                       @isset($shopitem) value="{{ $shopitem->$title }}" @else value="{{ old($title) }}" @endisset>
                                                                @error('{{ $title }}')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="{{ $description }}">{{ __('Описание') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control" id="{{ $description }}" name="{{ $description }}">@isset($shopitem) {{ $shopitem->$description }} @else {{ old($description) }} @endisset</textarea>
                                                            </div>
                                                            @error('{{ $description }}')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-4">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="{{ $description_add }}">{{ __('Дополнительная Информация') }} ({{ $key }})</label>
                                                            <div class="form-control-wrap">
                                                                <textarea type="text" class="form-control" id="{{ $description_add }}" name="{{ $description_add }}">@isset($shopitem) {{ $shopitem->$description_add }} @else {{ old($description_add) }} @endisset</textarea>
                                                            </div>
                                                            @error('{{ $description_add }}')
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
                                                        <label class="form-label" for="status">{{ __('Статус') }}</label>
                                                        <div class="form-control-wrap">
                                                            <select id="status" name="status" class="form-select">
                                                                <option value="0" @if (isset($shopitem) && $shopitem->status == '0') selected @endif>{{ __('Для админов') }}</option>
                                                                <option value="1" @if (isset($shopitem) && $shopitem->status == '1') selected @endif>{{ __('Для всех') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label" for="label">{{ __('Этикетка') }}</label>
                                                        <div class="form-control-wrap">
                                                            <select id="label" name="label" class="form-select">
                                                                <option value="0" @if (isset($shopitem) && $shopitem->label == '0') selected @endif>{{ __('-') }}</option>
                                                                <option value="1" @if (isset($shopitem) && $shopitem->label == '1') selected @endif>{{ __('Популярный') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="image" class="form-label">@isset($shopitem) {{ __('Заменить изображение') }} @else {{ __('Изображение') }} @endisset</label>
                                                        <div class="form-control-wrap">
                                                            @isset($shopitem)
                                                                <span><img src="/storage/{{ $shopitem->image }}" alt="{{ $shopitem->id }}"></span>
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


                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <h3>{{ __('Вместе с этим часто покупают') }}:</h3>
                                    </div>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label class="form-label" for="product_name">{{ __('Добавить товар') }} <small style="display: block;font-size: 11px;">({{ __('введите название товара и выберите из выпадающего списка') }})</small></label>
                                            <div class="form-control-wrap">
                                                <input type="hidden" name="products[]" value="">
                                                <input type="text" class="form-control" id="product_name" name="product_name">
                                                <div class="form-icon form-icon-right" style="cursor: pointer;">
                                                    <em class="icon ni ni-search"></em>
                                                </div>
                                            </div>

                                            <div id="products-find"></div>
                                        </div>

                                        <div id="products-list">
                                            @if(isset($shopitem) && is_array($shopitem->togethers_arr))
                                                @foreach($shopitem->togethers_arr as $togethers)
                                                    <div class="product-item item_{{ $togethers }}"><input type="hidden" name="togethers[]" value="{{ $togethers }}"><div>{{ getshopitem($togethers)->$title }}</div><div class="product-del" onClick="ProductDelete({{ $togethers }});">x</div></div>
                                                @endforeach
                                            @endif
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
        function ProductSelect(product_id, product_name) {
            console.log(product_id);
            $('input[name="product_name"]').val('');
            $('#products-find').removeClass('find-active');
            $('#products-list').append('<div class="product-item item_'+product_id+'"><input type="hidden" name="togethers[]" value="'+product_id+'"><div>'+product_name+'</div><div class="product-del" onClick="ProductDelete('+product_id+');">x</div></div>');
            $('#products-find').html('');
        }
        function ProductDelete(product_id) {
            $('.item_'+product_id).remove();
        }

        $(document).ready(function () {
            var products = [];

            $('#product_name').change(function() {
                let input = $(this);
                let html = '';
                $.ajax({
                    type: "POST",
                    url: "{{ route('backend.shopitems.getProductByName') }}",
                    dataType: "json",
                    data: { product_name: $(this).val(), _token: $('input[name="_token"]').val() }
                }).done(function( data ) {
                    console.log(data);
                    if (data.status == 'success') {
                        $('#products-find').addClass('find-active');
                        $.each(data.products,function(index, product){
                            html = html + '<span class="product-find" onClick="ProductSelect(\''+product.id+'\',\''+product.title_{{ app()->getLocale() }}+'\');">'+product.title_{{ app()->getLocale() }}+'</span>';
                            $('#products-find').html(html);
                        });
                    } else {
                        input.addClass('error-input');
                    }
                });
            });
        });
    </script>

    <script>
        @foreach(getlangs() as $key => $value)

            @if(session()->has('theme') && session()->get('theme') == 'dark')
                CKEDITOR.addCss('.cke_editable { background-color: #0e1014; color: #942f06 }');
            @endif

            CKEDITOR.config.allowedContent=true;
            CKEDITOR.replace( 'description_{{ $key }}', {
                language: '{{ app()->getLocale() }}',
                filebrowserBrowseUrl : '/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserUploadUrl : '/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserImageBrowseUrl : '/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
            });
            CKEDITOR.config.allowedContent=true;
            CKEDITOR.replace( 'description_add_{{ $key }}', {
                language: '{{ app()->getLocale() }}',
                filebrowserBrowseUrl : '/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserUploadUrl : '/filemanager/dialog.php?type=2&editor=ckeditor&fldr=',
                filebrowserImageBrowseUrl : '/filemanager/dialog.php?type=1&editor=ckeditor&fldr='
            });
        @endforeach
    </script>
@endpush
