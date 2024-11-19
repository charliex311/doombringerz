@extends('layouts.cabinet')

@section('title', __('Выставить') . " " . $warehouse->name . __('на аукцион'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <span class="mr-2">{{ __('Выставить на аукцион') }}: <span class="text-primary">{{ $warehouse->name }} {{ $warehouse->enchant > 0 ? "+{$warehouse->enchant}" : '' }}</span></span>
                            </h5>
                        </div>
                    </div>
                    <div class="card-inner border-top">
                        <form action="{{ route('warehouse.auction', $warehouse) }}" method="POST">
                            @csrf

                            <div class="row g-4">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label class="form-label" for="start_price">{{ __('Стартовая цена') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="start_price" name="start_price"
                                                   value="1">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="buyout_price">{{ __('Блиц-цена') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="buyout_price" name="buyout_price"
                                                   value="10">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label" for="amount">{{ __('Введите количество') }}</label>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" id="amount" name="amount"
                                                   value="{{ old('amount') ? old('amount') : $warehouse->amount }}">
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
