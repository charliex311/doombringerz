<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\MarketItem;
use App\Models\MarketSold;
use App\Models\MarketCategory;
use App\Models\MarketSeller;
use App\Models\Warehouse;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use GameServer;

class MarketController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index() {

        $cat_title = __('Последние товары');
        $accounts = Account::where('user_id', auth()->id())->where('server', session('server_id'))->pluck('login');
        $characters = GameServer::getCharacters($accounts);

        $marketcategories = MarketCategory::latest()->get()->sortBy('sort');
        $marketitems = MarketItem::where('server', session('server_id'))->orderBy('id', 'desc')->limit(10)->get();

        $seller = self::getSeller(auth()->id());
        $statistic = self::getStatistics();

        $accounts = Account::where('user_id', auth()->id())->where('server', session('server_id'))->latest()->get();
        session()->put('prefix', strtoupper(random_str(3)));

        $characters_count = count($characters);
        $warehouse_count = Warehouse::where('user_id', auth()->id())->count();

        return view('pages.cabinet.market.index', compact('accounts', 'characters_count', 'warehouse_count', 'characters', 'marketitems', 'marketcategories', 'cat_title', 'seller', 'statistic'));
    }

    public function history()
    {

        $marketsolds = MarketSold::where('seller_id', auth()->id())->latest()->paginate(10);

        $seller = self::getSeller(auth()->id());
        $statistic = self::getStatistics();
        session()->put('prefix', strtoupper(random_str(3)));

        return view('pages.cabinet.market.history', compact('marketsolds', 'seller', 'statistic'));
    }

    public function category(MarketCategory $marketcategory) {

        $title = 'title_'.app()->getLocale();
        $cat_title = $marketcategory->$title;
        $accounts = Account::where('user_id', auth()->id())->where('server', session('server_id'))->pluck('login');
        $characters = GameServer::getCharacters($accounts);

        $marketcategories = MarketCategory::latest()->get()->sortBy('sort');
        $marketitems = MarketItem::query()->where('category_id', $marketcategory->id)->where('server', session('server_id'));
        $search = request()->query('search');
        if ($search) {
            $marketitems->leftJoin('lineage_items', 'market_items.type', '=', 'lineage_items.id')->where('name', 'LIKE', "%{$search}%");
        }
        $marketitems = $marketitems->latest('market_items.created_at')->paginate(10);

        $seller = self::getSeller(auth()->id());
        $statistic = self::getStatistics();

        $accounts = Account::where('user_id', auth()->id())->where('server', session('server_id'))->latest()->get();
        session()->put('prefix', strtoupper(random_str(3)));

        $characters_count = count($characters);
        $warehouse_count = Warehouse::where('user_id', auth()->id())->count();

        return view('pages.cabinet.market.category', compact('accounts', 'characters_count', 'warehouse_count', 'characters', 'marketitems', 'marketcategories', 'cat_title', 'seller', 'statistic'));

    }

    public function mylots(MarketCategory $marketcategory) {

        $cat_title = __('Мои товары');
        $accounts = Account::where('user_id', auth()->id())->where('server', session('server_id'))->pluck('login');
        $characters = GameServer::getCharacters($accounts);

        $marketcategories = MarketCategory::latest()->get()->sortBy('sort');
        $marketitems = MarketItem::query()->where('user_id', auth()->id())->where('server', session('server_id'));
        $search = request()->query('search');
        if ($search) {
            $marketitems->leftJoin('lineage_items', 'market_items.type', '=', 'lineage_items.id')->where('name', 'LIKE', "%{$search}%");
        }
        $marketitems = $marketitems->latest('market_items.created_at')->paginate(10);

        $seller = self::getSeller(auth()->id());
        $statistic = self::getStatistics();

        $accounts = Account::where('user_id', auth()->id())->where('server', session('server_id'))->latest()->get();
        session()->put('prefix', strtoupper(random_str(3)));

        $characters_count = count($characters);
        $warehouse_count = Warehouse::where('user_id', auth()->id())->count();

        return view('pages.cabinet.market.category', compact('accounts', 'characters_count', 'warehouse_count', 'characters', 'marketitems', 'marketcategories', 'cat_title', 'seller', 'statistic'));

    }

    public function show(MarketItem $marketitem) {

        $user = User::find($marketitem->user_id);
        $seller = self::getSeller($marketitem->user_id);

        return view('pages.cabinet.market.full', compact('marketitem','user', 'seller'));
    }

    public function buyout(Request $request)
    {

        if (!$request->has('marketitem_id') || !$request->has('quantity')) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже!'));
            return back();
        }

        $marketitem = MarketItem::find($request->input('marketitem_id'));
        if ($marketitem->sale_type == 1) {
            $quantity = abs(intval($marketitem->amount));
        } else {
            $quantity = abs(intval($request->input('quantity')));
        }

        if (!$marketitem || $marketitem->user_id == auth()->id() || $quantity <= 0) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже!'));
            return back();
        }

        if ($quantity > $marketitem->amount) {
            $this->alert('danger', __('Произошла ошибка! Некорректно указано количество.'));
            return back();
        }

            $amount = abs($marketitem->price) * $quantity;

            if ($amount > 0 && $amount < auth()->user()->balance) {
                    //Add the item to the buyer's warehouse. I check if the product is already there, then add the quantity to it
                    $warehouse = Warehouse::where('type', $marketitem->type)->where('user_id', auth()->id())->where('server', session('server_id'))->first();
                    if ($warehouse) {
                        $warehouse->amount += $quantity;
                    } else {

                        //Whrite items to the warehouse buyer
                        $warehouse = new Warehouse;
                        $warehouse->type = $marketitem->type;
                        $warehouse->user_id = auth()->id();
                        $warehouse->amount = $quantity;
                        $warehouse->enchant = $marketitem->enchant;
                        $warehouse->intensive_item_type = $marketitem->intensive_item_type;
                        $warehouse->variation_opt2 = $marketitem->variation_opt2;
                        $warehouse->variation_opt1 = $marketitem->variation_opt1;
                        $warehouse->wished = $marketitem->wished;
                        $warehouse->ident = $marketitem->ident;
                        $warehouse->bless = $marketitem->bless;
                        $warehouse->server = session('server_id');
                    }

                    if ($warehouse->save()) {
                        auth()->user()->decrement('balance', $amount);


                        //Whrite data to MarketSold
                        $marketsold = new MarketSold;
                        $marketsold->type = $marketitem->type;
                        $marketsold->category_id = $marketitem->category_id;
                        $marketsold->price = $marketitem->price;
                        $marketsold->count = $marketitem->count;
                        $marketsold->sale_type = $marketitem->sale_type;
                        $marketsold->seller_id = $marketitem->user_id;
                        $marketsold->buyer_id = auth()->id();
                        $marketsold->amount = $quantity;
                        $marketsold->enchant = $marketitem->enchant;
                        $marketsold->intensive_item_type = $marketitem->intensive_item_type;
                        $marketsold->variation_opt2 = $marketitem->variation_opt2;
                        $marketsold->variation_opt1 = $marketitem->variation_opt1;
                        $marketsold->wished = $marketitem->wished;
                        $marketsold->ident = $marketitem->ident;
                        $marketsold->bless = $marketitem->bless;
                        $marketsold->server = $marketitem->server;
                        $marketsold->status = 2;
                        $marketsold->save();

                        //Add level for seller
                        $marketseller = MarketSeller::where('user_id', $marketitem->user_id)->first();
                        $marketseller->trust_lvl++;
                        $marketseller->save();

                        //Removing items from sale
                        $marketitem->amount -= $quantity;
                        if ($marketitem->amount <= 0) {
                            $marketitem->delete();
                        } else {
                            $marketitem->save();
                        }

                        //Add amount on seller's balance
                        $user = User::find($marketitem->user_id);
                        $user->balance += $amount * (100 - config('options.market_seller_commission', '5')) / 100;
                        $user->save();

                        $this->alert('success', __('Предмет успешно куплен! Проверьте свой склад.'));
                        return Redirect::to(route('market.index'));
                    }

            } else {
                $this->alert('danger', __('Недостаточно') . ' ' . config('options.server_' . session('server_id') . '_coin_name', 'CoL') . ' ' . __('на балансе мастер-аккаунта'));

            }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }

    public function sell(Request $request)
    {

        $marketitems = MarketItem::latest()->paginate();

        $marketcategories = MarketCategory::latest()->get()->sortBy('sort');

        $items = Warehouse::where('user_id', auth()->id())->where('amount', '>', 0)->where('server', session('server_id'))->get();

        return view('pages.cabinet.market.sell', compact('items', 'marketitems', 'marketcategories'));
    }

    public function sellout(Request $request) {

        $category_id = intval($request->input('category_id'));
        $sale_type = intval($request->input('sale_type'));
        $item_type = intval($request->input('item'));
        $amount = abs(intval($request->input('amount')));
        $price = abs(intval($request->input('price')));

        $item = Warehouse::where('user_id', auth()->id())->where('type', $item_type)->where('amount', '>', 0)->where('server', session('server_id'))->first();

        $seller = MarketSeller::where('user_id', auth()->id())->first();
        if (!$seller) {
            $seller = new MarketSeller;
            $seller->user_id = auth()->id();
            $seller->trust_lvl = 0;
            $seller->history = json_encode(array());
            $seller->save();
        }

        if ($item && $amount > 0 && $amount <= $item->amount) {
            if ($price > 0) {

                $marketitem = new MarketItem;
                $marketitem->price = $price;
                $marketitem->amount = $amount;
                $marketitem->type = $item_type;
                $marketitem->sale_type = $sale_type;
                $marketitem->category_id = $category_id;
                $marketitem->enchant = $item->enchant;
                $marketitem->bless = $item->bless;
                $marketitem->eroded = $item->eroded;
                $marketitem->ident = $item->ident;
                $marketitem->variation_opt1 = $item->variation_opt1;
                $marketitem->variation_opt2 = $item->variation_opt2;
                $marketitem->intensive_item_type = $item->intensive_item_type;
                $marketitem->user_id = auth()->id();
                $marketitem->server = session('server_id');
                $marketitem->status = 1;
                $marketitem->save();

                $item->amount -= $amount;
                if ($item->amount <= 0) {
                    $item->delete();
                } else {
                    $item->save();
                }

                $this->alert('success', __('Вы отправили предмет на продажу.'));
                return redirect()->route('market.index');

            } else {
                $this->alert('danger', __('Не удалось отправить') . " " . $item->name . " " . __('на продажу! Некорректно указана цена'));
            }
        } else {
            $this->alert('danger', __('Не удалось отправить') . " " . $item->name . " " . __('на продажу! Некорректно указано количество'));
        }

        return redirect()->route('market.index');

    }

    public function cancel(MarketItem $marketitem)
    {

        if ($marketitem->user_id != auth()->id()) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже!'));
            return back();
        } elseif ($marketitem->status == 1) {

            $item = Warehouse::where('user_id', auth()->id())->where('type', $marketitem->type)->where('server', session('server_id'))->first();

            if ($item) {
                $item->increment('amount', $marketitem->amount);
            } else {
                $warehouse = new Warehouse;
                $warehouse->user_id = auth()->id();
                $warehouse->type = $marketitem->type;
                $warehouse->amount = $marketitem->amount;
                $warehouse->enchant = $marketitem->enchant;
                $warehouse->bless = $marketitem->bless;
                $warehouse->eroded = $marketitem->eroded;
                $warehouse->ident = $marketitem->ident;
                $warehouse->wished = $marketitem->wished;
                $warehouse->variation_opt1 = $marketitem->variation_opt1;
                $warehouse->variation_opt2 = $marketitem->variation_opt2;
                $warehouse->intensive_item_type = $marketitem->intensive_item_type;
                $warehouse->server = session('server_id');
                $warehouse->save();
            }

            $marketitem->delete();

            $this->alert('success', __('Вы успешно отменили лот, предмет возвращен к Вам на склад'));
        } else {
            $this->alert('danger', __('Этот лот уже нельзя отменить'));
        }
        return Redirect::to(route('market.index'));
    }

    private function getStatistics()
    {
        $total_sales_today = MarketSold::where('status', '2')->where('server', session('server_id'))->whereDate('created_at', now()->format('Y-m-d'))->count();
        $total_new_today = MarketItem::where('server', session('server_id'))->whereDate('created_at', now()->format('Y-m-d'))->count();
        $total_sales_week = MarketSold::where('status', '2')->where('server', session('server_id'))->whereDate('created_at', '>=', now()->subDays(7)->format('Y-m-d'))->whereDate('created_at', '<=', now()->format('Y-m-d'))->count();
        $total_new_week = MarketItem::where('server', session('server_id'))->whereDate('created_at', '>=', now()->subDays(7)->format('Y-m-d'))->whereDate('created_at', '<=', now()->format('Y-m-d'))->count();
        $total_seller_sales = MarketSold::where('seller_id', auth()->id())->where('server', session('server_id'))->where('status', '2')->count();
        $total_seller_active = MarketItem::where('user_id', auth()->id())->where('server', session('server_id'))->where('status', '1')->count();


        return (object)[
            'total_sales_today' => $total_sales_today,
            'total_sales_week' => $total_sales_week,
            'total_new_today' => $total_new_today,
            'total_new_week' => $total_new_week,
            'total_seller_sales' => $total_seller_sales,
            'total_seller_active' => $total_seller_active,
        ];
    }

    private function getSeller($user_id)
    {
        $seller = MarketSeller::where('user_id', $user_id)->first();
        if (!$seller) {
            $seller = (object)[
                'trust_lvl' => 0,
                'history' => [],
            ];
        }

        return $seller;
    }

}
