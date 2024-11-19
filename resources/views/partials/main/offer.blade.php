<section class="offer">
    <div class="offer__video home__video">
        <video autoplay="" loop="" muted="">
            <source src="/img/bg_offer.mp4" type="video/mp4">
            <source src="/img/bg_offer.webm" type="video/webm">
        </video>
    </div>
    <div class="offer__container main-container">
        <div class="offer__body">
            <h5 class="offer__title main-title">
                {{ __('Ваше путешествие начинается здесь') }}
            </h5>
            <div class="offer__info">
                <div class="offer__descr">
                    {{ __('Испытайте постоянно расширяющуюся фантазию World of Warcraft БЕСПЛАТНО уже сегодня.') }}
                </div>

                @if(auth()->check())
                    <a href="{{ route('cabinet') }}" class="offer__create-acc">
                        <span>{{ __('ИГРАТЬ СЕЙЧАС') }}</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="offer__create-acc">
                        <span>{{ __('ЗАВЕСТИ АККАУНТ') }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
