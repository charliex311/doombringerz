@extends('layouts.text')
@section('title', __('О Серверах'))

@section('wrap')
    {!! config('options.about_servers_description_'.app()->getLocale()) !!}
@endsection

