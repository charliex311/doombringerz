@extends('backend.layouts.backend')

@section('title', 'Панель управления - ' . __('Настройки'))
@section('headerTitle', __('Настройки'))
@section('headerDesc', __('Настройки платежных систем') . '.')

@section('wrap')
    <!-- .nk-block -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-12">

                    <div class="tab-pane" id="shop">
                        <div class="card card-bordered">
                            <div class="card-inner">
                                <form action="{{ route('backend.settings') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row g-4">

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">PayPal</div>
                                            <div class="payments-options" style="display: none;">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="paypal_client_id">{{ __('Client ID') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="paypal_client_id"
                                                                   name="setting_paypal_client_id"
                                                                   value="{{ config('options.paypal_client_id', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="paypal_secret">{{ __('Secret') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="paypal_secret"
                                                                   name="setting_paypal_secret"
                                                                   value="{{ config('options.paypal_secret', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Stripe</div>
                                            <div class="payments-options" style="display: none;">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="stripe_publishable_key">{{ __('PUBLISHABLE KEY') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="stripe_publishable_key"
                                                                   name="setting_stripe_publishable_key"
                                                                   value="{{ config('options.stripe_publishable_key', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="stripe_secret_key">{{ __('SECRET KEY') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="stripe_secret_key"
                                                                   name="setting_stripe_secret_key"
                                                                   value="{{ config('options.stripe_secret_key', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="stripe_signing_secret">{{ __('WEBHOOK SIGNING SECRET') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="stripe_signing_secret"
                                                                   name="setting_stripe_signing_secret"
                                                                   value="{{ config('options.stripe_signing_secret', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Skrill</div>
                                            <div class="payments-options" style="display: none;">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="skrill_client_id">{{ __('CLIENT ID') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="skrill_client_id"
                                                                   name="setting_skrill_client_id"
                                                                   value="{{ config('options.skrill_client_id', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="skrill_secret_key">{{ __('SECRET KEY') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="skrill_secret_key"
                                                                   name="setting_skrill_secret_key"
                                                                   value="{{ config('options.skrill_secret_key', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


{{--
                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Enot.io</div>
                                            <div class="payments-options" style="display: none;">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="enot_merchant_id">{{ __('Merchant ID') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="enot_merchant_id"
                                                                   name="setting_enot_merchant_id"
                                                                   value="{{ config('options.enot_merchant_id', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="enot_secret_word">{{ __('Secret Word') }}</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="enot_secret_word"
                                                                   name="setting_enot_secret_word"
                                                                   value="{{ config('options.enot_secret_word', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label class="form-label"
                                                               for="enot_secret_word_2">{{ __('Secret Word') }} 2</label>
                                                        <div class="form-control-wrap">
                                                            <input type="text" class="form-control" id="enot_secret_word_2"
                                                                   name="setting_enot_secret_word_2"
                                                                   value="{{ config('options.enot_secret_word_2', "") }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Free-Kassa</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="freekassa_merchant_id">{{ __('Merchant ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="freekassa_merchant_id"
                                                               name="setting_freekassa_merchant_id"
                                                               value="{{ config('options.freekassa_merchant_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="freekassa_secret_word">{{ __('Secret Word') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="freekassa_secret_word"
                                                               name="setting_freekassa_secret_word"
                                                               value="{{ config('options.freekassa_secret_word', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="freekassa_secret_word_2">{{ __('Secret Word') }} 2</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="freekassa_secret_word_2"
                                                               name="setting_freekassa_secret_word_2"
                                                               value="{{ config('options.freekassa_secret_word_2', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Cent.app</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="setting_cent_authorization">{{ __('Authorization key') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="setting_cent_authorization"
                                                               name="setting_cent_authorization"
                                                               value="{{ config('options.cent_authorization', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="setting_cent_shop_id">{{ __('Shop ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="setting_cent_shop_id"
                                                               name="setting_cent_shop_id"
                                                               value="{{ config('options.cent_shop_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">PrimePayments</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="primepayments_project">{{ __('ID проекта') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="primepayments_project"
                                                               name="setting_primepayments_project"
                                                               value="{{ config('options.primepayments_project', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="primepayments_secret1">{{ __('Секретное слово 1') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="primepayments_secret1"
                                                               name="setting_primepayments_secret1"
                                                               value="{{ config('options.primepayments_secret1', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="primepayments_secret2">{{ __('Секретное слово 2') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="primepayments_secret2"
                                                               name="setting_primepayments_secret2"
                                                               value="{{ config('options.primepayments_secret2', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Qiwi</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="qiwi_secret_key">{{ __('SECRET KEY') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="qiwi_secret_key"
                                                               name="setting_qiwi_secret_key"
                                                               value="{{ config('options.qiwi_secret_key', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="qiwi_account">{{ __('ACCOUNT') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="qiwi_account"
                                                               name="setting_qiwi_account"
                                                               value="{{ config('options.qiwi_account', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">PagSeguro</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="pagseguro_email">{{ __('EMAIL') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="pagseguro_email"
                                                               name="setting_pagseguro_email"
                                                               value="{{ config('options.pagseguro_email', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="pagseguro_token">{{ __('TOKEN') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="pagseguro_token"
                                                               name="setting_pagseguro_token"
                                                               value="{{ config('options.pagseguro_token', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Pix</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="pix_client_id">{{ __('CLIENT ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="pix_client_id"
                                                               name="setting_pix_client_id"
                                                               value="{{ config('options.pix_client_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="pix_secret_key">{{ __('SECRET KEY') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="pix_secret_key"
                                                               name="setting_pix_secret_key"
                                                               value="{{ config('options.pix_secret_key', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Paymentwall</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="paymentwall_public_key">{{ __('PUBLIC KEY') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="paymentwall_public_key"
                                                               name="setting_paymentwall_public_key"
                                                               value="{{ config('options.paymentwall_public_key', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="paymentwall_private_key">{{ __('PRIVATE KEY') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="paymentwall_private_key"
                                                               name="setting_paymentwall_private_key"
                                                               value="{{ config('options.paymentwall_private_key', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Interkassa.com</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="interkassa_id">{{ __('Merchant ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="interkassa_id"
                                                               name="setting_interkassa_id"
                                                               value="{{ config('options.interkassa_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="interkassa_key">{{ __('API Key') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="interkassa_key"
                                                               name="setting_interkassa_key"
                                                               value="{{ config('options.interkassa_key', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Oplata.to</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="oplata_merchant_id">{{ __('Merchant ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="oplata_merchant_id"
                                                               name="setting_oplata_merchant_id"
                                                               value="{{ config('options.oplata_merchant_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="oplata_secret_word">{{ __('Secret Word') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="oplata_secret_word"
                                                               name="setting_oplata_secret_word"
                                                               value="{{ config('options.oplata_secret_word', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="oplata_secret_word_2">{{ __('Secret Word') }} 2</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="oplata_secret_word_2"
                                                               name="setting_oplata_secret_word_2"
                                                               value="{{ config('options.oplata_secret_word_2', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            </div>


                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Coinpayments</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="coinpayments_merchant_id">{{ __('Merchant ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="coinpayments_merchant_id"
                                                               name="setting_coinpayments_merchant_id"
                                                               value="{{ config('options.coinpayments_merchant_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="coinpayments_secret_ipn">{{ __('IPN Secret') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="coinpayments_secret_ipn"
                                                               name="setting_coinpayments_secret_ipn"
                                                               value="{{ config('options.coinpayments_secret_ipn', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Fondy</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="fondy_merchant_id">{{ __('Merchant ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="fondy_merchant_id"
                                                               name="setting_fondy_merchant_id"
                                                               value="{{ config('options.fondy_merchant_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="fondy_api_key">{{ __('API Key') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="fondy_api_key"
                                                               name="setting_fondy_api_key"
                                                               value="{{ config('options.fondy_api_key', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Paypalych</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="paypalych_shop_id">{{ __('Shop ID') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="paypalych_shop_id"
                                                               name="setting_paypalych_shop_id"
                                                               value="{{ config('options.paypalych_shop_id', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="paypalych_token">{{ __('API TOKEN') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="paypalych_token"
                                                               name="setting_paypalych_token"
                                                               value="{{ config('options.paypalych_token', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Skinify.io</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="skinify_token">{{ __('API TOKEN') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="skinify_token"
                                                               name="setting_skinify_token"
                                                               value="{{ config('options.skinify_token', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>

                                        <div class="payments-group">
                                            <div class="payments-title py-menu-toggle">Obmenka.ua</div>
                                            <div class="payments-options" style="display: none;">
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="obmenkaua_dpay_client">{{ __('DPAY_CLIENT') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="obmenkaua_dpay_client"
                                                               name="setting_obmenkaua_dpay_client"
                                                               value="{{ config('options.obmenkaua_dpay_client', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                           for="obmenkaua_salt">{{ __('SALT') }}</label>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control" id="obmenkaua_salt"
                                                               name="setting_obmenkaua_salt"
                                                               value="{{ config('options.obmenkaua_salt', "") }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
--}}


                                        <div class="col-12">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-lg btn-primary ml-auto">{{ __('Отправить') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- .nk-block -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.payments-title').on('click', function () {
                if ($(this).parent().hasClass('active')) {
                    $(this).parent().removeClass('active');
                    $(this).parent().find('.payments-options').hide();
                } else {
                    $(this).parent().addClass('active');
                    $(this).parent().find('.payments-options').show();
                }
            });
        });
    </script>
@endpush