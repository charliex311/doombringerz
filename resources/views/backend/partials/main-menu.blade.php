@canany(['admin', 'support', 'investor'])
                <!-- .nk-sidebar-element -->
                <div class="nk-sidebar-element">
                    <div class="nk-sidebar-content">
                        <div class="nk-sidebar-menu" data-simplebar>
                            <ul class="nk-menu">
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">{{ __('Администрирование') }}</h6>
                                </li>

                            @can('admin')
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item has-sub">
                                    <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                        <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                        <span class="nk-menu-text">{{ __('Пользователи') }}</span>
                                        <span class="nk-menu-badge">{{ users_count() }}</span>
                                    </a>
                                    <ul class="nk-menu-sub" style="">
                                        <li class="nk-menu-item {{ is_active('users') }}">
                                            <a href="{{ route('users') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Список пользователей') }}</span></a>
                                        </li>
                                        <li class="nk-menu-item {{ is_active('settings.game_options') }}">
                                            <a href="{{ route('settings.game_options') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Игровые Настройки') }}</span></a>
                                        </li>
                                    </ul>
                                    <!-- .nk-menu-sub -->
                                </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-coins"></em></span>
                                            <span class="nk-menu-text">{{ __('Пожертвования') }}</span>
                                            <span class="nk-menu-badge"></span>
                                        </a>
                                        <ul class="nk-menu-sub" style="">
                                            <li class="nk-menu-item {{ is_active('settings.donat') }}">
                                                <a href="{{ route('settings.donat') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки пожертвований') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.payments') }}">
                                                <a href="{{ route('settings.payments') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Платежные системы') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-cart"></em></span>
                                            <span class="nk-menu-text">{{ __('Магазин') }}</span>
                                            <span class="nk-menu-badge">{{ shopitems_count() }}</span>
                                        </a>
                                        <ul class="nk-menu-sub" style="">
                                            <li class="nk-menu-item {{ is_active('shopitems.index') }}">
                                                <a href="{{ route('shopitems.index') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Каталог') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.score') }}">
                                                <a href="{{ route('settings.score') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>
                                {{--
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-cart-fill"></em></span>
                                            <span class="nk-menu-text">{{ __('Торговая площадка') }}</span>
                                            <span class="nk-menu-badge">{{ marketitems_count() }}</span>
                                        </a>
                                        <ul class="nk-menu-sub" style="">
                                            <li class="nk-menu-item {{ is_active('marketitems.index') }}">
                                                <a href="{{ route('marketitems.index') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Каталог') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.market') }}">
                                                <a href="{{ route('settings.market') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>
                                    --}}
                                @endcan

                                @can('investor')
                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                <span class="nk-menu-text">{{ __('Рефералы') }}</span>
                                                <span class="nk-menu-badge">{{ referrals_count() }}</span>
                                            </a>
                                            <!-- .nk-menu-sub -->
                                            <ul class="nk-menu-sub" style="">
                                                <li class="nk-menu-item {{ is_active('referrals.index') }}">
                                                    <a href="{{ route('referrals.index') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Список рефералов') }}</span></a>
                                                </li>
                                                <li class="nk-menu-item {{ is_active('settings.referrals') }}">
                                                    <a href="{{ route('settings.referrals') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                                </li>
                                            </ul>
                                        </li>

                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                                <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                                                <span class="nk-menu-text">{{ __('Промокоды') }}</span>
                                                <span class="nk-menu-badge">{{ referrals_count() }}</span>
                                            </a>
                                            <!-- .nk-menu-sub -->
                                            <ul class="nk-menu-sub" style="">
                                                <li class="nk-menu-item {{ is_active('promocodes.index') }}">
                                                    <a href="{{ route('promocodes.index') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Список промокодов') }}</span></a>
                                                </li>
                                                <li class="nk-menu-item {{ is_active('settings.promocodes') }}">
                                                    <a href="{{ route('settings.promocodes') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                                </li>
                                            </ul>
                                        </li>
                                @endcan

                                @can('admin')
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.voting') }}" class="nk-menu-link {{ is_active('settings.voting') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-check-circle"></em></span>
                                            <span class="nk-menu-text">{{ __('Голосование') }}</span>
                                            <span class="nk-menu-badge">{{ count(getvoting_platforms()) }}</span>
                                        </a>
                                    </li>
                                    {{--
                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('settings.auction') }}" class="nk-menu-link {{ is_active('settings.auction') }}">
                                                <span class="nk-menu-icon"><em class="icon ni ni-coin"></em></span>
                                                <span class="nk-menu-text">{{ __('Аукцион') }}</span>
                                                <span class="nk-menu-badge">{{ auctions_count() }}</span>
                                            </a>
                                        </li>
                                        --}}

                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('shopcoupons.index') }}" class="nk-menu-link {{ is_active('shopcoupons.index') }}">
                                                <span class="nk-menu-icon"><em class="icon ni ni-cards"></em></span>
                                                <span class="nk-menu-text">{{ __('Купоны') }}</span>
                                                <span class="nk-menu-badge">{{ shopcoupons_count() }}</span>
                                            </a>
                                        </li>

                                    {{--
                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('backend.bonusitems') }}" class="nk-menu-link {{ is_active('backend.bonusitems') }}">
                                                <span class="nk-menu-icon"><em class="icon ni ni-box"></em></span>
                                                <span class="nk-menu-text">{{ __('Бонусные предметы') }}</span>
                                            </a>
                                        </li>
                                    --}}

                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item">
                                            <a href="{{ route('settings.luckywheel') }}" class="nk-menu-link {{ is_active('settings.luckywheel') }}">
                                                <span class="nk-menu-icon"><em class="icon ni ni-help-alt"></em></span>
                                                <span class="nk-menu-text">{{ __('Колесо удачи') }}</span>
                                                <span class="nk-menu-badge">{{ auctions_count() }}</span>
                                            </a>
                                        </li>

                                @endcan

                            @can('support')
                                <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('tickets.all') }}"
                                           class="nk-menu-link {{ is_active('tickets.all') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-emails"></em></span>
                                                <span class="nk-menu-text">{{ __('Поддержка') }}</span>
                                            <span class="nk-menu-badge">{{ tickets_count() }}</span>
                                        </a>
                                    </li>

                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-alert-circle"></em></span>
                                            <span class="nk-menu-text">{{ __('Баг трекер') }}</span>
                                            <span class="nk-menu-badge">{{ reports_count() }}</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item {{ is_active('reports.all') }}">
                                                <a href="{{ route('reports.all') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Список сообщений') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.reports') }}">
                                                <a href="{{ route('settings.reports') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>

                                    <li class="nk-menu-item">
                                        <a href="{{ route('releasenotes.index') }}"
                                           class="nk-menu-link {{ is_active('releasenotes.index') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-view-list-wd"></em></span>
                                            <span class="nk-menu-text">{{ __('Логи Релизов') }}</span>
                                            <span class="nk-menu-badge">{{ releasenotes_count() }}</span>
                                        </a>
                                    </li>

                            @endcan

                                @can('admin')
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('servers.index') }}" class="nk-menu-link {{ is_active('servers.index') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-grid-plus"></em></span>
                                            <span class="nk-menu-text">{{ __('Игровые сервера') }}</span>
                                            <span class="nk-menu-badge">{{ servers_count() }}</span>
                                        </a>
                                    </li>
                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                                <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                                                <span class="nk-menu-text">{{ __('Логин и регистрация') }}</span>
                                                <span class="nk-menu-badge"></span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item {{ is_active('settings.login') }}">
                                                    <a href="{{ route('settings.login') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                                </li>
                                                <li class="nk-menu-item {{ is_active('settings.login_2fa') }}">
                                                    <a href="{{ route('settings.login_2fa') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Двухфакторная авторизация') }}</span></a>
                                                </li>
                                                <li class="nk-menu-item {{ is_active('settings.sms') }}">
                                                    <a href="{{ route('settings.sms') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('SMS настройки') }}</span></a>
                                                </li>
                                            </ul>
                                            <!-- .nk-menu-sub -->
                                        </li>

                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                                <span class="nk-menu-icon"><em class="icon ni ni-link"></em></span>
                                                <span class="nk-menu-text">{{ __('Настройки') }} APIs</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item {{ is_active('settings.discord_api') }}">
                                                    <a href="{{ route('settings.discord_api') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Discord API</span></a>
                                                </li>
                                            </ul>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item {{ is_active('settings.google_api') }}">
                                                    <a href="{{ route('settings.google_api') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">Google API</span></a>
                                                </li>
                                            </ul>
                                            <!-- .nk-menu-sub -->
                                        </li>
                                @endcan

                                @can('admin')
                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">{{ __('Контент сайта') }}</h6>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                                            <span class="nk-menu-text">{{ __('Настройки сайта') }}</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item {{ is_active('settings.project_name') }}">
                                                <a href="{{ route('settings.project_name') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Название проекта') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.register') }}">
                                                <a href="{{ route('settings.register') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Регистрация') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.robots') }}">
                                                <a href="{{ route('settings.robots') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Robots.txt') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.sitemap') }}">
                                                <a href="{{ route('settings.sitemap') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Sitemap') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.langs') }}">
                                                <a href="{{ route('settings.langs') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Языки') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.analitics') }}">
                                                <a href="{{ route('settings.analitics') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Счетчики и аналитика') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.recaptcha') }}">
                                                <a href="{{ route('settings.recaptcha') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Recaptcha') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.smtp') }}">
                                                <a href="{{ route('settings.smtp') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('SMTP') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>

                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.site') }}" class="nk-menu-link {{ is_active('settings.site') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-home"></em></span>
                                            <span class="nk-menu-text">{{ __('Главная') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('features.index') }}" class="nk-menu-link {{ is_active('features.index') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                            <span class="nk-menu-text">{{ __('Особенности') }}</span>
                                            <span class="nk-menu-badge">{{ features_count() }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('releases.index') }}" class="nk-menu-link {{ is_active('releases.index') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-view-col3"></em></span>
                                            <span class="nk-menu-text">{{ __('Дорожная карта') }}</span>
                                            <span class="nk-menu-badge">{{ releases_count() }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.about') }}" class="nk-menu-link {{ is_active('settings.about') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-focus"></em></span>
                                            <span class="nk-menu-text">{{ __('О нас') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.about_servers') }}" class="nk-menu-link {{ is_active('settings.about_servers') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-grid-alt"></em></span>
                                            <span class="nk-menu-text">{{ __('О Серверах') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('articles.index') }}" class="nk-menu-link {{ is_active('articles.index') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-article"></em></span>
                                            <span class="nk-menu-text">{{ __('Новости') }}</span>
                                            <span class="nk-menu-badge">{{ articles_count() }}</span>
                                        </a>
                                    </li>

                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-chat-circle"></em></span>
                                            <span class="nk-menu-text">{{ __('Частые вопросы') }}</span>
                                            <span class="nk-menu-badge">{{ faqs_count() }}</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item {{ is_active('faqs.index') }}">
                                                <a href="{{ route('faqs.index') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Список вопросов') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.faq_page') }}">
                                                <a href="{{ route('settings.faq_page') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>


                                {{--
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.download') }}" class="nk-menu-link {{ is_active('settings.download') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-download"></em></span>
                                            <span class="nk-menu-text">{{ __('Скачать') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('videos.index') }}" class="nk-menu-link {{ is_active('videos.index') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-video"></em></span>
                                            <span class="nk-menu-text">{{ __('Видео') }}</span>
                                            <span class="nk-menu-badge">{{ videos_count() }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item has-sub">
                                        <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                            <span class="nk-menu-icon"><em class="icon ni ni-play"></em></span>
                                            <span class="nk-menu-text">{{ __('Стримы') }}</span>
                                            <span class="nk-menu-badge">{{ streams_count() }}</span>
                                        </a>
                                        <ul class="nk-menu-sub">
                                            <li class="nk-menu-item {{ is_active('streams.index') }}">
                                                <a href="{{ route('streams.index') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Управление') }}</span></a>
                                            </li>
                                            <li class="nk-menu-item {{ is_active('settings.streams') }}">
                                                <a href="{{ route('settings.streams') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                            </li>
                                        </ul>
                                        <!-- .nk-menu-sub -->
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.social') }}" class="nk-menu-link {{ is_active('settings.social') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-signal"></em></span>
                                            <span class="nk-menu-text">{{ __('Соц сети и виджеты') }}</span>
                                        </a>
                                    </li>
                                    --}}

                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.forum') }}" class="nk-menu-link {{ is_active('settings.forum') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-rss"></em></span>
                                            <span class="nk-menu-text">{{ __('Форум') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item">
                                        <a href="{{ route('settings.policy') }}" class="nk-menu-link {{ is_active('settings.policy') }}">
                                            <span class="nk-menu-icon"><em class="icon ni ni-reports-alt"></em></span>
                                            <span class="nk-menu-text">{{ __('Соглашение и политика') }}</span>
                                        </a>
                                    </li>

                                    @endcan

                                @can('admin')
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">{{ __('Статус серверов') }}</h6>
                                </li>
                                @foreach(getservers() as $server)
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item">
                                    <a href="{{ route('server.settings', $server) }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-server"></em></span>
                                        <span class="nk-menu-text">{{ $server->name }}</span>
                                        <span class="badge badge-pill badge-{{ server_status($server->id) === 'Online' ? 'success' : 'danger' }}">
                                            {{ server_status($server->id) }} @if(server_status($server->id) === 'Online') ({{ online_count($server->id) }}) @endif
                                        </span>

                                    </a>
                                </li>
                                @endforeach

                                @endcan

                                @can('investor')
                                <li class="nk-menu-heading">
                                    <h6 class="overline-title text-primary-alt">{{ __('Логи и статистика') }}</h6>
                                </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item {{ is_active('logs.activitylogs') }}">
                                        <a href="{{ route('logs.activitylogs') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                            <span class="nk-menu-text">{{ __('Логи активности') }}</span>
                                        </a>
                                    </li>
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item {{ is_active('logs.payments') }}">
                                    <a href="{{ route('logs.payments') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-wallet-saving"></em></span>
                                        <span class="nk-menu-text">{{ __('Статистика платежей') }}</span>
                                    </a>
                                </li>
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item {{ is_active('logs.registrations') }}">
                                    <a href="{{ route('logs.registrations') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-user"></em></span>
                                        <span class="nk-menu-text">{{ __('Статистика регистрации') }}</span>
                                    </a>
                                </li>
                                <!-- .nk-menu-item -->
                                    <li class="nk-menu-item {{ is_active('logs.visits') }}">
                                        <a href="{{ route('logs.visits') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-activity-alt"></em></span>
                                            <span class="nk-menu-text">{{ __('Статистика посещений') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                <li class="nk-menu-item {{ is_active('logs.gamecurrencylogs') }}">
                                    <a href="{{ route('logs.gamecurrencylogs') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-invest"></em></span>
                                        <span class="nk-menu-text">{{ __('Логи игровой валюты') }}</span>
                                    </a>
                                </li>
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item {{ is_active('logs.adminlogs') }}">
                                    <a href="{{ route('logs.adminlogs') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-file-docs"></em></span>
                                        <span class="nk-menu-text">{{ __('Логи администраторов') }}</span>
                                    </a>
                                </li>
                                <!-- .nk-menu-item -->
                                <li class="nk-menu-item {{ is_active('logs.servererrors') }}">
                                    <a href="{{ route('logs.servererrors') }}" class="nk-menu-link">
                                        <span class="nk-menu-icon"><em class="icon ni ni-alert-circle"></em></span>
                                        <span class="nk-menu-text">{{ __('Ошибки сервера') }}</span>
                                    </a>
                                </li>
                                @endcan

                                    @can('admin')
                                        {{--
                                        <!-- .nk-menu-item -->
                                        <li class="nk-menu-item has-sub">
                                            <a href="#" class="nk-menu-link nk-menu-toggle" data-original-title="" title="">
                                                <span class="nk-menu-icon"><em class="icon ni ni-wallet-saving"></em></span>
                                                <span class="nk-menu-text">{{ __('Статистика игровых предметов') }}</span>
                                            </a>
                                            <ul class="nk-menu-sub">
                                                <li class="nk-menu-item {{ is_active('logs.statistics_game_items') }}">
                                                    <a href="{{ route('logs.statistics_game_items') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Статистика') }}</span></a>
                                                </li>
                                                <li class="nk-menu-item {{ is_active('settings.statistics_game_items') }}">
                                                    <a href="{{ route('settings.statistics_game_items') }}" class="nk-menu-link" data-original-title="" title=""><span class="nk-menu-text">{{ __('Настройки') }}</span></a>
                                                </li>
                                            </ul>
                                            <!-- .nk-menu-sub -->
                                        </li>
                                        --}}

                                    <li class="nk-menu-heading">
                                        <h6 class="overline-title text-primary-alt">{{ __('Аккаунт') }}</h6>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item {{ is_active('backend.settings.profile') }}">
                                        <a href="{{ route('backend.settings.profile') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-setting-alt"></em></span>
                                            <span class="nk-menu-text">{{ __('Настройки профиля') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item {{ is_active('backend.settings.activity') }}">
                                        <a href="{{ route('backend.settings.activity') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-activity-alt"></em></span>
                                            <span class="nk-menu-text">{{ __('Активные устройства') }}</span>
                                        </a>
                                    </li>
                                    <!-- .nk-menu-item -->
                                    <li class="nk-menu-item {{ is_active('backend.settings.security') }}">
                                        <a href="{{ route('backend.settings.security') }}" class="nk-menu-link">
                                            <span class="nk-menu-icon"><em class="icon ni ni-lock-alt-fill"></em></span>
                                            <span class="nk-menu-text">{{ __('Настройки безопасности') }}</span>
                                        </a>
                                    </li>

                                @endcan


                            </ul><!-- .nk-menu -->
                        </div><!-- .nk-sidebar-menu -->
                    </div><!-- .nk-sidebar-content -->
                </div><!-- .nk-sidebar-element -->

@endcan
