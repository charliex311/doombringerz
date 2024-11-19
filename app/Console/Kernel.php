<?php

namespace App\Console;

use App\Models\Auction;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\Voting;
use App\Models\UserDelivery;
use App\Models\Characters;
use App\Models\Account;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->call(function () {
            server_rating_cache();
        })->everyThirtyMinutes();

        $schedule->call(function () {
            Cache::forget('forum:posts');
            Cache::rememberForever('forum:posts', function () {
                return DB::connection('xenforo')
                    ->table('thread')
                    ->join('post', 'post.post_id', '=', 'thread.last_post_id')
                    ->select('post.post_id','post.user_id','post.username','thread.last_post_date', 'thread.title', 'thread.thread_id')
                    ->latest('thread.last_post_date')->limit(5)->get();
            });
        })->everyMinute();

        $schedule->call(function () {
            Cache::forget('server:status');
            Cache::rememberForever('server:status', function () {
                $ip = '';
                $port = '';

                $fp = @fsockopen($ip, $port, $errno, $errstr, 1);
                if ($fp) {
                    $pck = pack("vCi", 7, 0, -3);
                    fwrite($fp, $pck);
                    socket_set_timeout($fp, 1);
                    $st = fread($fp, 73);;

                    if ($st) {
                        fclose($fp);
                        $reply = 'Online';
                    } else {
                        $reply = 'Offline';
                    }

                    return $reply;
                }
                return 'Offline';
            });
        })->everyMinute();

        $schedule->call(function () {
            foreach (Auction::where('status', 0)->where('end_at', '<', now())->get() as $lot) {
                if ($lot->latest_id) {
                    $exist_item = Warehouse::where('type', $lot->type)
                        ->where('enchant', $lot->enchant)
                        ->where('bless', $lot->bless)
                        ->where('eroded', $lot->eroded)
                        ->where('ident', $lot->ident)
                        ->where('wished', $lot->wished)
                        ->where('variation_opt1', $lot->variation_opt1)
                        ->where('variation_opt2', $lot->variation_opt2)
                        ->where('intensive_item_type', $lot->intensive_item_type)
                        ->where('user_id', $lot->latest_id)->first();

                    if ($exist_item) {
						// Log::info("[{$lot['latest_id']}] Item: {$lot['name']}");
                        $exist_item->increment('amount', $lot->amount);
                    } else {
                        $warehouse = new Warehouse;
                        $warehouse->user_id = $lot->latest_id;
                        $warehouse->type = $lot->type;
                        $warehouse->amount = $lot->amount;
                        $warehouse->enchant = $lot->enchant;
                        $warehouse->bless = $lot->bless;
                        $warehouse->eroded = $lot->eroded;
                        $warehouse->ident = $lot->ident;
                        $warehouse->wished = $lot->wished;
                        $warehouse->variation_opt1 = $lot->variation_opt1;
                        $warehouse->variation_opt2 = $lot->variation_opt2;
                        $warehouse->intensive_item_type = $lot->intensive_item_type;
                        $warehouse->save();
                    }

                    $sum = $lot->current_bet - $this->percent($lot->current_bet, config('options.auction_percent', 15));
                    User::find($lot->user_id)->increment('balance', $sum);

                    $lot->status = 1;
                    $lot->latest_id = null;
                    $lot->end_at = now();
                    $lot->save();
                } else {
                    $exist_item = Warehouse::where('type', $lot->type)
                        ->where('enchant', $lot->enchant)
                        ->where('bless', $lot->bless)
                        ->where('eroded', $lot->eroded)
                        ->where('ident', $lot->ident)
                        ->where('wished', $lot->wished)
                        ->where('variation_opt1', $lot->variation_opt1)
                        ->where('variation_opt2', $lot->variation_opt2)
                        ->where('intensive_item_type', $lot->intensive_item_type)
                        ->where('user_id', $lot->user_id)->first();

                    if ($exist_item) {
						// Log::info("[null] Item: {$lot['name']}");
                        $exist_item->increment('amount', $lot->amount);
                    } else {
                        $warehouse = new Warehouse;
                        $warehouse->user_id = $lot->user_id;
                        $warehouse->type = $lot->type;
                        $warehouse->amount = $lot->amount;
                        $warehouse->enchant = $lot->enchant;
                        $warehouse->bless = $lot->bless;
                        $warehouse->eroded = $lot->eroded;
                        $warehouse->ident = $lot->ident;
                        $warehouse->wished = $lot->wished;
                        $warehouse->variation_opt1 = $lot->variation_opt1;
                        $warehouse->variation_opt2 = $lot->variation_opt2;
                        $warehouse->intensive_item_type = $lot->intensive_item_type;
                        $warehouse->save();
                    }
                }
				
				$lot->delete();
            }
        })->everyFiveMinutes();
		
		$schedule->call(function () {
			$vote=new Voting;
			$vote->Run();
		});


    }

    protected function percent($number, $percent) {
        return $number / 100 * $percent;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
