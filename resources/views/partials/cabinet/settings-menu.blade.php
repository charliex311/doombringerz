<div class="nk-block">
    <div class="row g-gs">
        <div class="col-12">
            <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">

                <li @class(['nav-item'])>
                    <a @class(['nav-link scroll-link', 'active' => Route::is('settings.profile')]) data-target="2"
                        href="/account/settings/profile#block-2">
                        <em class="icon ni ni-lock-alt-fill"></em>
                        <span>{{ __('Имя аккаунта') }}</span>
                    </a>
                </li>

                <li @class(['nav-item'])>
                    <a class="nav-link scroll-link" data-target="3" href="/account/settings/profile#block-3">
                        <em class="icon ni ni-lock-alt-fill"></em>
                        <span>{{ __('Изменить пароль') }}</span>
                    </a>
                </li>

                {{--
                <li @class(['nav-item'])>
                    <a @class(['nav-link']) href="{{ route('tickets') }}">
                        <em class="icon ni ni-lock-alt-fill"></em>
                        <span>{{ __('Изменить Email') }}</span>
                    </a>
                </li>
                --}}

                @if(config('options.ga_users_status', '0') == '1')

                    <li @class(['nav-item', 'active current-page' => Route::is('settings.profile_2fa')])>
                        <a @class(['nav-link', 'active' => Route::is('settings.profile_2fa')])
                            href="{{ route('settings.profile_2fa') }}"
                            >
                            <em class="icon ni ni-lock"></em>
                            <span>{{ __('2FA') }}</span>
                        </a>
                    </li>

                @endif

                <li @class(['nav-item'])>
                    <a class="nav-link scroll-link" data-target="5" href="/account/settings/profile#block-5">
                        <em class="icon ni ni-activity-round-fill"></em>
                        <span>{{ __('Активные устройства') }}</span>
                    </a>
                </li>

                <li @class(['nav-item', 'active current-page' => Route::is('activitylogs')])>
                    <a @class(['nav-link', 'active' => Route::is('activitylogs')])
                    href="{{ route('activitylogs') }}">
                        <em class="icon ni ni-file-docs"></em>
                        <span>{{ __('История Активности') }}</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
