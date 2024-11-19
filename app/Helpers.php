<?php

use App\Models\Server;
use App\Models\Option;
use App\Models\Referral;
use App\Models\Ticket;
use App\Models\LineageItem;
use App\Models\ShopCoupon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Lib\GameServer\GameServerFacade as GameServer;

if (!function_exists('getlangs')) {
    function getlangs()
    {
        $langs = [];
        if (config('options.language1') !== NULL && config('options.language1') === 'en') $langs['en'] = __('Английский');
        if (config('options.language2') !== NULL && config('options.language2') === 'ru') $langs['ru'] = __('Русский');
        if (config('options.language3') !== NULL && config('options.language3') === 'pt') $langs['pt'] = __('Португальский');
        if (config('options.language4') !== NULL && config('options.language4') === 'es') $langs['es'] = __('Испанский');
        if (config('options.language5') !== NULL && config('options.language5') === 'fr') $langs['fr'] = __('Французский');

        return $langs;
    }
}

if (!function_exists('server_status')) {
    function server_status($server_id=1)
    {
        if (config('database.server_check', false) === false) {
            return 'Offline';
        }

        return "Online";

        //Cache::forget('server'.$server_id.':status');
        return Cache::remember('server'.$server_id.':status', 3600, function () use($server_id) {
            $online_count = GameServer::getStatus($server_id);
            $online_count = $online_count * intval(config('options.server_' . $server_id . '_mul_online', '1'));
            return $online_count;
        });
    }
}

if (!function_exists('online_count')) {
    function online_count($server_id=1)
    {
        if (server_status($server_id) === 'Offline') return 0;

        //Cache::forget('server'.$server_id.':online_count');
        return Cache::remember('server'.$server_id.':online_count', 3600, function () use($server_id) {
            $online_count = GameServer::getOnlineCount($server_id);
            return $online_count * intval(config('options.server_' . $server_id . '_mul_online', '1'));
        });
    }
}

if (!function_exists('server_rating')) {
    function server_rating() {

        if (server_status() === 'Online') {
            //Cache::forget('server:rating');
            return Cache::rememberForever('server:rating', function () {
                return GameServer::server_rating();
            });
        }

        return FALSE;
    }
}

if (!function_exists('getvoting_platforms')) {
    function getvoting_platforms()
    {
        return [
            '1' => [
                'id' => '1',
                'name' => 'mmotop',
                'title' => 'MMOTOP.RU',
                'image' => '/img/info/company_09.png',
            ],
            '2' => [
                'id' => '2',
                'name' => 'hopezone',
                'title' => 'HOPEZONE.NET',
                'image' => '/img/info/company_01.png',
            ],
            '3' => [
                'id' => '3',
                'name' => 'wowservers',
                'title' => 'WOW-SERVERS.RU',
                'image' => '/img/info/company_02.png',
            ],
            '4' => [
                'id' => '4',
                'name' => 'mcmonitoring',
                'title' => 'MC-MONITORING.INFO',
                'image' => '/img/info/company_03.png',
            ],
            '5' => [
                'id' => '5',
                'name' => 'topmmogames',
                'title' => 'TOP-MMOGAMES.RU',
                'image' => '/img/info/company_04.png',
            ],
        ];
    }
}

if (! function_exists('articles_count')) {
    function articles_count() {
        return \App\Models\Article::count();
    }
}

if (! function_exists('users_count')) {
    function users_count() {
        return \App\Models\User::count();
    }
}

if (! function_exists('tickets_count')) {
    function tickets_count() {
        return \App\Models\Ticket::where('status', 1)->count();
    }
}

if (! function_exists('reports_count')) {
    function reports_count() {
        return \App\Models\Report::where('status', 1)->count();
    }
}

if (! function_exists('releasenotes_count')) {
    function releasenotes_count() {
        return \App\Models\ReleaseNote::count();
    }
}

if (! function_exists('videos_count')) {
    function videos_count() {
        return \App\Models\Video::count();
    }
}

if (! function_exists('streams_count')) {
    function streams_count() {
        return \App\Models\Stream::count();
    }
}

if (! function_exists('auctions_count')) {
    function auctions_count() {
        return \App\Models\Auction::count();
    }
}

if (! function_exists('referrals_count')) {
    function referrals_count() {
        return \App\Models\Stream::count();
    }
}

if (! function_exists('promocodes_count')) {
    function promocodes_count() {
        return \App\Models\PromoCode::count();
    }
}
if (! function_exists('faqs_count')) {
    function faqs_count() {
        return \App\Models\Faq::count();
    }
}
if (! function_exists('features_count')) {
    function features_count() {
        return \App\Models\Feature::count();
    }
}
if (! function_exists('releases_count')) {
    function releases_count() {
        return \App\Models\Release::count();
    }
}

if (!function_exists('shopitems_count')) {
    function shopitems_count()
    {
        return \App\Models\ShopItem::count();
    }
}

if (!function_exists('shopcoupons_count')) {
    function shopcoupons_count()
    {
        return \App\Models\ShopCoupon::count();
    }
}

if (!function_exists('marketitems_count')) {
    function marketitems_count()
    {
        return \App\Models\MarketItem::count();
    }
}

if (! function_exists('servers_count')) {
    function servers_count() {
        return \App\Models\Server::count();
    }
}

if (! function_exists('getservers')) {
    function getservers() {
        return \App\Models\Server::query()->where('status', 1)->get();
    }
}

if (! function_exists('getserver')) {
    function getserver($id) {
        return \App\Models\Server::query()->where('id', $id)->first();
    }
}

if (! function_exists('getitem')) {
    function getitem($id) {
        return \App\Models\LineageItem::query()->where('id', $id)->first();
    }
}

if (! function_exists('getshopitem')) {
    function getshopitem($id) {
        return \App\Models\ShopItem::find($id);
    }
}

if (!function_exists('shopcoupons_count')) {
    function shopcoupons_count()
    {
        return \App\Models\ShopCoupon::count();
    }
}

if (!function_exists('getGameCharacters')) {
    function get_game_characters()
    {
        return GameServer::getGameCharacters(auth()->user()->wow_id);
    }
}

if (!function_exists('getshopcategories')) {
    function getshopcategories()
    {
        $shopcategories = [];
        $shopcategories_qry = \App\Models\ShopCategory::where('main_category_id', '0')->get();
        foreach ($shopcategories_qry as $shopcategory) {
            $shopcategories[$shopcategory->id] = [];
            $shopcategories_childs_1 = getchildshopcategories($shopcategory->id);
            if ($shopcategories_childs_1->count() > 0) {
                foreach ($shopcategories_childs_1 as $shopcategory_child_1) {
                    $shopcategories[$shopcategory->id][$shopcategory_child_1->id] = [];
                    $shopcategories_childs_2 = getchildshopcategories($shopcategory_child_1->id);
                    if ($shopcategories_childs_2->count() > 0) {
                        foreach ($shopcategories_childs_2 as $shopcategory_child_2) {
                            $shopcategories[$shopcategory->id][$shopcategory_child_1->id][$shopcategory_child_2->id] = [];
                            $shopcategories_childs_3 = getchildshopcategories($shopcategory_child_2->id);
                            if ($shopcategories_childs_3->count() > 0) {
                                foreach ($shopcategories_childs_3 as $shopcategory_child_3) {
                                    $shopcategories[$shopcategory->id][$shopcategory_child_1->id][$shopcategory_child_2->id][$shopcategory_child_3->id] = [];
                                    $shopcategories_childs_4 = getchildshopcategories($shopcategory_child_3->id);
                                    if ($shopcategories_childs_4->count() > 0) {
                                        foreach ($shopcategories_childs_4 as $shopcategory_child_4) {
                                            $shopcategories[$shopcategory->id][$shopcategory_child_1->id][$shopcategory_child_2->id][$shopcategory_child_3->id][$shopcategory_child_4->id] = [];
                                            $shopcategories_childs_5 = getchildshopcategories($shopcategory_child_4->id);
                                            if ($shopcategories_childs_5->count() > 0) {
                                                foreach ($shopcategories_childs_5 as $shopcategory_child_5) {
                                                    $shopcategories[$shopcategory->id][$shopcategory_child_1->id][$shopcategory_child_2->id][$shopcategory_child_3->id][$shopcategory_child_4->id][$shopcategory_child_5->id] = [];
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                        }
                    }
                }
            }

        }
        return $shopcategories;
    }
}

if (!function_exists('getmainshopcategories')) {
    function getmainshopcategories()
    {
        return \App\Models\ShopCategory::where('main_category_id', '0')->get()->sortBy('sort');
    }
}

if (!function_exists('getchildshopcategories')) {
    function getchildshopcategories($id)
    {
        return \App\Models\ShopCategory::where('main_category_id', $id)->get();
    }
}

if (!function_exists('childshopcategories_count')) {
    function childshopcategories_count($id)
    {
        return \App\Models\ShopCategory::where('main_category_id', $id)->count();
    }
}

if (!function_exists('getshopcategory')) {
    function getshopcategory($id)
    {
        return \App\Models\ShopCategory::find($id);
    }
}

if (!function_exists('getuser')) {
    function getuser($id) {
        return \App\Models\User::query()->where('id', $id)->first();
    }
}

if (!function_exists('marketitems_count_bycategory')) {
    function marketitems_count_bycategory($id, $server_id)
    {
        return \App\Models\MarketItem::query()->where('category_id', $id)->where('server', $server_id)->count();
    }
}


if (!function_exists('getbazaaritems_count_by_lvl')) {
    function getbazaaritems_count_by_lvl($item_id, $lvl)
    {
        return \App\Models\BazaarItem::where('type', $item_id)->where('lvl', $lvl)->count();
    }
}

if (!function_exists('getbazaarcategory')) {
    function getbazaarcategory($id)
    {
        return \App\Models\BazaarCategory::find($id);
    }
}


if (!function_exists('getbazaarcategoryName')) {
    function getbazaarcategoryName($id)
    {
        $title = "title_" .app()->getLocale();
        $bazaarcategory = getbazaarcategory($id);
        return ($bazaarcategory) ? $bazaarcategory->$title : '';
    }
}


if (!function_exists('getitemicon')) {
    function getitemicon($wow_id)
    {
        $item = Item::query()->where('id', $wow_id)->first();
        if ($item) {
            //Cache::forget('FirestormAPI:getIconUrl:item_' . $wow_id);
            return Cache::rememberForever('FirestormAPI:getIconUrl:item_' . $wow_id, function () use($item) {
                $item_url = FirestormAPI::getIconUrl() . $item->url;
                return $item_url;
            });
        }
        return '';
    }
}

if (!function_exists('getitemtooltiptitle')) {
    function getitemtooltiptitle($wow_id, $bonuses)
    {
        return FirestormAPI::getTooltipTitle($wow_id, $bonuses);
        //Cache::forget('FirestormAPI:getTooltipTitle:item_' . $wow_id . ':' .$bonuses);
        return Cache::rememberForever('FirestormAPI:getTooltipTitle:item_' . $wow_id . ':' .$bonuses, function () use($wow_id, $bonuses) {
            $tooltip_title = FirestormAPI::getTooltipTitle($wow_id, $bonuses);
            return $tooltip_title;
        });
    }
}

if (!function_exists('getitemtooltipdescription')) {
    function getitemtooltipdescription($wow_id, $bonuses)
    {
        return FirestormAPI::getTooltipDescription($wow_id, $bonuses);
        //Cache::forget('FirestormAPI:getTooltipDescription:item_' . $wow_id . ':' .$bonuses);
        return Cache::rememberForever('FirestormAPI:getTooltipDescription:item_' . $wow_id . ':' .$bonuses, function () use($wow_id, $bonuses) {
            $tooltip_description = FirestormAPI::getTooltipDescription($wow_id, $bonuses);
            return $tooltip_description;
        });
    }
}

if (!function_exists('getitemtooltiplvl')) {
    function getitemtooltiplvl($wow_id, $bonuses)
    {
        return FirestormAPI::getitemtooltiplvl($wow_id, $bonuses);
        //Cache::forget('FirestormAPI:getitemtooltiplvl:item_' . $wow_id . ':' .$bonuses);
        return Cache::rememberForever('FirestormAPI:getitemtooltiplvl:item_' . $wow_id . ':' .$bonuses, function () use($wow_id, $bonuses) {
            $tooltip_lvl = FirestormAPI::getitemtooltiplvl($wow_id, $bonuses);
            return $tooltip_lvl;
        });
    }
}

if (!function_exists('getitemtooltipcategory')) {
    function getitemtooltipcategory($wow_id, $bonuses)
    {
        return FirestormAPI::getitemtooltipcategory($wow_id, $bonuses);
        //Cache::forget('FirestormAPI:getitemtooltipcategory:item_' . $wow_id . ':' .$bonuses);
        return Cache::rememberForever('FirestormAPI:getitemtooltipcategory:item_' . $wow_id . ':' .$bonuses, function () use($wow_id, $bonuses) {
            $tooltip_lvl = FirestormAPI::getitemtooltipcategory($wow_id, $bonuses);
            return $tooltip_lvl;
        });
    }
}

if (!function_exists('getitem_bazaarprice')) {
    function getitem_bazaarprice($wow_id, $bonuses)
    {
        $item_gdb= GameServer::getGameItemSparse($wow_id);
        if ($item_gdb) {
            $slot_id = $item_gdb->InventoryType;
        } else {
            $slot_id = 0;
        }

        $lvl = getitemtooltiplvl($wow_id, $bonuses);
        if (in_array($slot_id, [1,3,5,20,10,7,12,16])) {
            if ($lvl >= 895) {
                $price = config('options.bazaar_itemgroup_1_v1', "30");
            } else if ($lvl >= 890) {
                $price = config('options.bazaar_itemgroup_1_v2', "30");
            } else if ($lvl >= 885) {
                $price = config('options.bazaar_itemgroup_1_v3', "30");
            } else if ($lvl >= 880) {
                $price = config('options.bazaar_itemgroup_1_v4', "30");
            } else if ($lvl >= 875) {
                $price = config('options.bazaar_itemgroup_1_v5', "30");
            } else if ($lvl >= 870) {
                $price = config('options.bazaar_itemgroup_1_v6', "30");
            } else if ($lvl >= 865) {
                $price = config('options.bazaar_itemgroup_1_v7', "30");
            } else {
                $price = config('options.bazaar_itemgroup_1_v7', "30");
            }
        } elseif (in_array($slot_id, [2,9,6,8,11])) {
            if ($lvl >= 895) {
                $price = config('options.bazaar_itemgroup_2_v1', "30");
            } else if ($lvl >= 890) {
                $price = config('options.bazaar_itemgroup_2_v2', "30");
            } else if ($lvl >= 885) {
                $price = config('options.bazaar_itemgroup_2_v3', "30");
            } else if ($lvl >= 880) {
                $price = config('options.bazaar_itemgroup_2_v4', "30");
            } else if ($lvl >= 875) {
                $price = config('options.bazaar_itemgroup_2_v5', "30");
            } else if ($lvl >= 870) {
                $price = config('options.bazaar_itemgroup_2_v6', "30");
            } else if ($lvl >= 865) {
                $price = config('options.bazaar_itemgroup_2_v7', "30");
            } else {
                $price = config('options.bazaar_itemgroup_2_v7', "30");
            }
        } else {
            $price = config('options.bazaar_itemgroup_1_v1', "30");
        }

        if (in_array($wow_id, [141482,134526,134542])) {
            $price += config('options.bazaar_itemgroup_3_v1', "5");
        }

        return $price;
    }
}


if (! function_exists('downcounter')) {
    function downcounter($date, $down_time=720) {

        $date_str = strtotime($date) + 60 * $down_time;
        $date = date('Y-m-d H:i:s', $date_str);

        $check_time = strtotime($date) - time();
        if($check_time <= 0){
            return '-';
        }

        $days = floor($check_time/86400);
        $hours = floor(($check_time%86400)/3600);
        $minutes = floor(($check_time%3600)/60);
        $seconds = $check_time%60;

        $str = $hours . __('ч') . ' : ' . $minutes . __('м') . ' : ' . $seconds . __('c');

        return $str;
    }
}

if (!function_exists('get_statistics_game_items_name')) {
    function get_statistics_game_items_name($id) {
        for($it=0;$it<100;$it++) {
            if (config('options.statistics_game_item_'.$it.'_id', 0) == $id) {
                return config('options.statistics_game_item_' . $it . '_name', '');
            }
        }
        return '-';
    }
}

if (!function_exists('checkItemPurchaseStatus')) {
    function checkItemPurchaseStatus($id) {
        $shopitems = \App\Models\ShopItem::where('id', $id)->first();
        $shop_purchases = \App\Models\ShopPurchase::where('item_id', $id)->where('user_id', auth()->user()->id)->where('validity', '>', date('Y-m-d H:i:s'))->first();

        if ($shopitems->purchase_type == '1' && $shop_purchases) {

            if (strtotime($shop_purchases->validity) < strtotime(date('Y-m-d H:i:s'))) {
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return FALSE;
        }
    }
}





if (! function_exists('convertToStrList')) {
    function convertToStrList($data) {
        $list = '';
        $item_index = 0;
        foreach ($data as $item) {
            $item_index++;
            $list .= '"' . $item . '"';
            if ($item_index < count($data)) {
                $list .= ', ';
            }
        }

        return $list;
    }
}

if (! function_exists('generationCode')) {
    function generationCode()
    {
        //Генерирую случайный код
        $permitted_chars = '0123456789';
        return substr(str_shuffle($permitted_chars), 0, 4);
    }
}

if (! function_exists('generationReferralCode')) {
    function generationReferralCode()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        return substr(str_shuffle($permitted_chars), 0, 5) . '-' . substr(str_shuffle($permitted_chars), 0, 10) . '-' . substr(str_shuffle($permitted_chars), 0, 6);
    }
}

if (! function_exists('generationPromoCode')) {
    function generationPromoCode()
    {
        $permitted_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        for ($i=0;$i<100;$i++) {
            $code = substr(str_shuffle($permitted_chars), 0, 20);
            $promocode = \App\Models\PromoCode::where('code', $code)->first();
            if (!$promocode) break;
        }

        return $code;
    }
}

if (! function_exists('generationPassword')) {
    function generationPassword()
    {
        //Генерирую случайный пароль
        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($permitted_chars), 0, 10);
    }
}

if (! function_exists('generationReferralCode')) {
    function generationReferralCode()
    {
        $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($permitted_chars), 0, 5) . '-' . substr(str_shuffle($permitted_chars), 0, 10) . '-' . substr(str_shuffle($permitted_chars), 0, 6);
    }
}

if (! function_exists('random_str')) {
    function random_str($len = 5)
    {
        $charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base) {
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -$len);
    }
}

if (! function_exists('encrypt_whirlpool')) {
    function encrypt_whirlpool(string $str): string
    {
	$encrypt = base64_encode(hash('whirlpool', $str, true));
        return $encrypt;
    }

}

if (! function_exists('encrypt')) {
    function encrypt(string $str): string
    {
        $key = array();
        $dst = array();
        $i = 0;

        $nBytes = strlen($str);
        while ($i < $nBytes) {
            $i++;
            $key[$i] = ord(substr($str, $i - 1, 1));
            $dst[$i] = $key[$i];
        }

        for ($i = 0; $i < 17; $i++) {
            if (!isset($key[$i])) $key[$i] = null;
            if (!isset($dst[$i])) $dst[$i] = null;
        }

        $rslt = $key[1] + $key[2] * 256 + $key[3] * 65536 + $key[4] * 16777216;
        $one = $rslt * 213119 + 2529077;
        $one = $one - intval($one / 4294967296) * 4294967296;

        $rslt = $key[5] + $key[6] * 256 + $key[7] * 65536 + $key[8] * 16777216;
        $two = $rslt * 213247 + 2529089;
        $two = $two - intval($two / 4294967296) * 4294967296;

        $rslt = $key[9] + $key[10] * 256 + $key[11] * 65536 + $key[12] * 16777216;
        $three = $rslt * 213203 + 2529589;
        $three = $three - intval($three / 4294967296) * 4294967296;

        $rslt = $key[13] + $key[14] * 256 + $key[15] * 65536 + $key[16] * 16777216;
        $four = $rslt * 213821 + 2529997;
        $four = $four - intval($four / 4294967296) * 4294967296;

        $key[1] = $one & 0xFF;
        $key[2] = ($one >> 8) & 0xFF;
        $key[3] = ($one >> 16) & 0xFF;
        $key[4] = ($one >> 24) & 0xFF;

        $key[5] = $two & 0xFF;
        $key[6] = ($two >> 8) & 0xFF;
        $key[7] = ($two >> 16) & 0xFF;
        $key[8] = ($two >> 24) & 0xFF;

        $key[9] = $three & 0xFF;
        $key[10] = ($three >> 8) & 0xFF;
        $key[11] = ($three >> 16) & 0xFF;
        $key[12] = ($three >> 24) & 0xFF;

        $key[13] = $four & 0xFF;
        $key[14] = ($four >> 8) & 0xFF;
        $key[15] = ($four >> 16) & 0xFF;
        $key[16] = ($four >> 24) & 0xFF;

        $dst[1] = $dst[1] ^ $key[1];

        $i = 1;
        while ($i < 16) {
            $i++;
            $dst[$i] = $dst[$i] ^ $dst[$i - 1] ^ $key[$i];
        }

        $i = 0;
        while ($i < 16) {
            $i++;
            if ($dst[$i] == 0) {
                $dst[$i] = 102;
            }
        }

//        $encrypt = "0x";
        $encrypt = '';
        $i = 0;
        while ($i < 16) {
            $i++;
            if ($dst[$i] < 16) {
                $encrypt = $encrypt . "0" . dechex($dst[$i]);
            } else {
                $encrypt = $encrypt . dechex($dst[$i]);
            }
        }
        return $encrypt;
    }

}

if (! function_exists('format_seconds')) {
    function format_seconds($inputSeconds)
    {
        $secondsInAMinute = 60;
        $secondsInAnHour  = 60 * $secondsInAMinute;
        $secondsInADay    = 24 * $secondsInAnHour;

        $days = floor($inputSeconds / $secondsInADay);

        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        $obj = array(
            'д' => (int) $days,
            'ч' => (int) $hours,
            'м' => (int) $minutes,
            'с' => (int) $seconds,
        );

        $str = '';
        if($days > 0){

            $str .= "$days д ";
        }
        if($hours > 0){

            $str .= "$hours ч ";
        }

        if($minutes > 0 AND $days == 0){

            $str .= "$minutes м";
        }
        return $str;
    }
}


if (! function_exists('time_diff_plural_forms')) {
    function time_diff_plural_forms($time)
    {
        $diff_time = strtotime('now') - $time;

        $time_form = '';
        $days = intval($diff_time / 86400); // количество дней (86400 секунд в сутках)
        $hours = intval(($diff_time % 86400) / 3600); // оставшиеся часы после вычета дней
        $minutes = intval(($diff_time % 3600) / 60); // оставшиеся минуты после вычета дней и часов
        $seconds = intval($diff_time % 60); // оставшиеся секунды после вычета дней, часов и минут

        if ($days > 0) {
            $time_form .= intval($days);
            if (intval($days) == 1) {
                $time_form .= ' ' . __('день') . ' ';
            } elseif (intval($days) > 1 && intval($days) < 5) {
                $time_form .= ' ' . __('дня') . ' ';
            } else {
                $time_form .= ' ' . __('дней') . ' ';
            }
        }

        if ($hours > 0) {
            $time_form .= intval($hours);
            if (intval($hours) == 1) {
                $time_form .= ' ' . __('час') . ' ';
            } elseif (intval($hours) > 1 && intval($hours) < 5) {
                $time_form .= ' ' . __('часа') . ' ';
            } else {
                $time_form .= ' ' . __('часов') . ' ';
            }
        }

        if ($minutes > 0) {
            $time_form .= intval($minutes);
            if (intval($minutes) == 1) {
                $time_form .= ' ' . __('минуту') . ' ';
            } elseif (intval($minutes) > 1 && intval($minutes) < 5) {
                $time_form .= ' ' . __('минуты') . ' ';
            } else {
                $time_form .= ' ' . __('минут') . ' ';
            }
        }

        if ($minutes == 0) {
            $time_form .= $seconds . ' ' . __('секунд');
        }

        return $time_form;
    }
}


if (! function_exists('plural_form')) {
    function plural_form(int $n, array $forms)
    {
        return is_float($n) ? $forms[1] : ($n % 10 == 1 && $n % 100 != 11 ? $forms[0] : ($n % 10 >= 2 && $n % 10 <= 4 && ($n % 100 < 10 || $n % 100 >= 20) ? $forms[1] : $forms[2]));
    }
}

if (!function_exists('getImageUrl')) {
    function getImageUrl($image)
    {
        if (str_contains($image, '/storage/')) {
            return $image;
        }
        return '/storage/' . $image;
    }
}


if (!function_exists('getListRacesName')) {
    function getListRacesName()
    {
        return [
            '1' => __('HUMAN'),
            '2' => __('ORC'),
            '3' => __('DWARF'),
            '4' => __('NIGHTELF'),
            '5' => __('UNDEAD PLAYER'),
            '6' => __('TAUREN'),
            '7' => __('GNOME'),
            '8' => __('TROLL'),
            '9' => __('GOBLIN'),
            '10' => __('BLOODELF'),
            '11' => __('DRAENEI'),
            '22' => __('WORGEN'),
            '24' => __('PANDAREN NEUTRAL'),
            '25' => __('PANDAREN ALLIANCE'),
            '26' => __('PANDAREN HORDE'),
            '27' => __('NIGHTBORNE'),
            '28' => __('HIGHMOUNTAIN TAUREN'),
            '29' => __('VOID ELF'),
            '30' => __('LIGHTFORGED DRAENEI'),
        ];
    }
}

if (!function_exists('getReportRacesNameById')) {
    function getReportRacesNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListRacesName()[$id];
    }
}

if (!function_exists('getListRacesHordeName')) {
    function getListRacesHordeName()
    {
        return [
            '2' => __('ORC'),
            '5' => __('UNDEAD PLAYER'),
            '6' => __('TAUREN'),
            '8' => __('TROLL'),
            '9' => __('GOBLIN'),
            '10' => __('BLOODELF'),
            '26' => __('PANDAREN HORDE'),
            '27' => __('NIGHTBORNE'),
            '28' => __('HIGHMOUNTAIN TAUREN'),
        ];
    }
}

if (!function_exists('getListRacesAllianceName')) {
    function getListRacesAllianceName()
    {
        return [
            '1' => __('HUMAN'),
            '3' => __('DWARF'),
            '4' => __('NIGHTELF'),
            '7' => __('GNOME'),
            '11' => __('DRAENEI'),
            '22' => __('WORGEN'),
            '25' => __('PANDAREN ALLIANCE'),
            '29' => __('VOID ELF'),
            '30' => __('LIGHTFORGED DRAENEI'),
        ];
    }
}

if (!function_exists('getListClassesName')) {
    function getListClassesName()
    {
        return [
            '1' => __('WARRIOR'),
            '2' => __('PALADIN'),
            '3' => __('HUNTER'),
            '4' => __('ROGUE'),
            '5' => __('PRIEST'),
            '6' => __('DEATH KNIGHT'),
            '7' => __('SHAMAN'),
            '8' => __('MAGE'),
            '9' => __('WARLOCK'),
            '10' => __('MONK'),
            '11' => __('DRUID'),
            '12' => __('DEMON HUNTER'),
            '13' => __('Общее'),
        ];
    }
}

if (!function_exists('getReportClassesNameById')) {
    function getReportClassesNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListClassesName()[$id];
    }
}

if (!function_exists('getListExploitsName')) {
    function getListExploitsName()
    {
        return [
            '21' => __('Низкий'),
            '22' => __('Средний'),
            '23' => __('Высокий'),
            '24' => __('Срочный'),
        ];
    }
}

if (!function_exists('getReportExploitsNameById')) {
    function getReportExploitsNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListExploitsName()[$id];
    }
}

if (!function_exists('getListInstancesName')) {
    function getListInstancesName()
    {
        return [
            '31' => __('Подземелья'),
            '32' => __('Рейды'),
            '33' => __('Сценарии'),
        ];
    }
}

if (!function_exists('getReportInstancesNameById')) {
    function getReportInstancesNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListInstancesName()[$id];
    }
}

if (!function_exists('getListOtherName')) {
    function getListOtherName()
    {
        return [
            '41' => __('Существа'),
            '42' => __('Игровые объекты'),
            '43' => __('Заклинания (не классы)'),
        ];
    }
}

if (!function_exists('getReportOtherNameById')) {
    function getReportOtherNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListOtherName()[$id];
    }
}

if (!function_exists('getListProfessionsName')) {
    function getListProfessionsName()
    {
        return [
            '51' => __('Травничество'),
            '52' => __('Горное дело'),
            '53' => __('Снятие шкур'),
            '54' => __('Алхимия'),
            '55' => __('Кузнечное дело'),
            '56' => __('Наложение чар'),
            '57' => __('Инженерное дело'),
            '58' => __('Начертание'),
            '59' => __('Ювелирное дело'),
            '60' => __('Кожевничество'),
            '61' => __('Портняжное дело'),
            '62' => __('Кулинария'),
        ];
    }
}

if (!function_exists('getReportProfessionsNameById')) {
    function getReportProfessionsNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListProfessionsName()[$id];
    }
}

if (!function_exists('getListCategoryName')) {
    function getListCategoryName()
    {
        return [
            '1' => __('Достижения'),
            '2' => __('Поля боя/Арены'),
            '3' => __('Классы'),
            '4' => __('Клиент'),
            '5' => __('Подвиги'),
            '6' => __('Экземпляры'),
            '7' => __('Предметы'),
            '8' => __('Другой'),
            '9' => __('Профессии'),
            '10' => __('Квесты'),
            '11' => __('Сайт'),
        ];
    }
}

if (!function_exists('getReportCategoryNameById')) {
    function getReportCategoryNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListCategoryName()[$id];
    }
}

if (!function_exists('getListPriorityName')) {
    function getListPriorityName()
    {
        return [
            '1' => __('Низкий'),
            '2' => __('Средний'),
            '3' => __('Высокий'),
        ];
    }
}

if (!function_exists('getReportPriorityNameById')) {
    function getReportPriorityNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getListPriorityName()[$id];
    }
}

if (!function_exists('getReportStatuses')) {
    function getReportStatuses()
    {
        return [
            '1' => __('В ожидании'),
            '2' => __('Подтверждено'),
            '3' => __('Недействительный/дубликат'),
            '4' => __('Тестирование'),
            '5' => __('Исправлено'),
        ];
    }
}

if (!function_exists('getReportStatusNameById')) {
    function getReportStatusNameById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getReportStatuses()[$id];
    }
}

if (!function_exists('getRoadmapCategories')) {
    function getRoadmapCategories()
    {
        return [
            '1' => __('Concept'),
            '2' => __('Under Development'),
            '3' => __('Testing'),
            '4' => __('Released'),
        ];
    }
}

if (!function_exists('getRoadmapCategoryById')) {
    function getRoadmapCategoryById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getRoadmapCategories()[$id];
    }
}

if (!function_exists('getRoadmapGroups')) {
    function getRoadmapGroups()
    {
        return [
            '1' => __('Заклинания'),
            '2' => __('Глифы'),
            '3' => __('Таланты'),
            '4' => __('Маунты'),
            '5' => __('Предметы'),
            '6' => __('Квесты'),
            '7' => __('Объекты'),
            '8' => __('Существа'),
            '9' => __('Мировые боссы'),
            '10' => __('Инстансы, подземелья и рейды'),
            '11' => __('Поля сражений / Арены'),
            '12' => __('Достижения'),
            '13' => __('Карты'),
            '14' => __('Веб-сайт'),
            '15' => __('Драгоценные камни'),
            '16' => __('Питомцы'),
            '17' => __('Безопасность'),
            '18' => __('Профессии'),
            '19' => __('Клиент'),
            '20' => __('Геймплей'),
        ];
    }
}

if (!function_exists('getRoadmapGroupById')) {
    function getRoadmapGroupById($id)
    {
        if ($id <= 0) return __('Не определён');
        return getRoadmapGroups()[$id];
    }
}

if (!function_exists('getReportStatusIconById')) {
    function getReportStatusIconById($id)
    {
        switch ($id) {
            case 1:
                $icon = 'time-icon';
                break;
            case 2:
                $icon = 'check-icon';
                break;
            case 3:
                $icon = 'forbidden-icon';
                break;
            case 4:
                $icon = 'lightning-icon';
                break;
            case 5:
                $icon = 'key-icon';
                break;
            default:
                $icon = '';
        }
        return $icon;
    }
}

if (!function_exists('getReportStatusClassById')) {
    function getReportStatusClassById($id)
    {
        switch ($id) {
            case 1:
                $class = 'pending';
                break;
            case 2:
                $class = 'confirmed';
                break;
            case 3:
                $class = 'invalid';
                break;
            case 4:
                $class = 'testing';
                break;
            case 5:
                $class = 'fixed';
                break;
            default:
                $class = '';
        }
        return $class;
    }
}

if (!function_exists('getTicketStatuses')) {
    function getTicketStatuses()
    {
        return [
            '1' => __('В ожидании'),
            '2' => __('Игрок ответил'),
            '3' => __('Ответ персонала'),
            '4' => __('Закрыто'),
            '5' => __('Решено'),
        ];
    }
}

if (!function_exists('getTicketStatusNameById')) {
    function getTicketStatusNameById($id)
    {
        $statuses = getTicketStatuses();
        if (isset($statuses[$id])) {
            return $statuses[$id];
        }

        return __('Не определён');
    }
}

if (!function_exists('getReleaseNotesCategories')) {
    function getReleaseNotesCategories()
    {
        return [
            '1' => __('Core/IDE'),
            '2' => __('Core/Custom'),
            '3' => __('Core/Spells'),
            '4' => __('DB/Items'),
            '5' => __('Other'),
        ];
    }
}

if (!function_exists('getReleaseNotesCategory')) {
    function getReleaseNotesCategory($id)
    {
        $status = getReleaseNotesCategories();
        if (!isset($status[$id])) {
            return __('Не определён');
        }
        return $status[$id];
    }
}


if (!function_exists('getListSubcategoryName')) {
    function getListSubcategoryName($category_id=0)
    {
        $subcategories = [];
        if ($category_id == 3) {
            foreach (getListClassesName() as $key => $value) {
                $subcategories[$key] = $value;
            }
        } elseif ($category_id == 5) {
            foreach (getListExploitsName() as $key => $value) {
                $subcategories[$key] = $value;
            }
        } elseif ($category_id == 6) {
            foreach (getListInstancesName() as $key => $value) {
                $subcategories[$key] = $value;
            }
        } elseif ($category_id == 8) {
            foreach (getListOtherName() as $key => $value) {
                $subcategories[$key] = $value;
            }
        } elseif ($category_id == 9) {
            foreach (getListProfessionsName() as $key => $value) {
                $subcategories[$key] = $value;
            }
        } else {
            foreach (getListClassesName() as $key => $value) {
                $subcategories[$key] = $value;
            }
            foreach (getListExploitsName() as $key => $value) {
                $subcategories[$key] = $value;
            }
            foreach (getListInstancesName() as $key => $value) {
                $subcategories[$key] = $value;
            }
            foreach (getListOtherName() as $key => $value) {
                $subcategories[$key] = $value;
            }
            foreach (getListProfessionsName() as $key => $value) {
                $subcategories[$key] = $value;
            }
        }

        return $subcategories;
    }
}

if (!function_exists('getSubcategoryNameById')) {
    function getSubcategoryNameById($id)
    {
        if ($id <= 0) return __('-');
        return getListSubcategoryName()[$id];
    }
}

if (!function_exists('getReferralLvls')) {
    function getReferralLvls()
    {
        return [
            '1' => 10,
            '2' => 20,
            '3' => 30,
            '4' => 40,
            '5' => 50,
            '6' => 60,
            '7' => 70,
            '8' => 80,
            '9' => 90,
            '10' => 100,
        ];
    }
}

if (!function_exists('getReferralLvl')) {
    function getReferralLvl($id)
    {
        $lvls = getReferralLvls();
        return (isset($lvls[$id])) ? $lvls[$id] : 0;
    }
}

if (!function_exists('getReferralByLvl')) {
    function checkReferralByLvl($user_lvl, $user_count)
    {
        $lvls = getReferralLvls();
        foreach ($lvls as $lvl => $lvl_count) {
            if ($user_lvl === $lvl && $user_count > $lvl_count) {
                return TRUE;
            }
        }

        return FALSE;
    }
}
if (!function_exists('getReferralCurrentLvl')) {
    function getReferralCurrentLvl($user_count)
    {
        $lvls = getReferralLvls();
        $user_lvl = 1;
        foreach ($lvls as $lvl => $lvl_count) {
            if ($user_count > $lvl_count) {
                $user_lvl = $lvl;
            }
        }

        return $user_lvl;
    }
}

if (! function_exists('getReferralCountUsers')) {
    function getReferralCountUsers($user_id) {
        $referral = \App\Models\Referral::query()->where('user_id', $user_id)->first();
        if ($referral) {
            return $referral->total;
        }
        return 0;
    }
}


if (!function_exists('getGameCharacter')) {
    function getGameCharacter($char_id)
    {
        return GameServer::getGameCharacter($char_id);
    }
}

if (!function_exists('getGameCharacterInventory')) {
    function getGameCharacterInventory($char_id)
    {
        return GameServer::getGameCharacterInventory($char_id);
    }
}

if (! function_exists('getlogtypes')) {
    function getlogtypes() {
        return [
            '0' => __('Уведомление'),
            '1' => __('Транзакционные'),
            '2' => __('Безопасность'),
            '3' => __('Login'),
        ];
    }
}

if (! function_exists('getlogtype')) {
    function getlogtype($id) {
        $types = getlogtypes();
        if (isset($types[$id])) return $types[$id];
        return $types[0];
    }
}



if (!function_exists('getmonthname')) {
    function getmonthname($month=1)
    {
        switch ($month) {
            case 1:
                $month_text = __('Январь');
                break;
            case 2:
                $month_text = __('Февраль');
                break;
            case 3:
                $month_text = __('Март');
                break;
            case 4:
                $month_text = __('Апрель');
                break;
            case 5:
                $month_text = __('Май');
                break;
            case 6:
                $month_text = __('Июнь');
                break;
            case 7:
                $month_text = __('Июль');
                break;
            case 8:
                $month_text = __('Август');
                break;
            case 9:
                $month_text = __('Сентябрь');
                break;
            case 10:
                $month_text = __('Октябрь');
                break;
            case 11:
                $month_text = __('Ноябрь');
                break;
            case 12:
                $month_text = __('Декабрь');
                break;
            default:
                $month_text = '';
        }
        return $month_text;
    }

    if (!function_exists('generate_guid')) {
        function generate_guid()
        {
            $guid = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
                mt_rand( 0, 0xffff ),
                mt_rand( 0, 0x0fff ) | 0x4000,
                mt_rand( 0, 0x3fff ) | 0x8000,
                mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
            );

            return strtoupper($guid);
        }
    }
}

if (!function_exists('is_active')) {
    function is_active($route)
    {
        return (url()->current() == route($route)) ? 'active' : '';
    }
}

if (!function_exists('paginate')) {
    function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
}

if (!function_exists('getFormatText')) {
    function getFormatText($text)
    {
        $text = strip_tags($text);
        $pattern = '/(http?:\/\/[^\s]+)/i';
        $replacement = '<a href="$1" target="_blank">$1</a>';
        $text = preg_replace($pattern, $replacement, $text);
        $pattern = '/(https?:\/\/[^\s]+)/i';
        $replacement = '<a href="$1" target="_blank">$1</a>';
        $text = preg_replace($pattern, $replacement, $text);

        return $text;
    }
}

if (! function_exists('getRandomAvatar')) {
    function getRandomAvatar() {
        $rnd = rand(1, 8);
        return '/img/bug-tracker/avatar-icon-'.$rnd.'.webp';
    }
}

if (!function_exists('get_image_url')) {
    function get_image_url($image)
    {
        if (str_contains($image, '/storage/')) {
            return $image;
        }
        return '/storage/' . $image;
    }
}
