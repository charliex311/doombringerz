@extends('backend.layouts.backend')

@section('title', __('Панель управления') . ' - ' . __('Торговая площадка'))
@section('headerTitle', __('Торговая площадка'))
@section('headerDesc', __('Список предметов торговой площадки.'))

@section('wrap')

    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="card card-bordered">
                    <div class="card-inner">
                        <div class="card-title-group">
                            <h5 class="card-title">
                                <a href="{{ route('marketcategories.index') }}" class="btn btn-sm btn-primary">
                                    <em class="icon ni ni-folder-list mr-sm-1"></em>
                                    <span class="d-none d-sm-inline">{{ __('Категории') }}</span>
                                </a>
                            </h5>
                            <div class="card-tools d-none d-md-inline">
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="{{ __('Поиск') }}...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if(!empty($marketitems))
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-orders">
                            @foreach($marketitems as $marketitem)
                            <div class="nk-tb-item">
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @if(strpos($marketitem->icon, 'images') === FALSE)
                                            <img src="{{ asset("images/items/{$marketitem->icon}.png") }}" alt="" title="{{ $marketitem->name }}">
                                        @else
                                            <img src="{{ asset("/storage/{$marketitem->icon}") }}" alt="" title="{{ $marketitem->name }}">
                                        @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @php
                                            $title = "title_" .app()->getLocale();
                                            $description = "description_" .app()->getLocale();
                                        @endphp
                                        <div class="user-name"> <span class="tb-lead">#{{ $marketitem->id }}  {{ $marketitem->name }} {{ $marketitem->enchant > 0 ? "+{$marketitem->enchant}" : '' }}</span> </div>
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                       {{ $marketitem->enchant }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                       {{ $marketitem->amount }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                       {{ $marketitem->price }}
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                        @if($marketitem->sale_type == 1)
                                            {{ __('Продажа оптом') }}
                                        @else
                                            {{ __('Продажа в розницу') }}
                                        @endif
                                    </span>
                                </div>
                                <div class="nk-tb-col">
                                    <span class="tb-lead">
                                         {{ getuser($marketitem->user_id)->name }}
                                    </span>
                                </div>
                                <div class="nk-tb-col tb-col-md">
                                    <span class="tb-sub">
                                        {{ $marketitem->created_at->format('d/m/Y H:i') }}
                                    </span>
                                </div>
                                <div class="nk-tb-col nk-tb-col-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown">
                                            <em class="icon ni ni-more-h"></em>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <ul class="link-list-plain">
                                                <form action="{{ route('marketitems.destroy', $marketitem) }}" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <li><a href="#" class="text-danger" onclick="this.closest('form').submit();return false;">{{ __('Удалить') }}</a></li>
                                                </form>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-inner">
                        {{ $marketitems->links('layouts.pagination.cabinet') }}
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <!-- .nk-block -->
@endsection
