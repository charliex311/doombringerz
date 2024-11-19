<?php

namespace App\Traits;


use App\Http\Requests\DonationRequest;
use App\Lib\GameServer;
use App\Models\Account;
use App\Models\Characters;
use App\Models\Donate;
use App\Models\User;
use App\Models\UserDelivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use GuzzleHttp\Client;
use Paymentwall\Paymentwall_Config;
use Paymentwall\Paymentwall_Widget;
use Paymentwall\Paymentwall_Product;
use Paymentwall\Paymentwall_Pingback;
use App\Services\PayPal;
use App\Services\Qrcode;
use App\Services\PixCode;
use MongoDB\Driver\Query;
use URL;
use Session;

trait PaymentsMethodTrait {

    public function setPayment($request)
    {

        $server = intval($request->input('server'));
        $currency = 'EUR';
        $coins_val = abs(intval($request->input('sum')));
        $price = $coins_val * config('options.server_0_coin_price', 1);
        $price_eur = $price;

        $char_name = ($request->input('char_name') !== NULL) ? $request->input('char_name') : '';
        $user_id = (auth()->id() !== NULL) ? auth()->id() : '0';
        $bonus_item_id = $request->input('bonus_item_id');
        $ref_code = ($request->has('ref_code')) ? $request->input('ref_code') : '';

        $bonus = 0;
        for ($i = 0; $i < 1000; $i++) {
            if (config('options.server_' . $server . '_donat_active', '0') != '0' && config('options.server_' . $server . '_donat_payments' . $request->input('payment'), '') != '' && config('options.server_' . $server . '_donat_date_start', '0') < date('Y-m-d H:i:s') && config('options.server_' . $server . '_donat_date_end', '0') > date('Y-m-d H:i:s')) {
                if (config('options.server_' . $server . '_coin_donat_' . $i . '_amount', '') != '') {
                    if ($coins_val >= config('options.server_' . $server . '_coin_donat_' . $i . '_start', 1) && $coins_val <= config('options.server_' . $server . '_coin_donat_' . $i . '_end', 1)) {
                        $bonus += config('options.server_' . $server .'_coin_donat_' . $i . '_amount', 1);
                    }
                }
            }
        }

        $coins = $coins_val + $bonus;

        switch ($request->input('payment')) {

            case 4: {
                //PayPal
                $paypal = new PayPal();

                $donate = Donate::create([
                    'payment_system' => 'paypal',
                    'user_id' => $user_id,
                    'amount' => $price_eur,
                    'char_name' => $char_name,
                    'server' => session('server_id', '1'),
                    'coins' => $coins,
                    'bonus_item_id' => $bonus_item_id
                ]);

                $redirect_url = $paypal->payWithpaypal($price, $donate);
                if ($redirect_url) {
                    return Redirect::to($redirect_url);
                }

                return back();
            }

            case 19: {
                //Stripe
                require base_path() . '/vendor/stripe/stripe-php/init.php';

                $publishable_key = config('options.stripe_publishable_key', "");
                $secret_key = config('options.stripe_secret_key', "");

                $donate = Donate::create([
                    'payment_system' => 'stripe',
                    'user_id' => $user_id,
                    'amount' => $price_eur,
                    'char_name' => $char_name,
                    'server' => session('server_id', '1'),
                    'coins' => $coins,
                    'bonus_item_id' => $bonus_item_id
                ]);

                $data = [
                    'currency'   => $currency,
                    'coins'      => $coins,
                    'price'      => $price,
                    'user_id'    => $user_id,
                    'app_name'   => config('app.name'),
                    'donate_id'  => $donate->id,
                    'host'       => request()->server("SERVER_NAME"),
                ];

                $queryUrl = config('donate.payment_gateway', '') . 'stripe/pay';
                $ch = curl_init();
                curl_setopt_array($ch, array(CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POST => 1, CURLOPT_HEADER => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $queryUrl, CURLOPT_POSTFIELDS => http_build_query($data)));
                $server_output = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($server_output, TRUE);

                if (!isset($result['status']) || $result['status'] != 'success' || !isset($result['result'])) {
                    $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                    return back();
                }

                \Stripe\Stripe::setApiKey($secret_key);

                header('Content-Type: application/json');

                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items'  => [
                        [
                            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                            'price_data' => [
                                "currency"            => $currency,
                                'product_data' => [
                                    "name"            => 'Donation for the project ' . config('app.name'),
                                ],
                                //"unit_amount"         => $price_usd,
                                "unit_amount_decimal" => strval($price*100),
                                "tax_behavior"        => "unspecified",
                            ],
                            'quantity'   => 1,
                        ],
                    ],
                    'mode'         => 'payment',
                    "metadata"     => ["order_id" => $donate->id],
                    'payment_intent_data' => [
                        "metadata" => ["order_id" => $donate->id],
                    ],
                    'success_url'  => config('app.url') . '/stripe/success',
                    'cancel_url'   => config('app.url') . '/stripe/fail',
                ]);

                return Redirect::to($checkout_session->url);

            }

            case 46: {
                //Skrill
                require base_path() . '/vendor/stripe/stripe-php/init.php';

                $publishable_key = config('options.stripe_publishable_key', "");
                $secret_key = config('options.stripe_secret_key', "");

                $donate = Donate::create([
                    'payment_system' => 'stripe',
                    'user_id' => $user_id,
                    'amount' => $price_eur,
                    'char_name' => $char_name,
                    'server' => session('server_id', '1'),
                    'coins' => $coins,
                    'bonus_item_id' => $bonus_item_id
                ]);

                $data = [
                    'currency'   => $currency,
                    'coins'      => $coins,
                    'price'      => $price,
                    'user_id'    => $user_id,
                    'app_name'   => config('app.name'),
                    'donate_id'  => $donate->id,
                    'host'       => request()->server("SERVER_NAME"),
                ];

                $queryUrl = config('donate.payment_gateway', '') . 'stripe/pay';
                $ch = curl_init();
                curl_setopt_array($ch, array(CURLOPT_SSL_VERIFYPEER => 0, CURLOPT_POST => 1, CURLOPT_HEADER => 0, CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $queryUrl, CURLOPT_POSTFIELDS => http_build_query($data)));
                $server_output = curl_exec($ch);
                curl_close($ch);
                $result = json_decode($server_output, TRUE);

                if (!isset($result['status']) || $result['status'] != 'success' || !isset($result['result'])) {
                    $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                    return back();
                }

                \Stripe\Stripe::setApiKey($secret_key);

                header('Content-Type: application/json');

                $checkout_session = \Stripe\Checkout\Session::create([
                    'line_items'  => [
                        [
                            # Provide the exact Price ID (e.g. pr_1234) of the product you want to sell
                            'price_data' => [
                                "currency"            => $currency,
                                'product_data' => [
                                    "name"            => 'Donation for the project ' . config('app.name'),
                                ],
                                //"unit_amount"         => $price_usd,
                                "unit_amount_decimal" => strval($price*100),
                                "tax_behavior"        => "unspecified",
                            ],
                            'quantity'   => 1,
                        ],
                    ],
                    'mode'         => 'payment',
                    "metadata"     => ["order_id" => $donate->id],
                    'payment_intent_data' => [
                        "metadata" => ["order_id" => $donate->id],
                    ],
                    'success_url'  => config('app.url') . '/stripe/success',
                    'cancel_url'   => config('app.url') . '/stripe/fail',
                ]);

                return Redirect::to($checkout_session->url);

            }

            case 99:
            {
                //Payment Test
                auth()->user()->balance += $coins;
                auth()->user()->save();

                $this->alert('success', "Оплата прошла успешно!");
                return back();
            }
        }
    }

}
