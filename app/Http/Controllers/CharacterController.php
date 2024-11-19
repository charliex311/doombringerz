<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Recharge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GameServer;

class CharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index($account = null) {
        $accounts = [];

        if ($account) {
            $find = Account::where('login', $account)->firstOrFail();
            if ($find->user_id !== auth()->id()) {
                abort(404);
            }
            array_push($accounts, $account);
        } else {
            $accounts = Account::where('user_id', auth()->id())->latest()->get()->pluck('login');
        }

        $characters = GameServer::getCharacters($accounts);

        return view('pages.cabinet.characters.index', compact('account', 'characters'));
    }

    public function teleport($char_id): RedirectResponse {

        $character = GameServer::getCharacter($char_id);
        Account::where('login', $character->account_name)->where('user_id', auth()->id())->firstOrFail();


        //Проверяем, что с последнего телепорта прошло заданное время
        $recharge = Recharge::where('char_id', $char_id)->where('user_id', auth()->id())->where('type', 'teleport')->where('server', session('server_id'))->first();
        if ($recharge) {

            $down_time = config('options.game_send_character_town_time', "30");
            $date = strtotime(date('Y-m-d H:i:s'));
            $date_recharge = strtotime($recharge->date) + 60 * $down_time;

            if ($date_recharge > $date) {
                $date_diff = $date_recharge - $date;
                $this->alert('danger', 'Ошибка! Повторно можно будет телепортировать через' . ' ' . downcounter($recharge->date, $down_time) . '.');
                return back();
            }
        }

        //Телепортируем персонажа в главный город
        $town_cord = array(
            "x" => "83480",
            "y" => "147912",
            "z" => "-3400",
        );

        if (GameServer::teleportCharacterMainTown($char_id, $town_cord)) {

            //Записываем дату и время телепорта для контроля перезарядки
            $recharge = Recharge::where('char_id', $char_id)->where('user_id', auth()->id())->where('type', 'teleport')->where('server', session('server_id'))->first();
            if (!$recharge) {
                $recharge = new Recharge;
            }
            $recharge->char_id = $char_id;
            $recharge->user_id = auth()->id();
            $recharge->type = 'teleport';
            $recharge->server = session('server_id') ?: '1';
            $recharge->date = date('Y-m-d H:i:s');
            $recharge->save();

            $this->alert('success', __('Персонаж')  . ' ' .  $character->char_name  . ' ' .  __('успешно отправлен в город'));
            return back();
        }

        $this->alert('danger', __('При отправке персонажа') . ' ' . $character->char_name  . ' ' .  __('в город произошла ошибка, попробуйте позже.'));

        return back();
    }

    public function inventory($char_id) {

        $character = GameServer::getCharacter($char_id);
        Account::where('login', $character->account_name)->where('user_id', auth()->id())->firstOrFail();

        $donate_items = [57, 6673, 4037];
        $items = GameServer::getItems($char_id, $donate_items);

        return view('pages.cabinet.characters.inventory', compact('items', 'character'));
    }

    public function transfer($char_id, $item_id) {

        $character = GameServer::getCharacter($char_id);
        Account::where('login', $character->account_name)->where('user_id', auth()->id())->firstOrFail();

        $inventory = GameServer::getItem($char_id, $item_id);

        session()->put('max_transfer_amount', $inventory->amount);

        return view('pages.cabinet.characters.transfer', compact('inventory', 'char_id', 'item_id'));
    }

    public function transfer_store(Request $request, $char_id, $item_id) {

        $character = GameServer::getCharacter($char_id);
        Account::where('login', $character->account_name)->where('user_id', auth()->id())->firstOrFail();

        $inventory = GameServer::getItem($char_id, $item_id);

        $max_transfer_amount = intval($request->session()->get('max_transfer_amount'));
        $amount = intval($request->input('amount'));

        if ($amount > $max_transfer_amount || $amount > $inventory->amount) {
            $this->alert('danger', __('Вы не можете перенести данное количество') . ' ' . $inventory->name . ' ' . __('на склад') . '.');
            return back();
        }

        if ($amount > 0) {

            if (GameServer::transferItemWarehouse($char_id, $item_id, $amount, $inventory)) {
                $this->alert('success', __('Вы успешно перенесли') . ' ' . $amount . ' ' . __('шт.') . ' ' . $inventory->name . ' ' . __('на склад') . '.');
                return redirect()->route('warehouse.index');
            }
        }

        $this->alert('danger', __('Не удалось перенести') . ' ' . $inventory->name . ' ' . __('на склад') . '! ' . __('Попробуйте позже') . '.');
        $request->session()->forget('max_transfer_amount');

        return redirect()->route('characters.inventory', $char_id);
    }
}
