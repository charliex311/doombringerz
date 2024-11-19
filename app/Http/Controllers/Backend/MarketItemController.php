<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\MarketItemRequest;
use App\Models\MarketItem;
use App\Models\LineageItem;
use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MarketItemController extends Controller
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
        $marketitems = MarketItem::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $marketitems->where('title_', 'LIKE', "%{$search}%");
        }

        $marketitems = $marketitems->latest()->paginate();

        return view('backend.pages.market.index', compact('marketitems'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarketItem $marketitem)
    {
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Removed the lot from the Marketplace. Lot ID: {$marketitem->id}, item type: {$marketitem->type}, quantity: {$marketitem->amount}, price: {$marketitem->price}, sale type: {$marketitem->sale_type}, seller ID: {$marketitem->user_id}.");

        $item = Warehouse::where('user_id', $marketitem->user_id)
            ->where('type', $marketitem->type)
            ->where('server', $marketitem->server)
            ->where('enchant', $marketitem->enchant)
            ->where('bless', $marketitem->bless)
            ->where('eroded', $marketitem->eroded)
            ->where('ident', $marketitem->ident)
            ->where('variation_opt1', $marketitem->variation_opt1)
            ->where('variation_opt2', $marketitem->variation_opt2)
            ->where('intensive_item_type', $marketitem->intensive_item_type)
            ->first();

        if ($item) {
            $item->increment('amount', $marketitem->amount);
        } else {
            $warehouse = new Warehouse;
            $warehouse->user_id = $marketitem->user_id;
            $warehouse->type = $marketitem->type;
            $warehouse->amount = $marketitem->amount;
            $warehouse->enchant = $marketitem->enchant;
            $warehouse->bless = $marketitem->bless;
            $warehouse->eroded = $marketitem->eroded;
            $warehouse->ident = $marketitem->ident;
            $warehouse->wished = $marketitem->wished;
            $warehouse->variation_opt1 = $marketitem->variation_opt1;
            $warehouse->variation_opt2 = $marketitem->variation_opt2;
            $warehouse->intensive_item_type = $marketitem->intensive_item_type;
            $warehouse->server = session('server_id');
            $warehouse->save();
        }

        $marketitem->delete();

        $this->alert('success', __('Лот успешно удален'));
        return redirect()->route('marketitems.index');
    }
}