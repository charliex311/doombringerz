<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonateController;
use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class PaymentsController extends Controller
{

    public function skinify(Request $request, DonationController $donationController, DonateController $donateController)
    {
        $method = $request->status;
        Log::channel('skinify')->info("Робот: Оплата skinify. Данные платежа - " . print_r($request->all(), 1));

        if (md5(config('options.skinify_token', '')) === $request->token_md5) {

            $donate = Donate::find($request->deposit_id);
            Log::channel('skinify')->info("Данные доната - " . print_r($donate, 1));

            session()->put('server_id', $donate->server);

            if ($method == 'failed') {
                return $this->success();
            }

            if ($method == 'success') {

                if ($donate->status === 0) {
                    $donate->payment_id = $request->get('transaction_id');
                    $donate->status = 1;
                    $donate->amount = $request->amount;
                    $donate->coins = intval($request->amount / config('options.server_' . $donate->server . '_coin_price', 1));
                    $donate->save();

                    //Начисляем коины, итемы и др. после успешной оплаты
                    $this->afterSuccessPay($donate, $request);
                }

                return $this->success();
            }
        }

        return $this->error($method . ' not supported');
    }

    public function skrill(Request $request, DonationController $donationController, DonateController $donateController)
    {
        $method = $request->status;
        Log::channel('skinify')->info("Робот: Оплата skinify. Данные платежа - " . print_r($request->all(), 1));

        if (md5(config('options.skinify_token', '')) === $request->token_md5) {

            $donate = Donate::find($request->deposit_id);
            Log::channel('skinify')->info("Данные доната - " . print_r($donate, 1));

            session()->put('server_id', $donate->server);

            if ($method == 'failed') {
                return $this->success();
            }

            if ($method == 'success') {

                if ($donate->status === 0) {
                    $donate->payment_id = $request->get('transaction_id');
                    $donate->status = 1;
                    $donate->amount = $request->amount;
                    $donate->coins = intval($request->amount / config('options.server_' . $donate->server . '_coin_price', 1));
                    $donate->save();

                    //Начисляем коины, итемы и др. после успешной оплаты
                    $this->afterSuccessPay($donate, $request);
                }

                return $this->success();
            }
        }

        return $this->error($method . ' not supported');
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

    /* PaymentProcessingTrait */
    //В трейте метод начисления монет, итемов и др. после успешной оплаты
    use \App\Traits\PaymentProcessingTrait;
}
