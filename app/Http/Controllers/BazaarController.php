<?php

namespace App\Http\Controllers;

use App\Lib\GameServer;
use App\Models\Account;
use App\Models\Characters;
use App\Models\BazaarItem;
use App\Models\BazaarCategory;
use App\Models\BazaarSold;
use App\Models\BazaarSeller;
use App\Models\BazaarItemsPatch;
use App\Models\User;
use App\Http\Requests\ShopCharacterRequest;
use http\Params;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use SoapClient;

class BazaarController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index(Request $request) {

        if (config('options.shops_status', '0') != '1' && auth()->user()->role != 'admin') {
            return redirect()->route('index');
        }

        DB::statement("SET SQL_MODE=''");
        $bazaaritems = BazaarItem::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $bazaaritems->where('title_', 'LIKE', "%{$search}%");
        }

        $category_id = request()->has('category_id') ? request()->query('category_id') : '0';
        if ($category_id > 0) {
            $bazaaritems->where('category_id', request()->query('category_id'));
        }

        $bazaaritems = $bazaaritems->get();
        $bazaaritems_tmp = [];
        $bazaaritems_tmp_lvl = [];
        foreach ($bazaaritems as $bazaaritem) {
            $bazaaritem_find = FALSE;
            if (!empty($bazaaritems_tmp)) {
                foreach ($bazaaritems_tmp as $bazaaritem_tmp) {
                    if ($bazaaritem_tmp->type == $bazaaritem->type) {
                        $bazaaritem_find = TRUE;
                    }
                }
            }
            if ($bazaaritem_find === FALSE) {
                $bazaaritems_tmp[$bazaaritem->type] = $bazaaritem;
                $bazaaritems_tmp_lvl[$bazaaritem->type] = $bazaaritem->lvl;
            } elseif ($bazaaritem->lvl > $bazaaritems_tmp_lvl[$bazaaritem->type]) {
                $bazaaritems_tmp[$bazaaritem->type] = $bazaaritem;
            }

        }

        $bazaaritems_sold_tmp = BazaarSold::groupBy('type')->get()->pluck('type');
        $bazaaritems_sold_arr = json_decode(json_encode($bazaaritems_sold_tmp), true);
        $bazaaritems_sold = [];
        foreach ($bazaaritems_tmp as $bazaaritem_tmp) {
            if (in_array($bazaaritem_tmp->type, $bazaaritems_sold_arr)) {
                $bazaaritems_sold[] = $bazaaritem_tmp;
            }
        }

        $bazaaritems_popular_tmp = BazaarItem::getPopulars();
        $bazaaritems_popular = [];
        foreach ($bazaaritems_tmp as $bazaaritem_tmp) {
            foreach ($bazaaritems_popular_tmp as $bazaaritem_popular_tmp) {
                if ($bazaaritem_tmp->type == $bazaaritem_popular_tmp->type && $bazaaritem_popular_tmp->type_count > 1) {
                    $bazaaritems_popular[] = $bazaaritem_tmp;
                }
            }
        }

        $bazaaritems = collect($bazaaritems_tmp);
        $bazaaritems_sold = collect($bazaaritems_sold);
        $bazaaritems_popular = collect($bazaaritems_popular);

        $bazaaritems_newly = $bazaaritems->sortBy('updated_at');


        $sort = request()->has('sort') ? request()->query('sort') : 'name';

        if ($sort == 'price' || $sort == 'name') {
            $bazaaritems_popular = $bazaaritems_popular->sortBy("{$sort}");
            $bazaaritems_newly = $bazaaritems_newly->sortBy("{$sort}");
            $bazaaritems_sold = $bazaaritems_sold->sortBy("{$sort}");
        } else {
            $bazaaritems_popular = $bazaaritems_popular->sortByDesc("{$sort}");
            $bazaaritems_newly = $bazaaritems_newly->sortByDesc("{$sort}");
            $bazaaritems_sold = $bazaaritems_sold->sortByDesc("{$sort}");
        }

        $bazaarсategories = BazaarCategory::orderBy('sort', 'ASC')->get();

        return view('pages.cabinet.bazaar.list', compact('bazaaritems_popular','bazaaritems_newly','bazaaritems_sold', 'bazaarсategories','category_id','sort'));
    }

    public function history(Request $request)
    {
        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        $characters_items = [];
        foreach ($characters as $character) {
            $characters_items[$character->guid]['sold'] = BazaarSold::where('seller_id', auth()->user()->id)->where('seller_character_id', $character->guid)->latest()->get();
            $characters_items[$character->guid]['bought'] = BazaarSold::where('buyer_id', auth()->user()->id)->where('buyer_character_id', $character->guid)->latest()->get();
        }

        return view('pages.cabinet.bazaar.history', compact('characters_items', 'characters'));
    }

    public function show(Request $request, BazaarItem $item)
    {
        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        //Who put up for sale first, they buy first
        DB::statement("SET SQL_MODE=''");
        $bazaaritems = BazaarItem::where('type', $item->type)->groupBy('lvl')->orderBy('lvl', 'DESC')->get();

        return view('pages.cabinet.bazaar.full', compact('bazaaritems', 'characters'));
    }

    public function mylots(Request $request, BazaarItem $item)
    {
        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        $characters_items = [];
        foreach ($characters as $character) {
            $characters_items[$character->guid] = BazaarItem::where('user_id', auth()->user()->id)->where('account_id', auth()->user()->wow_id)->where('character_id', $character->guid)->latest()->get();
        }

        return view('pages.cabinet.bazaar.mylots', compact('characters_items', 'characters'));
    }

    public function sell(Request $request) {

        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        $bazaar_seller = BazaarSeller::where('user_id', auth()->user()->id)->first();

        return view('pages.cabinet.bazaar.sell', compact('characters', 'bazaar_seller'));
    }

    public function buy(Request $request, BazaarItem $item)
    {
        //$user->balance += $amount * (100 - config('options.market_seller_commission', '5')) / 100;
        $sell_percent = number_format(config('options.bazaar_percent_sale', "20")/100, 2);
        $char_id = intval($request->input('char_id'));
        $user_sale = User::find($item->user_id);

        if ($item->user_id == auth()->user()->id) {
            $this->alert('danger', __('Ошибка! Не удалось купить предмет! Это ваш лот.'));
            return back();
        }

        if (!$user_sale || !GameServer::checkGameCharacter($char_id, auth()->user()->wow_id))  {
            $this->alert('danger', __('Ошибка! Не удалось купить предмет! Попробуйте позже.'));
            return back();
        }

        if (auth()->user()->balance <= abs($item->price)) {
            $this->alert('danger', __('Недостаточно') . ' ' . config('options.coin_name', 'Coins') . ' ' . __('на балансе!'));
            return back();
        }

        if (GameServer::transferItemGameServer($item->character_id, $item->amount, $item->type)) {

            auth()->user()->decrement('balance', abs($item->price));
            $user_sale->balance += abs($item->price) * $sell_percent;
            $user_sale->save();

            //Set flag
            GameServer:changeItemGameServer($item->character_id, $item->type, '4');

            //Whrite data to MarketSold
            $bazaarsold = new BazaarSold;
            $bazaarsold->type = $item->type;
            $bazaarsold->category_id = $item->category_id;
            $bazaarsold->price = $item->price;
            $bazaarsold->count = $item->count;
            $bazaarsold->sale_type = $item->sale_type;
            $bazaarsold->seller_id = $item->user_id;
            $bazaarsold->buyer_id = auth()->id();
            $bazaarsold->seller_character_id = $item->character_id;
            $bazaarsold->buyer_character_id = $char_id;
            $bazaarsold->amount = $item->amount;
            $bazaarsold->lvl = $item->lvl;
            $bazaarsold->enchant = $item->enchant;
            $bazaarsold->intensive_item_type = $item->intensive_item_type;
            $bazaarsold->variation_opt2 = $item->variation_opt2;
            $bazaarsold->variation_opt1 = $item->variation_opt1;
            $bazaarsold->wished = $item->wished;
            $bazaarsold->ident = $item->ident;
            $bazaarsold->bless = $item->bless;
            $bazaarsold->server = $item->server;
            $bazaarsold->status = 2;
            $bazaarsold->save();

            //Add level for seller
            $bazaarseller = BazaarSeller::where('user_id', $item->user_id)->first();
            if ($bazaarseller) {
                $bazaarseller->trust_lvl++;
                $bazaarseller->save();
            }

            //Delete bazaar item
            $item->delete();

            Log::channel('paymentslog')->info("Robot: Player ".auth()->user()->name." (".auth()->user()->email.") bought item {$item->name} for {$item->price} for Character ID: {$item->character_id}. Parameters:" . json_encode($item->toArray()));

            $this->alert('success', __('Предмет успешно куплен!'));
            return redirect()->route('bazaar');
        }

        $this->alert('danger', __('Ошибка! Не удалось купить предмет! Попробуйте позже.'));
        return back();

    }

    public function cancel(Request $request, BazaarItem $item)
    {
        $char_id = intval($request->input('char_id'));

        if ($item->user_id != auth()->user()->id || !GameServer::checkGameCharacter($char_id, auth()->user()->wow_id))  {
            $this->alert('danger', __('Ошибка! Не удалось отменить лот! Попробуйте позже.'));
            return back();
        }

        if (GameServer::transferItemGameServer($item->character_id, $item->amount, $item->type, $item->bonuses)) {

            GameServer:changeItemGameServer($char_id, $item->type, '0x04');

            //Delete bazaar item
            $item->delete();

            Log::channel('paymentslog')->info("Robot: Player ".auth()->user()->name." (".auth()->user()->email.") cancel item's lot {$item->name} for {$item->price} for Character ID: {$item->character_id}. Parameters:" . json_encode($item->toArray()));

            $this->alert('success', __('Лот успешно отменен!'));
            return redirect()->route('bazaar.mylots');
        }

        $this->alert('danger', __('Ошибка! Не удалось отменить лот! Попробуйте позже.'));
        return back();

    }

    public function sellout(Request $request, $item)
    {
        $item_id = $item;
        $price = intval(abs(getitem_bazaarprice($item_id, 0)));
        $char_id = intval($request->input('char_id'));
        $category_id = 0;

        $bazaar_seller = BazaarSeller::where('user_id', auth()->user()->id)->first();

        if (auth()->user()->trader_active <= 0 || !$bazaar_seller) {
            $this->alert('danger', __('Ошибка! Обратитесь к администратору, чтобы он активировал вас как Продавца!'));
            return back();
        }

        if (auth()->user()->status_2fa <= 0) {
            $this->alert('danger', __('Ошибка! Вы должны активировать Двухфакторную авторизацию!'));
            return back();
        }

        //If account banned, else not allow sell
        if (GameServer::checkBannedGameAccount(auth()->user()->wow_id)) {
            $this->alert('danger', __('Ошибка! Ваш аккаунт забанен или был забанен менее, чем 6 месяцев назад.'));
            return back();
        }

        //Check character for allow lvl, game in time, other
        if ($price <= 0 || $char_id <= 0 || !GameServer::checkGameCharacter($char_id, auth()->user()->wow_id)) {
            $this->alert('danger', __('Ошибка! Не удалось выставить предмет на продажу! Попробуйте позже.'));
            return back();
        }
        if (!GameServer::checkLvlTimeGameCharacter($char_id, auth()->user()->wow_id)) {
            $this->alert('danger', __('Ошибка! Персонаж должен иметь 110 уровень и более 48 часов в игре.'));
            return back();
        }

        //Check items riles
        if (getitemtooltiplvl($item_id, 0) < 865) {
            $this->alert('danger', __('Ошибка! Предмет ниже допустимого 865 уровня.'));
            return back();
        }
        if (!GameServer::checkGameCharacterItem24hours($char_id, $item_id)) {
            $this->alert('danger', __('Ошибка! Предмет может быть продан только в течение 24 часов после выпадения.'));
            return back();
        }
        if (!BazaarItemsPatch::where('item_id', $item_id)->where('Patch', '703')->first()) {
            $this->alert('danger', __('Ошибка! Источник предмета должен быть только из рейда, навоза и мира.'));
            return back();
        }


        $date = strtotime(date('Y-m-d H:i:s'));
        $date_24h = strtotime($bazaar_seller->charge_date) + 60*60*24;

        if ($date > $date_24h)  {
            $date = date('Y-m-d H:i:s');
            $bazaar_seller->charge = 1;
            $bazaar_seller->charge_date = $date;
            $bazaar_seller->save();
        }

        $date_24h = strtotime($bazaar_seller->charge2_date) + 60*60*24;

        if ($date > $date_24h)  {
            $date = date('Y-m-d H:i:s');
            $bazaar_seller->charge2 = 1;
            $bazaar_seller->charge2_date = $date;
            $bazaar_seller->save();
        }

        if ($bazaar_seller->charge == 0 && $bazaar_seller->charge2 == 0) {
            $this->alert('danger', __('Ошибка! У вас нет больше зарядов для продажи! Подождите 24 часа, пока заряды начислятся!'));
            return back();
        }

        if (!GameServer::checkOnlineGameCharacter($char_id, auth()->user()->wow_id)) {
            $this->alert('danger', __('Ошибка! Персонаж должен быть оффлайн!'));
            return back();
        }

        $char_item = getItemGameCharacterInventory($char_id, $item_id);
        if (!$char_item) {
            $this->alert('danger', __('Ошибка! Не удалось выставить предмет на продажу! Попробуйте позже.'));
            return back();
        }
        if ($char_item->custom_flags = '0x04') {
            $this->alert('danger', __('Ошибка! Не удалось выставить предмет на продажу! Попробуйте позже.'));
            return back();
        }

        $char_item_bonuses = str_replace(['1808', '40', '41', '42', '43'], '', $char_item->bonuses);

        $lvl = getitemtooltiplvl($item_id, 0);

        if (GameServer::lockGameItemCharacter($char_id, $item_id)) {
            $bazaaritem = new BazaarItem;
            $bazaaritem->category_id = $category_id;
            $bazaaritem->price = $price;
            $bazaaritem->count = 1;
            $bazaaritem->status = 1;
            $bazaaritem->sale_type = 1;
            $bazaaritem->type = $item_id;
            $bazaaritem->lvl = $lvl;
            $bazaaritem->amount = 1;
            $bazaaritem->bonuses = $char_item_bonuses;
            $bazaaritem->enchant = 0;
            $bazaaritem->intensive_item_type = 0;
            $bazaaritem->variation_opt2 = 0;
            $bazaaritem->variation_opt1 = 0;
            $bazaaritem->wished = 0;
            $bazaaritem->ident = 0;
            $bazaaritem->bless = 0;
            $bazaaritem->eroded = 0;
            $bazaaritem->server = 1;
            $bazaaritem->latest_id = 0;
            $bazaaritem->account_id = auth()->user()->wow_id;
            $bazaaritem->user_id = auth()->user()->id;
            $bazaaritem->character_id = $char_id;
            $bazaaritem->save();

            //Change charge saller
            if ($bazaar_seller->charge == 1) {
                $bazaar_seller->charge = 0;
            } else {
                $bazaar_seller->charge2 = 0;
            }
            $bazaar_seller->save();

            $this->alert('success', __('Вы успешно выставили предмет на продажу!'));
            return back();
        }

        $this->alert('danger', __('Ошибка! Не удалось выставить предмет на продажу! Попробуйте позже.'));
        return back();
    }

    public function destroy($character)
    {

        $shopcharacter = ShopCharacter::where('uuid', $character)->first();

        if ($shopcharacter && $shopcharacter->user_id == auth()->id()) {
            if (GameServer::unlockGameCharacter($shopcharacter->char_id, $shopcharacter->account_id)) {
                $shopcharacter->forceDelete();
                if ($shopcharacter->image) {
                    Storage::disk('public')->delete($shopcharacter->image);
                }

                $this->alert('success', __('Вы успешно отменили продажу персонажа!'));
                return back();
            }
        }

        $this->alert('danger', __('Ошибка! Не удалось отменить продажу персонажа! Попробуйте позже.'));
        return back();

    }

    public function setPatchItems() {

        $items_str = '141486,141448,141419,141413,141423,141427,141438,141533,141437,141430,141443,141432,141538,141433,141429,141439,141535,141428,141539,141544,141476,141475,141466,141470,141540,141426,141445,141422,141416,141536,141473,141545,141431,141440,141435,141441,141534,141488,141425,141415,141417,141421,141420,141546,141418,141414,141424,141541,141542,141547,141481,141491,141487,141495,141455,141492,141543,141453,141449,141459,141482,139239,139332,141696,138221,139248,138212,138215,138217,139187,139188,139189,139190,139191,139192,139193,139194,139195,139196,140993,138219,139197,139198,139199,139200,139201,139202,139203,139204,139205,139206,139207,139208,139209,140996,141006,138211,138214,139211,139212,139213,139214,139215,139216,139217,139218,139219,139220,139221,139222,141694,138216,138218,139224,139225,139226,139227,139228,139229,139230,139231,139232,139233,139234,139235,141695,138220,139236,139237,139238,138222,138224,138225,139320,139321,139322,139323,139324,139325,139326,139327,139328,139329,139330,139333,139334,139335,139336,134412,134419,134426,134431,134437,134440,134442,134451,134469,134477,134483,134490,134499,134507,134510,134519,134528,136714,136715,136716,136724,136770,136976,136977,136978,136979,139240,139241,139242,139243,139244,139245,139246,139247,134405,134423,134429,134448,134452,134461,134462,134464,134487,134500,134504,134520,134531,134537,137300,137301,137304,137305,137306,137309,137310,137311,137312,137314,137315,137319,137320,137321,137322,134406,134417,134428,134433,134438,134441,134456,134459,134465,134471,134478,134484,134492,134497,134505,134508,134512,134514,134525,134532,134539,137360,137361,137362,137364,137367,137368,137369,137372,137373,137378,133609,133610,133613,133615,133617,133620,133621,133622,133623,133626,133628,133630,133631,133633,133638,133639,133641,133642,133646,133647,133679,133765,133767,133805,136772,136773,136774,136775,136776,136777,136975,139280,139281,139282,139283,144259,142414,142416,142418,142420,142424,142427,142428,142429,142433,142507,142521,134408,134416,134420,134427,134443,134455,134458,134470,134474,134481,134491,134495,134511,134517,134524,134530,137336,137337,137338,137341,137342,137344,137348,137349,137352,137353,137354,137355,137357,137502,137503,137504,137505,137506,137507,137508,137509,137510,137511,137512,137513,137514,137515,137516,137517,137518,137519,137520,137521,137522,137523,137524,137525,137526,137527,137528,137529,137530,137531,137532,137533,137535,137536,137537,137538,137539,137540,137541,134415,134432,134447,134460,134473,134480,134503,134513,134529,134542,137480,137482,137483,137484,137485,137486,137487,137488,137489,137496,137497,137498,137499,133766,134402,134410,134413,134421,134424,134435,134444,134449,134453,134463,134467,134472,134475,134488,134501,134509,134518,134522,134526,134533,134540,137397,137398,137400,137404,137405,137406,137409,137410,137413,137415,137416,137417,137418,137419';

        $items = explode(',', $items_str);

        foreach ($items as $item) {
            $bazaar_items_patch = new BazaarItemsPatch;
            $bazaar_items_patch->item_id = $item;
            $bazaar_items_patch->Patch = '703';
            $bazaar_items_patch->save();
        }

        return back();
    }

}
