<?php

namespace App\Services;


use App\Models\Option;
use App\Models\Server;
use App\Models\Visit;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Statistics
{

    public function __construct()
    {

    }

    public function getPayments($type='all', $server_id='1')
    {

        switch ($type) {
            case 'day':
                $date_sql = date('Y-m-d') . ' 00:00:00';
                break;
            case 'week':
                $day_week = date("N");
                $week_start = date('d.m.Y', strtotime("-" . $day_week . " day", strtotime(date('Y-m-d'))));
                $date_sql = date('Y-m-d', strtotime($week_start)) . ' 00:00:00';
                break;
            case 'month':
                $date_sql = date('Y-m') . '-01' . ' 00:00:00';
                break;
            case 'all':
                $date_sql = '2000-01-01 00:00:00';
                break;
        }

        if ($server_id === '') {
            $results = DB::table('donates')->select('amount', 'coins', 'donates.status', 'payment_system', 'donates.created_at as created_at', 'servers.name as server_name', 'users.name as name', 'donates.char_name as char_name')
                ->leftJoin('users', 'users.id', '=', 'donates.user_id')
                ->leftJoin('servers', 'servers.id', '=', 'donates.server')
                ->where('donates.created_at', '>', $date_sql)
                ->orderBy('donates.created_at')
                ->get();
        } else {
            $results = DB::table('donates')->select('amount', 'coins', 'donates.status', 'payment_system', 'donates.created_at as created_at', 'servers.name as server_name', 'users.name as name', 'donates.char_name as char_name')
                ->leftJoin('users', 'users.id', '=', 'donates.user_id')
                ->leftJoin('servers', 'servers.id', '=', 'donates.server')
                ->where('donates.created_at', '>', $date_sql)
                ->where('donates.server', $server_id)
                ->orderBy('donates.created_at')
                ->get();
        }

        $results = $results->sortByDesc('created_at');

        $servers = Server::all();

        $transactions = $results;

        $payments = array();
        $total_amount = 0;
        $total_count = 0;
        foreach ($results as $result) {
            if ($result->status == 0) continue;
            $total_count++;
            $total_amount += $result->amount;
            $date = date('d.m', strtotime($result->created_at));
            $date_find = false;
            $payments_index = -1;
            foreach ($payments as $payment){
                $payments_index++;
                if ($payment["date"] == $date) {
                    $payments[$payments_index]["amount"] += $result->amount;
                    $date_find = true;
                    break;
                }
            }
            if ($date_find !== true) {
                $payments[] = array(
                    "date" => $date,
                    "amount" => $result->amount,
                );
            }
        }

        $data = array(
            "payments" => $payments,
            "total_amount" => $total_amount,
            "total_count" => $total_count,
            "transactions" => $transactions,
            "type" => $type,
            "server_id" => $server_id,
            "servers" => $servers,
        );

        return $data;
    }

    public function getVisits($type='all')
    {

        switch ($type) {
            case 'day':
                $date_sql = date('Y-m-d') . ' 00:00:00';
                break;
            case 'week':
                $day_week = date("N");
                $week_start = date('d.m.Y', strtotime("-" . $day_week . " day", strtotime(date('Y-m-d'))));
                $date_sql = date('Y-m-d', strtotime($week_start)) . ' 00:00:00';
                break;
            case 'month':
                $date_sql = date('Y-m') . '-01' . ' 00:00:00';
                break;
            case 'all':
                $date_sql = '2000-01-01 00:00:00';
                break;
        }

        $results = DB::table('visits')->select('ip', 'router', 'created_at')
            ->where('created_at', '>', $date_sql)
            ->orderBy('created_at')
            ->get();

        $visitors = array();
        $ips = array();
        $total_visitors = 0;
        foreach ($results as $result) {
            $date = date('d.m', strtotime($result->created_at));
            $date_i = str_replace(".", "", $date);
            $date_find = false;
            $visitors_index = -1;
            foreach ($visitors as $visitor){
                $visitors_index++;
                if ($visitor["date"] == $date) {
                    $date_find = true;
                    if (isset($ips[$date_i]) && !in_array($result->ip, $ips[$date_i]) ) {
                        $total_visitors ++;
                        $visitors[$visitors_index]["count"]++;
                        $ips[$date_i][] = $result->ip;
                        break;
                    }
                }
            }
            if ($date_find !== true) {
                $total_visitors ++;
                $ips[$date_i][] = $result->ip;
                $visitors[] = array(
                    "date" => $date,
                    "count" => 1,
                );
            }
        }

        $visits = array();
        foreach ($results as $result) {
            $date = date('d.m', strtotime($result->created_at));
            $date_find = false;
            $visits_index = -1;
            foreach ($visits as $visit){
                $visits_index++;
                if ($visit["date"] == $date) {
                    $visits[$visits_index]["count"] ++;
                    $date_find = true;
                    break;
                }
            }
            if ($date_find !== true) {
                $visits[] = array(
                    "date" => $date,
                    "count" => 1,
                );
            }
        }

        $data = array(
            "visits" => $visits,
            "visitors" => $visitors,
            "total_visits" => count($results),
            "total_visitors" => $total_visitors,
            "type" => $type,
        );

        return $data;
    }

    public function getRegistrations($server_id='1')
    {

        $results_users = DB::table('users')->select('id', 'created_at')
            ->orderBy('created_at')
            ->get();

        if ($server_id === '') {
            $results_accounts = DB::table('accounts')->select('id', 'created_at')
                ->orderBy('created_at')
                ->get();
        } else {
            $results_accounts = DB::table('accounts')->select('id', 'created_at')
                ->where('server', $server_id)
                ->orderBy('created_at')
                ->get();
        }

        $servers = Server::all();

        //Получаем пользователей
        $users = array();
        $total_users_count = count($results_users);
        foreach ($results_users as $result) {
            $date = date('d.m', strtotime($result->created_at));
            $date_find = false;
            $results_users_index = -1;
            foreach ($users as $user){
                $results_users_index++;
                if ($user["date"] == $date) {
                    $users[$results_users_index]["count"]++;
                    $date_find = true;
                    break;
                }
            }
            if ($date_find !== true) {
                $users[] = array(
                    "date" => $date,
                    "count" => 1,
                );
            }
        }

        //Получаем аккаунты
        $accounts = array();
        $total_accounts_count = count($results_accounts);
        foreach ($results_accounts as $result) {
            $date = date('d.m', strtotime($result->created_at));
            $date_find = false;
            $results_accounts_index = -1;
            foreach ($accounts as $account){
                $results_accounts_index++;
                if ($account["date"] == $date) {
                    $accounts[$results_accounts_index]["count"]++;
                    $date_find = true;
                    break;
                }
            }
            if ($date_find !== true) {
                $accounts[] = array(
                    "date" => $date,
                    "count" => 1,
                );
            }
        }

        $data = array(
            "users"                => $users,
            "total_users_count"    => $total_users_count,
            "accounts"             => $accounts,
            "total_accounts_count" => $total_accounts_count,
            "server_id"            => $server_id,
            "servers"              => $servers,
        );

        return $data;
    }

    public function getItems($type='all', $server_id='1', $item_id='1')
    {

        switch ($type) {
            case 'day':
                $date_sql = date('Y-m-d') . ' 00:00:00';
                break;
            case 'week':
                $day_week = date("N");
                $week_start = date('d.m.Y', strtotime("-" . $day_week . " day", strtotime(date('Y-m-d'))));
                $date_sql = date('Y-m-d', strtotime($week_start)) . ' 00:00:00';
                break;
            case 'month':
                $date_sql = date('Y-m') . '-01' . ' 00:00:00';
                break;
            case 'all':
                $date_sql = '2000-01-01 00:00:00';
                break;
        }

        $results = DB::table('statistics_game_items')->select('item_id', 'server_id', 'amount', 'difference', 'statistics_game_items.created_at as created_at', 'servers.name as server_name')
            ->leftJoin('servers', 'servers.id', '=', 'statistics_game_items.server_id')
            ->where('statistics_game_items.created_at', '>', $date_sql)
            ->where('statistics_game_items.server_id', $server_id)
            ->where('statistics_game_items.item_id', $item_id)
            ->orderBy('statistics_game_items.created_at')
            ->get();

        $servers = Server::all();

        $transactions = $results->sortByDesc('created_at');

        $amounts = array();
        $total_amount = 0;
        $total_count = 0;
        foreach ($results as $result) {
            $total_count++;
            $total_amount += $result->amount;
            $date = date('H:00 d.m', strtotime($result->created_at));
            $date_find = false;
            $amounts_index = -1;

            foreach ($amounts as $amount) {
                $amounts_index++;
                if ($amount["date"] == $date) {
                    $amounts[$amounts_index]["amount"] += $result->amount;
                    $date_find = TRUE;
                    break;
                }
            }


            if ($date_find !== true) {
                $total_amount = $result->amount;
                if ($result->amount > 1000000000) {
                    $result_amount = number_format($result->amount / 1000000000, 2);
                } else {
                    $result_amount = $result->amount;
                }
                $amounts[] = array(
                    "date" => $date,
                    "amount" => $result_amount,
                );
            }
        }

        $amount_unit = __('шт.');
        if ($total_amount > 1000000000) {
            $total_amount = number_format($total_amount / 1000000000, 2);
            $amount_unit = __('млн шт.');
        }

        $data = array(
            "amounts" => $amounts,
            "total_amount" => $total_amount,
            "total_count" => $total_count,
            "transactions" => $transactions,
            "type" => $type,
            "item_id" => $item_id,
            "server_id" => $server_id,
            "servers" => $servers,
            "amount_unit" => $amount_unit,
        );

        return $data;
    }

}