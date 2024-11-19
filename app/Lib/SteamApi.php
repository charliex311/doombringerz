<?php
namespace App\Lib;

use App\Models\Account;
use App\Models\Characters;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Auction;
use App\Models\UserDelivery;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use vendor\steamauth\LightOpenID;
use GuzzleHttp\Client;


class SteamApi
{

    private static $api_url = 'https://steamcommunity.com/market/search/render/';

    public static function login()
    {

        $dir = base_path() . '/vendor/steamauth/';
        require $dir . 'LightOpenID.php';

        $openid = new LightOpenID(config('app.url', ''));

        if(!$openid->mode) {
            $openid->identity = 'https://steamcommunity.com/openid';

            return (object)[
                'status' => 'success',
                'data' => $openid->authUrl(),
            ];
        } elseif ($openid->mode == 'cancel') {
            return (object)[
                'status' => 'error',
                'data' => 'User has canceled authentication!',
            ];
        } else {
            if($openid->validate()) {
                $id = $openid->identity;
                $ptn = "/^https?:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);

                $steamid = $matches[1];
                return (object)[
                    'status' => 'success',
                    'data' => $steamid,
                ];
                return $steamid;
            } else {
                return (object)[
                    'status' => 'error',
                    'data' => 'User is not logged in.',
                ];
            }
        }

    }

    public static function getUserInfo($steamid)
    {
        $url = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=".config('options.steam_api_key', '')."&steamids=".$steamid);
        $content = json_decode($url, true);
        if (isset($content['response']['players'][0])) {
            return (object)[
                'status' => 'success',
                'data' => (object)$content['response']['players'][0],
            ];
        }
        return (object)[
            'status' => 'error',
            'data' => 'User not find.',
        ];

   }

    public static function logout()
    {
        session_unset();
        session_destroy();
    }

    public static function getSteamItems($game)
    {
        $items = [];
        $limit = 100;
        for($page = 0; $page < 400; $page++) {
            $start = $limit * $page;
            Log::channel('skinsback')->info("page:".$page);

            //Cache::forget('getSteamItems:'.$game.'page' . $page);
            $items_page = Cache::remember('getSteamItems:'.$game.'page' . $page, '86400', function () use($game, $start, $limit) {
                Log::channel('skinsback')->info("get start:".$start);
                try {
                    $client = new Client();
                    $response = $client->request('GET', self::$api_url . '?appid='.$game.'&norender=1&count='.$limit.'&start='.$start);
                    $data = json_decode($response->getBody()->getContents(), TRUE);
                    if ($data['success'] === TRUE) {
                        $its = [];
                        foreach ($data['results'] as $item) {
                            $its[] = [
                                'name' => $item['name'],
                                'classid' => $item['asset_description']['classid'],
                                'icon_url' => $item['asset_description']['icon_url'],
                                'type' => $item['asset_description']['type'],
                                'price' => $item['sell_price_text'],
                            ];
                        }
                        return $its;
                    }
                } catch (\Exception $ex) {
                    return FALSE;
                }

                return [];
            });

            //Проверяем, что результат из кеш функции не пустой
            if (!is_array($items_page)) {
                Cache::forget('getSteamItems:'.$game.'page' . $page);
                break;
            } else {
                $items = array_merge($items, $items_page);
            }
        }

        return $items;
    }

}
