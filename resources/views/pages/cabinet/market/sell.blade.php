@extends('layouts.cabinet')

@section('title', __('Выставить предмет на продажу'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">@yield('title')</span>
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-reply-item">

                            <form method="POST" action="{{ route('market.sellout') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="form-label" for="item">{{ __('Выберите предмет') }}</label>
                                        <select id="item" name="item" class="form-select">
                                            @foreach($items as $item)
                                                <option data-amount="{{ $item->amount }}" value="{{ $item->type }}">{{ $item->name }} {{ $item->enchant > 0 ? "+{$item->enchant}" : '' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label" for="character">{{ __('Выберите категорию') }}</label>
                                        @php $title = "title_" .app()->getLocale(); @endphp
                                        <select id="category_id" name="category_id" class="form-select">
                                            @foreach($marketcategories as $marketcategory)
                                                <option value="{{ $marketcategory->id }}">{{ $marketcategory->$title }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group form-2">
                                        <div class="form-group">
                                            <label class="form-label" for="price">{{ __('Укажите цену') }}</label>
                                            <div class="form-control-wrap">
                                                <input type="number" min="1" class="form-control d-inline @error('title') is-invalid @enderror" id="price" name="price" value="1" required>
                                                @error('price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="amount">{{ __('Укажите количество') }} ({{ __('всего на складе') }}: <span id="amount-total">{{ $items[0]->amount }}</span>)</label>
                                            <div class="form-control-wrap">
                                                <input type="number" min="1" max="{{ $items[0]->amount }}" class="form-control d-inline @error('title') is-invalid @enderror" id="amount" name="amount" value="1" required>
                                                @error('amount')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="sale_type">{{ __('Выберите вариант продажи') }}</label>
                                        <select name="sale_type" class="form-select">
                                            <option value="0">{{ __('Продажа в розницу') }}</option>
                                            <option value="1">{{ __('Продажа оптом') }}</option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <p class="memo-title">{{ __('Памятка') }}:</p>
                                        <p class="memo-desc">{{ config('options.market_memo_desc_' .app()->getLocale(), '') }}</p>
                                    </div>

                                </div>
                                <div class="modal-footer bg-light">
                                    <button type="submit" class="btn btn-lg btn-primary">{{ __('Продать') }}</button>
                                </div>
                            </form>

                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection

        @push('scripts')
            <script>
                $(document).ready(function () {
                    $('#item').on('change', function () {
                        let amount = $('#item option:selected').data('amount');
                        console.log(amount);
                        $('#amount-total').text(amount);
                        $('#amount').prop('max', amount );
                    });
                });
            </script>
    @endpush
