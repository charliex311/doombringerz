<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\BonusitemsRequest;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\LineageItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class BonusitemsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:admin');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.pages.bonusitems.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BonusitemsRequest $request): RedirectResponse
    {
        $lineageItem = LineageItem::find($request->item_id);
        if (!$lineageItem) {
            $this->alert('danger', __('Бонусный предмет не найден!'));
            return redirect()->route('backend.bonusitems');
        }

        if($request->type == '1') {
            //Else select 1 MA
            $this->transferItemWarehouse($request->user_id, $request->item_id, $request->amount, $request->server_id);

        } else {
            //Else select all MA
            $users = User::get();
            foreach ($users as $user) {
                dd($user);
                $this->transferItemWarehouse($user->id, $request->item_id, $request->amount, $request->server_id);
            }
        }

        $this->alert('success', __('Бонусный предмет успешно выдан.'));

        return redirect()->route('backend.bonusitems');
    }

    private function transferItemWarehouse($user_id, $item_id, $amount, $server_id)
    {
        $exist_item = Warehouse::where('type', $item_id)
            ->where('enchant', 0)
            ->where('bless', 0)
            ->where('eroded', 0)
            ->where('ident', 0)
            ->where('wished', 0)
            ->where('variation_opt1', 0)
            ->where('variation_opt2', 0)
            ->where('intensive_item_type', 0)
            ->where('user_id', $user_id)
            ->where('server', $server_id)
            ->first();

        if ($exist_item) {
            $exist_item->increment('amount', $amount);
        } else {
            $warehouse = new Warehouse;
            $warehouse->type = $item_id;
            $warehouse->amount = $amount;
            $warehouse->enchant = 0;
            $warehouse->bless = 0;
            $warehouse->eroded = 0;
            $warehouse->ident = 0;
            $warehouse->wished = 0;
            $warehouse->variation_opt1 = 0;
            $warehouse->variation_opt2 = 0;
            $warehouse->intensive_item_type = 0;
            $warehouse->user_id = $user_id;
            $warehouse->server = $server_id;
            $warehouse->save();
        }

        return TRUE;
    }

}
