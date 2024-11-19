<?php

namespace App\Http\Controllers\Backend;

use App\Models\Option;
use App\Models\Server;
use App\Models\User;
use App\Models\ActivityLog;
use App\Services\Statistics;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:investor');
    }

    /**
     * Index page with form update settings
     */
    public function index() {
        return view('backend.pages.logs.payments');
    }

    public function payments(Request $request, Statistics $statistics) {

        $type = $request->has('type') ? $request->get('type') : 'all';
        $server_id = $request->has('server_id') ? $request->get('server_id') : '1';

        $data = $statistics->getPayments($type, $server_id);

        return view('backend.pages.logs.payments', compact('data'));
    }

    public function visits(Request $request, Statistics $statistics) {

        $type = $request->has('type') ? $request->get('type') : 'all';

        $data = $statistics->getVisits($type);

        return view('backend.pages.logs.visits', compact('data'));
    }

    public function registrations(Request $request, Statistics $statistics) {

        $server_id = $request->has('server_id') ? $request->get('server_id') : '1';

        $data = $statistics->getRegistrations($server_id);

        return view('backend.pages.logs.registrations', compact('data'));
    }

    public function gamecurrencylogs()
    {
        $date = (request()->has('date')) ? request()->query('date') : FALSE;
        $period = (request()->has('period')) ? request()->query('period') : FALSE;
        $search = (request()->has('search')) ? request()->query('search') : FALSE;

        $log = $this->getLog('payments/payments',$search,$period,$date);

        return view('backend.pages.logs.gamecurrencylogs', compact('log'));
    }

    public function adminlogs()
    {
        $date = (request()->has('date')) ? request()->query('date') : FALSE;
        $period = (request()->has('period')) ? request()->query('period') : FALSE;
        $search = (request()->has('search')) ? request()->query('search') : FALSE;

        $log = $this->getLog('admin/admin',$search,$period,$date);

        return view('backend.pages.logs.adminlogs', compact('log'));
    }

    public function servererrors()
    {
        $date = (request()->has('date')) ? request()->query('date') : FALSE;
        $period = (request()->has('period')) ? request()->query('period') : FALSE;
        $search = (request()->has('search')) ? request()->query('search') : FALSE;

        $log = $this->getLog('laravel/laravel',$search,$period,$date);

        return view('backend.pages.logs.servererrors', compact('log'));
    }

    public function enchantitemlogs()
    {
        $date = (request()->has('date')) ? request()->query('date') : FALSE;
        $period = (request()->has('period')) ? request()->query('period') : FALSE;
        $search = (request()->has('search')) ? request()->query('search') : FALSE;

        $log = $this->getLog('gamelogs/enchantitem0',$search,$period,$date);

        return view('backend.pages.logs.enchantitemlogs', compact('log'));
    }
    public function item_lcoinlogs()
    {
        $date = (request()->has('date')) ? request()->query('date') : FALSE;
        $period = (request()->has('period')) ? request()->query('period') : FALSE;
        $search = (request()->has('search')) ? request()->query('search') : FALSE;

        $log = $this->getLog('gamelogs/item_lcoin_0',$search,$period,$date);

        return view('backend.pages.logs.item_lcoinlogs', compact('log'));
    }
    public function itemlogs()
    {
        $date = (request()->has('date')) ? request()->query('date') : FALSE;
        $period = (request()->has('period')) ? request()->query('period') : FALSE;
        $search = (request()->has('search')) ? request()->query('search') : FALSE;

        $log = $this->getLog('gamelogs/item0',$search,$period,$date);

        return view('backend.pages.logs.itemlogs', compact('log'));
    }

    public function userlogs(User $user) {

        $admin_log = '';
        for ($i = 0; $i < 365; $i++) {
            $date = date('d.m.Y', strtotime(date('d.m.Y')) - 60 * 60 * 24 * $i);
            if (Storage::disk('local')->exists('logs/admin/admin_' . $date . '.log')) {
                $log = Storage::disk('local')->get('logs/admin/admin_' . $date . '.log');
                $log_lines = explode("\n", $log);
                if (!empty($log_lines[1])) {
                    foreach ($log_lines as $line) {
                        if (strpos($line, $user->name) !== FALSE) {
                            $admin_log .= $line . "\n";
                        }
                    }
                }

            } else {
                $admin_log .= '';
            }
        }

        $payments_log = '';
        for ($i = 0; $i < 365; $i++) {
            $date = date('d.m.Y', strtotime(date('d.m.Y')) - 60 * 60 * 24 * $i);
            if (Storage::disk('local')->exists('logs/payments/payments_' . $date . '.log')) {
                $log = Storage::disk('local')->get('logs/payments/payments_' . $date . '.log');
                $log_lines = explode("\n", $log);
                if (!empty($log_lines[1])) {
                    foreach ($log_lines as $line) {
                        if (strpos($line, $user->name) !== FALSE || strpos($line, "Игроку ID: {$user->id}") !== FALSE  || strpos($line, '"user_id":'.$user->id) !== FALSE) {
                            $payments_log .= $line . "\n";
                        }
                    }
                }

            } else {
                $payments_log .= '';
            }
        }

        return view('backend.pages.logs.userlogs', compact('admin_log', 'payments_log'));
    }

    public function activitylogs(Request $request)
    {
        $logs = ActivityLog::where('is_admin', 1);

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $logs->where('message', 'LIKE', "%{$search}%");
        }

        $logs = $logs->latest()->paginate();

        return view('backend.pages.logs.activitylogs', compact('logs'));
    }

    public function statistics_game_items(Request $request, Statistics $statistics) {

        $type = $request->has('type') ? $request->get('type') : 'all';
        $server_id = $request->has('server_id') ? $request->get('server_id') : '1';
        $item_id = $request->has('item_id') ? $request->get('item_id') : '57';

        $data = $statistics->getItems($type, $server_id, $item_id);

        return view('backend.pages.logs.statistics_game_items', compact('data'));
    }

    private function getLog($log_name,$search=FALSE,$period=FALSE,$date=FALSE)
    {
        $log = '';

        //Если есть поиск, то ищем по логам за последние 30 дней
        if ($search && $search != '') {

            $log_search = '';
            for ($i = 0; $i < 30; $i++) {
                $date = date('d.m.Y', strtotime(date('d.m.Y')) - 60 * 60 * 24 * $i);
                if (Storage::disk('local')->exists('logs/'.$log_name.'_' . $date . '.log')) {
                    $log = Storage::disk('local')->get('logs/'.$log_name.'_' . $date . '.log');
                    $log_lines = explode("\n", $log);
                    if (!empty($log_lines[1])) {
                        foreach ($log_lines as $line) {
                            if (strpos($line, $search) !== FALSE) {
                                $log_search .= $line . "\n";
                            }
                        }
                    }

                } else {
                    $log_search .= '';
                }
            }

            $log = $log_search;

        }
        else {

            if ($period && $period == 'week') {

                for ($i = 0; $i < 7; $i++) {
                    $date = date('d.m.Y', strtotime(date('d.m.Y')) - 60 * 60 * 24 * $i);
                    if (Storage::disk('local')->exists('logs/'.$log_name.'_' . $date . '.log')) {
                        $log .= Storage::disk('local')->get('logs/'.$log_name.'_' . $date . '.log');
                    } else {
                        $log .= '';
                    }
                }

            } else {

                if ($date) {
                    $date = date('d.m.Y', strtotime($date));
                } else {
                    $date = date('d.m.Y');
                }
                if (Storage::disk('local')->exists('logs/'.$log_name.'_' . $date . '.log')) {
                    $log = Storage::disk('local')->get('logs/'.$log_name.'_' . $date . '.log');
                } else {
                    $log = '';
                }

            }

        }

        return $log;
    }

}
