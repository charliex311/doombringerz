<div class="modal modal_success" id="success">
    <div class="modal__container">
        <div class="modal__body">
            <div class="modal__close">
                <svg>
                    <use href="img/sprite/sprite.svg#close-icon"></use>
                </svg>
            </div>
            <div class="modal__inner">
                <div class="modal__heading">
                    {{ __('Успешная регистрация на') }} <span class="success-server">Server</span>!
                </div>
                <div class="modal__success-text">
                    {!! config('options.reg_success_description_'.app()->getLocale()) !!}
                </div>
                <button class="modal__continue btn">
                    <span>{{ __('Продолжить дальше') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>
