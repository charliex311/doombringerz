<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatisticsGameItem;
use GameServer;

class StatisticsGameItemController extends Controller
{
    public function getStatistic(Request $request)
    {
        if (!$request->has('token') || $request->token != '6ljnd6uu3nan1wxg1qqt') die('error');

        $server_id = ($request->has('server_id')) ? $request->server_id : 1;

        for($it=0;$it<100;$it++){
            $item_id = config('options.statistics_game_item_'.$it.'_id', 0);
            if ($item_id != 0){
                $game_items_amount = GameServer::getItemsAmount($item_id);

                $statistics_game_item_last = StatisticsGameItem::where('item_id', $item_id)->latest()->first();
                if (!$statistics_game_item_last) {
                    $amount_last = 0;
                } else {
                    $amount_last = $statistics_game_item_last->amount;
                }
                $difference = $game_items_amount - $amount_last;
                $statistics_game_item = new StatisticsGameItem;
                $statistics_game_item->item_id = $item_id;
                $statistics_game_item->server_id = $server_id;
                $statistics_game_item->amount = $game_items_amount;
                $statistics_game_item->difference = $difference;
                $statistics_game_item->save();
            }
        }
    }

    public function getStatisticTest(Request $request)
    {
        if (!$request->has('token') || $request->token != '6ljnd6uu3nan1wxg1qqt') die('error');

        $item_id = '93629';
        $game_items_amount = GameServer::getItemsAmount($item_id);

    }

}
