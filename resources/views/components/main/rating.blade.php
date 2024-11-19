<div class="main__content-rating">

    <div class="main__content-rating--select">
        <a href="#" class="active" data-tab="tabPlayers">{{ __('Топ Игроков') }}</a>
        <a href="#" data-tab="tabClans">{{ __('Топ Кланов') }}</a>
        <a href="#" data-tab="tabCastles">{{ __('Топ Замков') }}</a>
    </div>
    <div class="main__content-rating--content active" id="tabPlayers">
	@if (isset($players))
        @foreach($players as $player)
            <div class="main__content-rating--item">
                {{ $player->char_name }} <span class="main__content-rating--item-rating">{{ $player->Duel }}</span>
            </div>
        @endforeach
	@endif
    </div>
    <div class="main__content-rating--content" id="tabClans">
	@if (isset($clans))
        @foreach($clans as $clan)
            <div class="main__content-rating--item">
                {{ $clan->p_name ?? '-' }} <span class="main__content-rating--item-rating">{{ $clan->pvp }}</span>
            </div>
        @endforeach
	@endif
    </div>
    <div class="main__content-rating--content" id="tabCastles">
        @foreach($castles as $castle)
            <div class="main__content-rating--item">
                {{ castle_name($castle->id) }} <span class="main__content-rating--item-rating">{{ $castle->clan_name }}</span>
            </div>
        @endforeach
    </div>
</div>
