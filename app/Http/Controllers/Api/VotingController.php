<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonateController;
use http\Env\Response;
use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use App\Models\Account;
use App\Models\Voting;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use App\Lib\GameServer;

class VotingController extends Controller
{

    public function checkRewards(Request $request, DonateController $donateController)
    {
        if (!$request->has('token') || $request->token != 'nhe102j2maxukz8j7ehn') die('error');

        $votings = Voting::where('status', '1')->get();

        foreach ($votings as $voting) {
            //if($voting->user_id != 497) continue;
            if (config('options.voting_'.$voting->vote_system.'_link', '') == '') continue;

            //Ищем голоса с тем же hwid, чтобы не абузили на голосовалке
            if (Voting::where('hwid', $voting->hwid)->where('vote_system', $voting->vote_system)->where('status', '2')->first()) {
                continue;
            }

            $link = config('options.voting_'.$voting->vote_system.'_link', '');
            $apikey = config('options.voting_'.$voting->vote_system.'_apikey', '');
            $vote_id = $this->check($voting->vote_system, $voting->ip, $link, $apikey);

            if ($vote_id) {

                $item_id = config('options.voting_item_id', '1');
                $item_amount = config('options.voting_item_amount', '1');
                $user_id = $voting->user_id;

                $voting->vote_id = $vote_id;
                $voting->status = 2; //Success
                $voting->amount += abs($item_amount);
                $voting->save();

                $this->transfer_item($item_id, $item_amount, $user_id, $server = 1);

                Log::channel('paymentslog')->info("Робот: Игроку ID: " . $user_id . " успешно начислена награда (предмет ID: " . $item_id . " в кол-ве " . $item_amount . " шт.) за голосование на " . $voting->vote_system);

                //Проверяем и выдаем финишную награду
                $user_votings_count = Voting::where('user_id', $user_id)->where('status', '2')->count();
                if ($user_votings_count == count(getvoting_platforms())) {

                    $finish_item_id = config('options.voting_finish_item_id', '1');
                    $finish_item_amount = config('options.voting_finish_item_amount', '1');
                    $this->transfer_item($finish_item_id, $finish_item_amount, $user_id, $server = 1);

                    Log::channel('paymentslog')->info("Робот: Игроку ID: " . $user_id . " успешно начислена финишная награда (предмет ID: " . $finish_item_id . " в кол-ве " . $finish_item_amount . " шт.) за голосование на " . $voting->vote_system);
                }
            }
        }

        die('ok');
    }

    public function resetVotes(Request $request, DonateController $donateController)
    {
        if (!$request->has('token') || $request->token != 'nhe102j2maxukz8j7ehn') die('error');

        $votings = Voting::get();

        foreach ($votings as $voting) {
            //if($voting->user_id != 497) continue;

            if (config('options.voting_' . $voting->vote_system . '_link', '') == '') continue;

            $date = strtotime(date('Y-m-d H:i:s'));
            $date_12h = strtotime($voting->updated_at) + 60*60*12;

            if ($date > $date_12h)  {

                $date_str = $date - 60*60*14;
                $date = date('Y-m-d H:i:s', $date_str);

                $voting->status = 0; //Не проголосовано
                $voting->updated_at = $date;
                $voting->save();

            }

        }

        die('ok');
    }

    private function check($type, $ip, $link, $apikey)
    {
        $voting_url = str_replace('%API%', $apikey, $link);
        $voting_url = str_replace('%IP%', $ip, $voting_url);
        //dd($voting_url);

        $voting = new Voting;

        switch ($type) {
            case 'mmotop':

                $ch = curl_init();
                $optArray = array(
                    CURLOPT_URL            => $voting_url,
                    CURLOPT_RETURNTRANSFER => TRUE,
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                );
                curl_setopt_array($ch, $optArray);
                $result = curl_exec($ch);

                if (curl_errno($ch) !== 0) return "⛔️ Не могу получить данные с MMOTOP: " . curl_errno($ch);
                curl_close($ch);
                $lines = explode("\n", $result);
                for ($i = 0; $i < count($lines); $i++) {
                    if (strlen($lines[$i]) < 10) continue;
                    $arr = explode("	", $lines[$i]);
                    if (count($arr) !== 5) continue;
                    list($vote_id, $vote_dt, $vote_ip, $vote_nick, $vote_amount) = $arr;

                    if (isset($vote_id) && isset($vote_ip) && $ip == $vote_ip) {
                        return $vote_id;
                    }
                }

                break;

            case 'hopezone':

                $client = new Client();
                $response = $client->request('GET', $voting_url, [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);
                $result = json_decode($response->getBody()->getContents());

                if (isset($result->voted) && $result->voted == true) {
                    return generationVoteID();
                }

                return FALSE;

            case 'l2brasil':

                $client = new Client();
                $response = $client->request('GET', $voting_url, [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);
                $result = json_decode($response->getBody()->getContents());

                if (isset($result->vote) && isset($result->vote->status) && $result->vote->status == 1) {
                    return $result->vote->id;
                }

                return FALSE;

            case 'l2jtop':

                $client = new Client();
                $response = $client->request('GET', $voting_url, [
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);
                $result = json_decode($response->getBody()->getContents());

                if (isset($result->result) && isset($result->result->is_voted) && $result->result->is_voted == true) {
                    return generationVoteID();
                }

                return FALSE;

            case 'l2network':

                $type = 1;

                $data = array(
                    'apiKey'  => $apikey,
                    'type'    => '2', //Проверка по ip пользователя (вместо id я записывают ip)
                    'player'  => $ip
                );

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, 'https://l2network.eu/api.php');
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
                curl_setopt($ch, CURLOPT_HEADER, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data, '', '&'));

                $result = curl_exec($ch);
                curl_close($ch);

                if (isset($result) && $result > 1) {
                    return generationVoteID();
                }

                return FALSE;

            default:
                return FALSE;
        }

        return TRUE;
    }

    private function transfer_item($item_id, $item_amount, $user_id, $server=1)
    {
        //Проверяю, если товар уже есть, то добавляем к нему количество
        $warehouse = Warehouse::where('type', $item_id)->where('user_id', $user_id)->where('server', $server)->first();

        if ($warehouse) {
            $warehouse->amount += $item_amount;
            $warehouse->save();
        } else {

            //Заносим товары на склад
            $warehouse = new Warehouse;
            $warehouse->type = $item_id;
            $warehouse->user_id = $user_id;
            $warehouse->amount = $item_amount;
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
