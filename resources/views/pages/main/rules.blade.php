@extends('layouts.text')
@section('title', __('Правила и положения'))

@section('wrap')
    {!! config('options.rules', '') !!}
@endsection

