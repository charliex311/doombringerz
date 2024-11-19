@extends('layouts.text')
@section('title', __('О нас'))

@section('wrap')
    {!! config('options.about_description_'.app()->getLocale(), '') !!}
@endsection

