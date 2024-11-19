<?php

namespace App\Http\Controllers;

use App\Http\Controllers\DonateController;
use App\Http\Controllers\DonationController;
use App\Lib\GameServer;
use App\Models\Account;
use App\Models\Characters;
use App\Models\Donate;
use App\Models\User;
use App\Models\UserDelivery;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;
use Qiwi\Api\BillPayments;
use App\Services\PayPal;
use URL;

class PaymentsController extends Controller
{

    public function paypalStatus(Request $request, DonationController $donationController, DonateController $donateController)
    {
        Log::channel('paypal')->info("Данные paypal - " . print_r($request->all(), 1));
        $paypal = new PayPal();
        $payment_id = $paypal->getPaymentStatus($request);

        if ($payment_id) {

            $donate = Donate::where('payment_id', $payment_id)->first();
            Log::channel('paypal')->info("Данные доната - " . print_r($donate, 1));

            session()->put('server_id', $donate->server);

            if ($donate->status === 0) {
                $donate->status = 1;
                $donate->save();

                if ($donate->user_id !== 0) {
                    $donateController->transfer_balance($donate->coins, $donate->user_id);
                    if ($donate->bonus_item_id > 0) {
                        $donateController->transfer_item($donate->bonus_item_id, $donate->user_id);
                    }
                } else {
                    $donationController->transfer_store($donate->coins, $donate->char_name);
                    if ($donate->bonus_item_id > 0) {
                        $donationController->transfer_item_store($donate->bonus_item_id, $donate->char_name);
                    }
                }
            }

            $this->alert('success', __('Баланс успешно пополнен!'));
            $this->activityLog(0, 'successfully top up the balance of Master Account.');

            /** Очищаем ID платежа **/
            session()->forget('paypal_payment_id');

        } else {
            $this->alert('danger', __('Ошибка при пополнении баланса!'));
            $this->activityLog(0, 'has error top up the balance of Master Account.');
        }

        return Redirect::to(session()->get('donate_prev_url'));
    }

    public function stripeStatus(Request $request, string $method)
    {
        if ($method == 'success') {
            $this->alert('success', __('Баланс успешно пополнен!'));
            $this->activityLog(0, 'successfully top up the balance of Master Account.');
            return Redirect::to(session()->get('donate_prev_url'));
        }

        $this->alert('danger', __('Ошибка при пополнении баланса!'));
        $this->activityLog(0, 'has error top up the balance of Master Account.');
        return Redirect::to(session()->get('donate_prev_url'));
    }

    public function skrillStatus(Request $request, string $method)
    {
        if ($method == 'success') {
            $this->alert('success', __('Баланс успешно пополнен!'));
            $this->activityLog(0, 'successfully top up the balance of Master Account.');
            return Redirect::to(session()->get('donate_prev_url'));
        }

        $this->alert('danger', __('Ошибка при пополнении баланса!'));
        $this->activityLog(0, 'has error top up the balance of Master Account.');
        return Redirect::to(session()->get('donate_prev_url'));
    }



    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        return Validator::make($data, [
            'amount' => ['required', 'integer', 'min:1', 'max:10000'],
        ]);
    }

    protected function sign($out_amount, $order_id, $merchant_id = 13251, $secret = '')
    {
        return md5($merchant_id.':'.$out_amount.':'.$secret.':'.$order_id);
    }

    protected function error($message)
    {
        return response($message)->header('Content-Type', 'text/plain');
    }

    protected function success()
    {
        return response('YES')->header('Content-Type', 'text/plain');
    }


}
