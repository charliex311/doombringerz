@extends('layouts.cabinet')

@section('title', 'Пользователи')

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
                            <div class="card-tools">
                                <form method="GET">
                                    <div class="form-control-wrap">
                                        <div class="form-icon form-icon-left">
                                            <em class="icon ni ni-search"></em>
                                        </div>
                                        <input type="text" class="form-control" name="search" value="{{ request()->query('search') }}" placeholder="Поиск...">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-inner p-0 border-top">
                        <div class="nk-tb-list nk-tb-ulist is-compact">
                            <div class="nk-tb-item nk-tb-head">
                                <div class="nk-tb-col"><span class="sub-text">Пользователь</span></div>
                                <div class="nk-tb-col"><span class="sub-text">Роль</span></div>
                                <div class="nk-tb-col tb-col-md"><span class="sub-text">Дата регистрации</span></div>
                            </div>
                            <!-- .nk-tb-item -->
                            @foreach($users as $user)
                                <div class="nk-tb-item">
                                    <div class="nk-tb-col">
                                        <div class="user-card">
                                            <div class="user-avatar xs bg-primary">
                                                <span class="text-uppercase"> {{ substr(trim($user->name), 0, 2) }} </span>
                                            </div>
                                            <div class="user-name">
                                                <span class="tb-lead">{{ $user->name }}</span>
                                                <span>{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="nk-tb-col"> <span>{{ $user->role }}</span> </div>
                                    <div class="nk-tb-col tb-col-md"> <span>{{ $user->created_at->format('d.m.Y H:i') }}</span> </div>

                                    <div class="nk-tb-col nk-tb-col-tools">
                                        <div class="drodown">
                                            <a href="#"
                                               class="btn btn-sm btn-icon btn-trigger dropdown-toggle" data-toggle="dropdown" title="Назначить роль">
                                                <em class="icon ni ni-more-h"></em>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li>
                                                        <a href="{{ route('user.role.admin', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>Администратор</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('user.role.support', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>Поддержка</span>
                                                        </a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li>
                                                        <a href="{{ route('user.role.user', $user) }}">
                                                            <em class="icon ni ni-inbox"></em>
                                                            <span>Пользователь</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="card-inner">
                        {{ $users->links('layouts.pagination.cabinet') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
