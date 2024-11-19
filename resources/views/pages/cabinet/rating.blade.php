@extends('layouts.cabinet')
@section('title', __('Рейтинг игроков сервера'))

@section('wrap')
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#PVP">
                            <span>{{ __('PVP') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#PK">
                            <span>{{ __('PK') }}</span>
                        </a>
                    </li>
                    <li class="nav-item current-page">
                        <a class="nav-link" data-toggle="tab" href="#EXP">
                            <span>{{ __('EXP') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#CLAN">
                            <span>{{ __('КЛАН') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#CLAN_PVP">
                            <span>{{ __('КЛАН PVP') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#Castles">
                            <span>{{ __('ЗАМКИ') }}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#CLAN_HOLL">
                            <span>{{ __('КЛАН ХОЛЛЫ') }}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">
                <div class="tab-content">
                    <div class="tab-pane active" id="PVP">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Имя') }}</th><th>{{ __('Класс') }}</th><th>{{ __('Клан') }}</th><th>{{ __('ПВП') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($rating->pvp as $pvp)

					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td class="align-middle">{{ $pvp->char_name }}</td>
                                            <td class="align-middle">{{ class_name($pvp->class_name) ?: $pvp->class_name }}</td>
                                            <td class="align-middle">{{ $pvp->p_name ?: __('нет') }}</td>
                                            <td class="align-middle">{{ $pvp->Duel }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="PK">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Имя') }}</th><th>{{ __('Класс') }}</th><th>{{ __('Клан') }}</th><th>{{ __('ПК') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rating->pk as $pk)
					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td class="align-middle">{{ $pk->char_name }}</td>
                                            <td class="align-middle">{{ class_name($pk->class_name) ?: $pk->class_name }}</td>
                                            <td class="align-middle">{{ $pk->p_name ?: __('нет') }}</td>
                                            <td class="align-middle">{{ $pk->PK }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="EXP">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Имя') }}</th><th>{{ __('Класс') }}</th><th>{{ __('Клан') }}</th><th>{{ __('Уровень') }}</th><th>{{ __('ПВП / ПК') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rating->exp as $exp)
					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td class="align-middle">{{ $exp->char_name }}</td>
                                            <td class="align-middle">{{ class_name($exp->class_name) ?: $exp->class_name }}</td>
                                            <td class="align-middle">{{ $exp->p_name ?: __('нет') }}</td>
                                            <td class="align-middle">{{ $exp->Lev }}</td>
                                            <td class="align-middle">{{ $exp->Duel }} / {{ $exp->PK }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="CLAN">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Имя') }}</th><th>{{ __('Альянс') }}</th><th>{{ __('Замок') }}</th><th>{{ __('Клан Холл') }}</th>
                                        <th>{{ __('Уровень') }}</th><th>{{ __('Игроков') }}</th><th>{{ __('ПВП') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rating->clan as $item)
					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td class="align-middle">{{ $item->p_name ?? '-' }}</td>
                                            <td class="align-middle">{{ $item->ally_name ?? '-' }}</td>
                                            <td class="align-middle">{{ $item->castle_name ?: castle_name($item->castle) }}</td>
                                            <td class="align-middle">{{ $item->clanholl_name }}</td>
                                            <td class="align-middle">{{ $item->skill_level }}</td>
                                            <td class="align-middle">{{ $item->member_count }}</td>
                                            <td class="align-middle">{{ $item->pvp }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="CLAN_PVP">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Имя') }}</th><th>{{ __('Альянс') }}</th><th>{{ __('Замок') }}</th><th>{{ __('Клан Холл') }}</th>
                                        <th>{{ __('Уровень') }}</th><th>{{ __('Игроков') }}</th><th>{{ __('ПВП') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rating->clan_pvp as $item)
					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td class="align-middle">{{ $item->p_name ?? '-' }}</td>
                                            <td class="align-middle">{{ $item->ally_name ?? '-' }}</td>
                                            <td class="align-middle">{{ $item->castle_name ?: castle_name($item->castle) }}</td>
                                            <td class="align-middle">{{ $item->clanholl_name }}</td>
                                            <td class="align-middle">{{ $item->skill_level }}</td>
                                            <td class="align-middle">{{ $item->member_count }}</td>
                                            <td class="align-middle">{{ $item->pvp }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="Castles">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Замок') }}</th><th>{{ __('Имя') }}</th><th>{{ __('Налог') }}</th>
                                        <th>{{ __('Клан') }}</th><th>{{ __('Лидер') }}</th><th>{{ __('Дата') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rating->castles as $castle)
					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td>
                                                <img src="{{ asset("images/castle/{$castle->id}.jpg") }}" alt="" class="img-thumbnail" style="max-width: 40%">
                                            </td>
                                            <td class="align-middle">{{ castle_name($castle->id) }}</td>
                                            <td class="align-middle">{{ $castle->tax_rate }}%</td>
                                            <td class="align-middle">{{ $castle->clan_name }}</td>
                                            <td class="align-middle">{{ $castle->char_name }}</td>
                                            <td class="align-middle">{{ $castle->next_war_time ? date('d/m/Y H:i', strtotime("+1 hours", $castle->next_war_time)) : '' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="CLAN_HOLL">
                        <div class="card card-bordered">
                            <div class="card-inner table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark text-uppercase">
                                    <tr>
                                        <th>№</th><th>{{ __('Имя') }}</th><th>{{ __('Город') }}</th><th>{{ __('Клан') }}</th><th>{{ __('Лидер Клана') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($rating->agit as $item)
					@if ($loop->iteration == 1)
                                        <tr style="color: #bf9e41;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_gold.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 2)
                                        <tr style="color: #858186;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_silver.png" alt="1" width="23px" height="23px"/></th>
					@elseif ($loop->iteration == 3)
                                        <tr style="color: #bf6b19;">
                                            <th scope="row" class="align-middle" style="padding-left: 12px;"><img src="/images/medal_bronze.png" alt="1" width="23px" height="23px"/></th>
					@else
                                        <tr>
                                            <th scope="row" class="align-middle">{{ $loop->iteration }}</th>
					@endif
                                            <td class="align-middle">{{ $item->name ?: clan_hall_name($item->id) }}</td>
                                            <td class="align-middle">{{ $item->location ?: clan_hall_name($item->id, 'town') }}</td>
                                            <td class="align-middle">{{ $item->clan_name ?: '-' }}</td>
                                            <td class="align-middle">{{ $item->char_name ?: '-' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <p class="text-right text-gray p-2">{{ __('Последнее обновление') }} {{ $rating->last_update_at->format('d.m.Y в H:i') }}</p>
@endsection
