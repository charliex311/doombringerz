<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Auction;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use GameServer;

class WarehouseController extends Controller
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
        $items = Warehouse::where('user_id', auth()->id())->where('amount', '>', 0)->where('server', session('server_id'))->get();

        return view('pages.cabinet.warehouse.index', compact('items'));
    }

    public function transfer(Warehouse $warehouse) {
        if ($warehouse->user_id != auth()->id()) {
            abort(404);
        }
        $accounts = Account::where('user_id', auth()->id())->pluck('login');
        $characters = GameServer::getCharacters($accounts);
        return view('pages.cabinet.warehouse.transfer', compact('warehouse', 'characters'));
    }

    public function transfer_store(Request $request, Warehouse $warehouse) {
        if ($warehouse->user_id != auth()->id()) {
            abort(404);
        }

        $amount = abs(intval($request->input('amount')));
        if ($amount > 0 && $amount <= $warehouse->amount) {
            $char_id = intval($request->input('char_id'));

            if ($char_id) {

                $character = GameServer::getCharacter($char_id);
                Account::where('login', $character->account_name)->where('user_id', auth()->id())->firstOrFail();

                if (GameServer::transferItemGameServer($char_id, $character, $amount, $warehouse)) {
                    $this->alert('success', __('Предмет') . " " . $warehouse->name . " " . __('успешно отправлен в игру'));

                    if ($warehouse->amount - $amount > 0) {
                        $warehouse->amount -= $amount;
                        $warehouse->save();
                    } else {
                        $warehouse->delete();
                    }
                    return redirect()->route('warehouse.index');
                }
            }
        }

        $this->alert('danger', __('Не удалось отправить') . " " . $warehouse->name . " " . __('в игру! Попробуйте ещё раз.'));

        return redirect()->route('warehouse.index');
    }

    public function auction(Warehouse $warehouse) {

        if ($warehouse->user_id != auth()->id()) {
            abort(404);
        }

        return view('pages.cabinet.warehouse.auction', compact('warehouse'));
    }

    public function auction_store(Request $request, Warehouse $warehouse) {
        if ($warehouse->user_id != auth()->id()) {
            abort(404);
        }
        $amount = intval($request->input('amount'));
        $start_price = intval($request->input('start_price'));
        $buyout_price = intval($request->input('buyout_price'));

        if ($amount > 0 && $amount <= $warehouse->amount) {

            if ($start_price > 0 && $buyout_price > 0) {

                if ($start_price < $buyout_price) {

                    $auction = new Auction;
                    $auction->start_price = $start_price;
                    $auction->buyout_price = $buyout_price;
                    $auction->current_bet = $start_price;
                    $auction->type = $warehouse->type;
                    $auction->amount = $amount;
                    $auction->enchant = $warehouse->enchant;
                    $auction->bless = $warehouse->bless;
                    $auction->eroded = $warehouse->eroded;
                    $auction->ident = $warehouse->ident;
                    $auction->wished = $warehouse->wished;
                    $auction->variation_opt1 = $warehouse->variation_opt1;
                    $auction->variation_opt2 = $warehouse->variation_opt2;
                    $auction->intensive_item_type = $warehouse->intensive_item_type;
                    $auction->user_id = auth()->id();
                    $auction->server = session('server_id');
                    $auction->end_at = now()->addHours(config('options.auction_hours', 12));
                    $auction->save();

                    $warehouse->amount -= $amount;
                    if ($warehouse->amount < 0) {
                        $warehouse->delete();
                    } else {
                        $warehouse->save();
                    }

                    $this->alert('success', __('Вы отправили предмет на аукцион. Через') . " ". config('options.auction_hours', 'CoL') . " " . __('часов, в случае если его никто не выкупит, он вернётся на склад.'));

                    return redirect()->route('auction.index');
                } else {
                    $this->alert('danger', __('Стартовая цена не может быть больше блиц цены'));
                }

            } else {
                $this->alert('danger', __('Стартовая и блиц цены обязательны к указанию'));
            }

        } else {
            $this->alert('danger', __('Не удалось отправить') . " " . $warehouse->name . " " . __('на аукцион! Некорректно указано количество'));
        }

        return redirect()->route('warehouse.index');
    }
}
