<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Donate;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Referral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use Qiwi\Api\BillPayments;
use App\Services\PayPal;
use URL;
use GameServer;

class DonateController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status')->only(['transfer', 'transfer_store']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $server_id = $request->input('server') !==NULL ? $request->input('server') : '0';
        $payment_id = $request->input('payment') !==NULL ? $request->input('payment') : '4';

        $referrals = Referral::where('status', '1')->leftJoin('users', 'referrals.user_id', '=', 'users.id')->get()->sortByDesc('total');
        $referrals = $referrals->chunk(5)->first();

        return view('pages.cabinet.donate', compact('server_id', 'payment_id', 'referrals'));
    }

    public function transfer() {
        $accounts = Account::where('user_id', auth()->id())->pluck('login');
        $characters = GameServer::getCharacters($accounts);
        return view('pages.cabinet.donate.transfer', compact('characters'));
    }

    public function transfer_store(Request $request) {
        $amount = intval($request->input('amount'));
        if ($amount > 0 && $amount <= auth()->user()->balance) {
            $char_id = intval($request->input('char_id'));

            if ($char_id) {

                $character = GameServer::getCharacter($char_id);
                Account::where('login', $character->account_name)->where('user_id', auth()->id())->firstOrFail();

                if (GameServer::transferDonateGameServer($char_id, $character, $amount)) {
                    $this->alert('success', $amount . ' ' . config('options.coin_name', 'CoL') . ' ' . __('успешно отправлены в игру'));
                    auth()->user()->decrement('balance', $amount);
                    return redirect()->route('cabinet');
                }
            }
        }

        $this->alert('danger', __('Не удалось отправить') . ' ' . $amount . ' ' . config('options.coin_name', 'CoL') . ' ' . __('в игру! Попробуйте ещё раз.'));

        return back();
    }

    public function transfer_balance($amount, $user_id) {

	Log::channel('paypal')->info("amount - " . $amount . "user_id - " . $user_id);

	if ($amount > 0 && $user_id) {
                $user = User::find($user_id);

		Log::channel('paypal')->info("Данные аккаунта - " . print_r($user, 1));

                if ($user) {
                    $user->balance += $amount;
                    $user->save();
                }
	}
    }

    private function transfer_item($items, $user_id, $server=1)
    {
        $donat_items_str = $items;
        if (strlen($donat_items_str) > 0 && $user_id) {
            $donat_items = explode(',', $donat_items_str);
            if (!empty($donat_items)) {
                foreach ($donat_items as $donat_item) {
                    $di_tmp = explode('=', $donat_item);
                    $item_id = $di_tmp[0];
                    $item_quantity = abs($di_tmp[1]);

                    //Проверяю, если товар уже есть, то добавляем к нему количество
                    $warehouse = Warehouse::where('type', $item_id)->where('user_id', auth()->id())->where('server', $server)->firstOrFail();

                    if ($warehouse) {
                        $warehouse->amount += (int)$item_quantity;
                        $warehouse->save();
                    } else {

                        //Заносим товары на склад
                        $warehouse = new Warehouse;
                        $warehouse->type = $item_id;
                        $warehouse->user_id = $user_id;
                        $warehouse->amount = $item_quantity;
                        $warehouse->enchant = 0;
                        $warehouse->intensive_item_type = 0;
                        $warehouse->variation_opt2 = 0;
                        $warehouse->variation_opt1 = 0;
                        $warehouse->wished = 0;
                        $warehouse->ident = 0;
                        $warehouse->bless = 0;
                        $warehouse->server = $server;
                        $warehouse->save();
                    }
                }
            }
        }
    }


    public function create(Request $request)
    {
	session()->put('donate_prev_url', $request->path());

        return $this->setPayment($request);

    }


    /* PaymentsMethodTrait */
    //В трейте Методы оплаты с вызовом редиректа на оплату setPayment();
    // Везовы колбеков в \App\Http\Controllers\Api\PaymentsController
    //Редиректы после оплаты в \App\Http\Controllers\PaymentsController

    use \App\Traits\PaymentsMethodTrait;





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
