@extends('layouts.text')
@section('title', __('Политика конфиденциальности'))

@section('wrap')
    {!! config('options.policy', 'policy test') !!}
@endsection
