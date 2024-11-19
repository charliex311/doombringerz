<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use danog\MadelineProto\auth;
use danog\MadelineProto\users;
use Illuminate\Http\Request;
use App\Models\Donate;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\LWSpin;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use function Amp\Dns\query;

class LuckywheelController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {
        $items = [];
        for ($i = 0; $i < 1000; $i++) {
            if (config('options.lwitem_' . $i . '_image', '') !== '') {
                $items[] = [
                    'id'     => config('options.lwitem_' . $i . '_id'),
                    'name'   => config('options.lwitem_' . $i . '_name'),
                    'chance' => config('options.lwitem_' . $i . '_chance'),
                    'image'  => '/storage/' . config('options.lwitem_' . $i . '_image', ''),
                ];
            }
        }

        $free_spin = LWSpin::query()->where('user_id', auth()->id())->whereDate('date', now())->doesntExist();

        return view('pages.cabinet.luckywheel.index', compact('items', 'free_spin'));
    }

    public function getLuckyWheelItems(Request $request)
    {
        $items = [];
        for ($i = 0; $i < 1000; $i++) {
            if (config('options.lwitem_' . $i . '_image', '') !== '') {
                $items[] = [
                    'id'     => config('options.lwitem_' . $i . '_id'),
                    'name'   => config('options.lwitem_' . $i . '_name'),
                    'chance' => config('options.lwitem_' . $i . '_chance'),
                    'icon'   => '/storage/' . config('options.lwitem_' . $i . '_image', ''),
                ];
            }
        }

        $data = [];
        $data['items'] = $items;
        return json_encode($data);
    }

    public function getUserBalance(Request $request)
    {
        return response()->json([
            'status'  => 'success',
            'balance' => auth()->user()->balance,
        ]);
    }

    public function getRewardLuckyWheelItem(Request $request)
    {
        //Записываем блок в кеш
        $lock = Cache::lock('spin_lw' . auth()->id() . '_lock', 5);
        if ($lock->get()) {

            //Проверяем, что есть бесплатное открытие
            $lw_spin = LWSpin::query()->where('user_id', auth()->id())->where('date', date('Y-m-d'))->first();

            if (auth()->user()->balance < config('options.lwitems_cost', '1') && $lw_spin) {
                return json_encode(__('Недостаточно средств на балансе мастер-аккаунта'));
            } else {

                $items = [];
                for ($i = 0; $i < 1000; $i++) {
                    if (config('options.lwitem_' . $i . '_image', '') !== '') {
                        $items[] = [
                            'id'     => config('options.lwitem_' . $i . '_id'),
                            'name'   => config('options.lwitem_' . $i . '_name'),
                            'chance' => config('options.lwitem_' . $i . '_chance'),
                            'icon'   => '/storage/' . config('options.lwitem_' . $i . '_image', ''),
                        ];
                    }
                }

                $win_items = [];
                foreach ($items as $item) {
                    if ($item['chance'] == 100) {
                        $win_items[] = [
                            'id'     => $item['id'],
                            'name'   => $item['name'],
                            'chance' => $item['chance'],
                            'icon'   => $item['icon'],
                        ];
                        break;
                    }
                    if (rand(1, 100) < config('options.lwitem_' . $i . '_chance', 0)) {
                        $win_items[] = [
                            'id'     => $item['id'],
                            'name'   => $item['name'],
                            'chance' => $item['chance'],
                            'icon'   => $item['icon'],
                        ];
                    }
                }
                if (count($win_items) > 0) {
                    $r = rand(0, count($win_items) - 1);
                    $item_id = $win_items[$r]['id'];
                } else {
                    $r = rand(0, count($items) - 1);
                    $item_id = $items[$r]['id'];
                }

                //Проверяем, что есть бесплатное открытие
                if (!$lw_spin) {
                    LWSpin::create([
                        'user_id' => auth()->id(),
                        'item_id' => $item_id,
                        'date'    => date('Y-m-d'),
                    ]);
                    $this->activityLog(1, ' successfully Free spin Lucky Wheel and win ItemID: ' . $item_id . '.');
                    Log::channel('paymentslog')->info('Robot: Player ' . auth()->user()->name . ' (' . auth()->user()->email . ') ' . ' successfully Free spin Lucky Wheel and win ItemID: ' . $item_id . '.');
                } else {
                    $this->costLuckyWheelItem();
                    $this->activityLog(1, ' successfully Payed spin Lucky Wheel and win ItemID: ' . $item_id . '.');
                    Log::channel('paymentslog')->info('Robot: Player ' . auth()->user()->name . ' (' . auth()->user()->email . ') ' . ' successfully Payed spin Lucky Wheel and win ItemID: ' . $item_id . '.');
                }

                $this->storeLuckyWheelItem($item_id);

                $lock->release();
                return json_encode($item_id);
            }
        }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }


    private function storeLuckyWheelItem($item_id)
    {
        $warehouse = new Warehouse;

        $warehouse->type = $item_id;
        $warehouse->user_id = auth()->id();
        $warehouse->amount = 1;
        $warehouse->server = 1;
        $warehouse->save();

        return json_encode('success');
    }

    private function costLuckyWheelItem()
    {
        auth()->user()->decrement('balance', config('options.lwitems_cost', '1'));

        return json_encode('success');
    }
}
