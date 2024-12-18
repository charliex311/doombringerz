<section class="community section-margin">
    <div class="community__container main-container">
        <div class="community__body">
            <div class="community__inner">
                <div class="community__info">
                    <h3 class="community__title dark:text-gray-50">
                        {{ __('Присоединяйтесь к сообществу!') }}
                    </h3>
                    <div class="community__descr">
                        <p>
                            {{ __('Присоединяйтесь к нашему Discord, делитесь своей историей и предложениями — обсуждайте тактику рейдов, ищите товарищей по аренам и подземельям!') }}

                        </p>
                    </div>
                </div>
                <a href="{{ config('options.discord_link', 'https://discord.gg/QmrmHpEmnm') }}" target="_blank" class="community__invite btn ">
                    <span>{{ __('Присоединиться к Дискорд') }}</span>
                </a>
            </div>
        </div>
    </div>
</section>
