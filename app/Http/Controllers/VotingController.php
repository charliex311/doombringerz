<?php

namespace App\Http\Controllers;

use App\Lib\CacheD;
use App\Models\Account;
use App\Models\Characters;
use App\Models\Inventory;
use App\Models\Warehouse;
use App\Models\Voting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use GameServer;

class VotingController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index()
    {
        $votings = [];
        foreach (getvoting_platforms() as $voting_platform) {
            if (config('options.voting_'.$voting_platform['name'].'_link', '') != '') {
                $user_voting = Voting::where('user_id', auth()->user()->id)->where('vote_system', $voting_platform['name'])->first();
                if ($user_voting) {
                    $voting_platform['status'] = $user_voting->status;
                    $voting_platform['amount'] = $user_voting->amount;
                    $voting_platform['updated_at'] = $user_voting->updated_at;
                } else {
                    $voting_platform['status'] = '0';
                    $voting_platform['amount'] = '-';
                    $voting_platform['updated_at'] = '';
                }

                $votings[] = (object)$voting_platform;
            }
        }

        //Проверяем, есть ли пользователь с таким же HWID (определяем по игровому аккаунту)
        $hwid = FALSE;
        $vote_enabled = TRUE;
        $accounts = Account::where('user_id', auth()->user()->id)->get();

        if ($accounts) {
            foreach ($accounts as $account) {
                $hwid_acc = GameServer::getAccountHWID($account->login);
                if ($hwid_acc) {
                    $hwid = $hwid_acc;
                }
            }
        }

        if (!$hwid) {
            $this->alert('danger', __('Произошла ошибка! Выполните один раз вход на сервер, чтобы получить возможность голосовать.'));
            $vote_enabled = FALSE;
        }


        $bonus_item = getitem(config('options.voting_item_id', '1'));
        $bonus_final_item = getitem(config('options.voting_finish_item_id', '1'));

        return view('pages.cabinet.voting', compact('votings', 'bonus_item', 'bonus_final_item'));
    }

    public function redirect(Request $request, $voting_name)
    {

        //Проверяем, есть ли пользователь с таким же HWID (определяем по игровому аккаунту)
        $accounts = Account::where('user_id', auth()->user()->id)->get();

        $hwid = FALSE;
        foreach ($accounts as $account) {
            $hwid_acc = GameServer::getAccountHWID($account->login);
            if ($hwid_acc) {
                $hwid = $hwid_acc;
            }
        }

        if (!$hwid) {
            $this->alert('danger', __('Произошла ошибка! Выполните один раз вход на сервер, чтобы получить возможность голосовать.'));
            return back();
        }

        //Ищем голоса с тем же hwid, чтобы не абузили на голосовалке
        if (Voting::where('hwid', $hwid)->where('vote_system', $voting_name)->where('status', '2')->where('user_id', '!=', auth()->user()->id)->first()) {
            $this->alert('danger', __('Произошла ошибка! Вы уже голосовали на данной площадке с другого Мастер Аккаунта. Если вы не голосовали, обратитесь к администратору.'));
            return back();
        }

        $voting = Voting::where('user_id', auth()->user()->id)->where('vote_system', $voting_name)->first();
        if ($voting) {
            if ($voting->status == 0 || $voting->status == 1) {

                //Отодвигаем время изменения, чтобы не включалась блокировка на 12 часов
                $date = strtotime(date('Y-m-d H:i:s'));
                $date_str = $date - 60 * 60 * 14;
                $date = date('Y-m-d H:i:s', $date_str);
                $voting->updated_at = $date;

                $voting->ip = \Request::ip();
                $voting->hwid = $hwid;
                $voting->status = 1;
                $voting->save();

            } else {
                $this->alert('danger', __('Вы уже проголосавили на этой площадке! Вы не можете голосовать повторно!'));
                return back();
            }
        } else {
            $voting = new Voting;
            $voting->user_id = auth()->user()->id;
            $voting->ip = \Request::ip();
            $voting->vote_system = $voting_name;
            $voting->hwid = $hwid;
            $voting->status = 1;
            $voting->amount = 0;
            $voting->save();
        }

        $link = config('options.'.$voting_name.'_link', '#');
        $link = str_replace('%IP%', \Request::ip(), $link);
        return Redirect::to($link);
    }

}
