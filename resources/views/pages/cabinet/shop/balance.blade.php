    <div class="user-currency">
        <p>{{ __('Текущий баланс') }}</p>
        <a href="{{ route('donate') }}"><span><img src="/images/tot-icon.png"/>{{ auth()->user()->balance }}<i><img src="images/plus-icon2.png"></i></span></a>
    </div>