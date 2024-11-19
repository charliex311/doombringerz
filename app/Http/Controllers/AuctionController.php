<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lots = Auction::where('status', 0)->where('end_at', '>', now())->where('server', session('server_id'))->with(['augmentation0', 'augmentation1', 'augmentation2']);

        if (request()->has('class')) {
            $lots->join('lineage_items', 'lineage_items.id', '=', 'auctions.type');
            $lots->select('auctions.*', 'lineage_items.class');
            $lots->where('class', request()->query('class'));
        }

        $lots = $lots->latest('end_at')->paginate();
        $lots->append('icon');
        $lots->append('name');
        return view('pages.cabinet.auction.index', compact('lots'));
    }

    public function bet(Request $request, Auction $auction)
    {
        if ($auction->user_id === auth()->id()) {
            abort(404);
        }

        $amount = intval($request->input('amount'));

        if (now() < $auction->end_at) {
            if ($amount > 0
                && $amount < $auction->buyout_price
                && $amount > $auction->current_bet
                && $amount > $auction->start_price && $auction->status === 0) {

                if (auth()->user()->balance < $amount) {
                    $this->alert('danger', __('Недостаточно ') . config('options.coin_name', 'CoL') . __(' для ставки'));
                } else {
                    auth()->user()->decrement('balance', $amount);
                    if ($auction->latest_id) {
                        User::find($auction->latest_id)->increment('balance', $auction->current_bet);
                    }

                    $auction->current_bet = $amount;
                    $auction->count += 1;
                    $auction->latest_id = auth()->id();
                    $auction->save();

                    $this->alert('success', __('Ваша ставка принята!'));
                }

            } else {
                $this->alert('danger', __('Ваша ставка отклонена! Попробуйте ещё раз.'));
            }
        } else {
            $this->alert('danger', __('Ваша ставка отклонена! Аукцион завершился.'));
        }

        return back();
    }

    public function buyout(Auction $auction)
    {
        if ($auction->user_id === auth()->id()) {
            abort(404);
        }

        if ($auction->status === 0 && now() < $auction->end_at) {
            if (auth()->user()->balance < $auction->buyout_price) {
                $this->alert('danger', __('Недостаточно ') . config('options.coin_name', 'CoL') . __(' для покупки'));
            } else {
                if ($auction->latest_id) {
                    User::find($auction->latest_id)->increment('balance', $auction->current_bet);
                }

                auth()->user()->decrement('balance', $auction->buyout_price);
                $sum = $auction->buyout_price - $this->percent($auction->buyout_price, config('options.auction_percent', 15));
                User::find($auction->user_id)->increment('balance', $sum);

                $auction->current_bet = $auction->buyout_price;
                $auction->status = 1;
                $auction->count += 1;
                $auction->latest_id = auth()->id();
                $auction->end_at = now();
                $auction->save();

                $warehouse = new Warehouse;
                $warehouse->user_id = auth()->id();
                $warehouse->type = $auction->type;
                $warehouse->amount = $auction->amount;
                $warehouse->enchant = $auction->enchant;
                $warehouse->bless = $auction->bless;
                $warehouse->eroded = $auction->eroded;
                $warehouse->ident = $auction->ident;
                $warehouse->wished = $auction->wished;
                $warehouse->variation_opt1 = $auction->variation_opt1;
                $warehouse->variation_opt2 = $auction->variation_opt2;
                $warehouse->intensive_item_type = $auction->intensive_item_type;
                $warehouse->server = session('server_id');
                $warehouse->save();

                $this->alert('success', __('Вы успешно выкупили аукцион, предмет отправлен к Вам на склад'));
            }
        } else {
            $this->alert('danger', __('Ваша ставка отклонена! Аукцион завершился.'));
        }

        return back();
    }

    public function cancel(Auction $auction)
    {
        if ($auction->user_id !== auth()->id()) {
            abort(404);
        } else if ($auction->status === 0 && now() < $auction->end_at) {
            if ($auction->latest_id) {
                User::find($auction->latest_id)->increment('balance', $auction->current_bet);
            }

            $auction->current_bet = $auction->buyout_price;
            $auction->status = 2;
            $auction->latest_id = null;
            $auction->end_at = now();
            $auction->save();

            $exist_item = Warehouse::where('type', $auction->type)
                ->where('enchant', $auction->enchant)
                ->where('bless', $auction->bless)
                ->where('eroded', $auction->eroded)
                ->where('ident', $auction->ident)
                ->where('wished', $auction->wished)
                ->where('variation_opt1', $auction->variation_opt1)
                ->where('variation_opt2', $auction->variation_opt2)
                ->where('intensive_item_type', $auction->intensive_item_type)
                ->where('user_id', auth()->id())
                ->where('server', session('server_id'))
                ->first();

            if ($exist_item) {
                $exist_item->increment('amount', $auction->amount);
            } else {
                $warehouse = new Warehouse;
                $warehouse->user_id = auth()->id();
                $warehouse->type = $auction->type;
                $warehouse->amount = $auction->amount;
                $warehouse->enchant = $auction->enchant;
                $warehouse->bless = $auction->bless;
                $warehouse->eroded = $auction->eroded;
                $warehouse->ident = $auction->ident;
                $warehouse->wished = $auction->wished;
                $warehouse->variation_opt1 = $auction->variation_opt1;
                $warehouse->variation_opt2 = $auction->variation_opt2;
                $warehouse->intensive_item_type = $auction->intensive_item_type;
                $warehouse->server = session('server_id');
                $warehouse->save();
            }

            $this->alert('success', __('Вы успешно отменили аукцион, предмет возвращен к Вам на склад'));
        } else {
            $this->alert('danger', __('Этот аукцион уже нельзя отменить'));
        }
        return back();
    }

    protected function percent($number, $percent)
    {
        return $number / 100 * $percent;

    }
}
