<?php

namespace App\Http\Controllers;

use App\Http\Requests\DonationRequest;
use App\Models\Account;
use App\Models\Donate;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use App\Services\PayPal;
use URL;
use GameServer;

class DonationController extends Controller
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
        $server_id = $request->input('server') !==NULL ? $request->input('server') : '1';
        $payment_id = $request->input('payment') !==NULL ? $request->input('payment') : '2';

        return view('pages.main.donation', compact('server_id', 'payment_id'));
    }

    public function transfer() {
        $accounts = Account::where('user_id', auth()->id())->pluck('login');
        $characters = GameServer::getCharacters($accounts);
        return view('pages.main.donation.transfer', compact('characters'));
    }

    public function transfer_store($amount, $char_name) {

        if ($amount > 0 && $char_name) {

            $character = GameServer::getCharacterByName($char_name);

	    Log::channel('paypal')->info("Данные персонажа - " . print_r($character, 1));

            if (GameServer::transferDonateGameServer($character->char_id, $character, $amount)) {
                $this->alert('success', $amount . ' ' . config('options.coin_name', 'CoL') . ' ' . __('для') . ' ' . $char_name . ' ' . __('успешно отправлены в игру'));
                return redirect()->route('donation');
            }
        }

        $this->alert('danger', __('Не удалось отправить') . ' ' . $amount . ' ' . config('options.coin_name', 'CoL') . ' ' . __('в игру! Попробуйте ещё раз.'));

        return back();
    }

    public function transfer_item_store($item_id, $char_name) {

        if ($item_id > 0 && $char_name) {

            $character = GameServer::getCharacterByName($char_name);
	    $amount = 1;
	    $warehouse = new Warehouse;
        	$warehouse->type = $item_id;
		$warehouse->name = 'Item 1';
        	$warehouse->user_id = 0;
        	$warehouse->amount = 1;
        	$warehouse->enchant = 0;
        	$warehouse->intensive_item_type = 0;
        	$warehouse->variation_opt2 = 0;
        	$warehouse->variation_opt1 = 0;
        	$warehouse->wished = 0;
        	$warehouse->ident = 0;
        	$warehouse->bless = 0;
        	$warehouse->server = 1;

                if (GameServer::transferItemGameServer($character->obj_Id, $character, $amount, $warehouse)) {
                    $this->alert('success', __('Предмет') . " " . $warehouse->name . " " . __('успешно отправлен в игру'));
                    return redirect()->route('donation');
                }
            
        }

        $this->alert('danger', __('Не удалось отправить') . " " . __('предмет') . " " . __('в игру! Попробуйте ещё раз.'));

        return back();
    }



    public function create(DonationRequest $request)
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
