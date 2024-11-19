@extends('layouts.cabinet')

@section('title', __('Перенос на склад'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Перенос на склад') }} <span class="text-primary">{{ $inventory->name }} {{ $inventory->enchant > 0 ? "+{$inventory->enchant}" : '' }}</span></span>
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner border-top">
                        <form action="{{ route('characters.inventory.transfer', ['char_id' => $char_id, 'item_id' => $item_id]) }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="amount">{{ __('Введите количество') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                   value="{{ old('amount') ? old('amount') : $inventory->amount }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-lg btn-primary">{{ __('Перенести') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
