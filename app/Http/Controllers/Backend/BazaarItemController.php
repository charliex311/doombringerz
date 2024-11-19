<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\BazaarItemRequest;
use App\Models\BazaarItem;
use App\Models\LineageItem;
use App\Models\Warehouse;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class BazaarItemController extends Controller
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
        $bazaaritems = BazaarItem::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $bazaaritems->where('title_', 'LIKE', "%{$search}%");
        }

        $bazaaritems = $bazaaritems->latest()->paginate();

        return view('backend.pages.bazaar.index', compact('bazaaritems'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BazaarItem $bazaaritem)
    {

        if (GameServer::transferItemGameServer($bazaaritem->character_id, $bazaaritem->amount, $bazaaritem->type)) {

            Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Removed the lot from the Marketplace. Lot ID: {$bazaaritem->id}, item type: {$bazaaritem->type}, quantity: {$bazaaritem->amount}, price: {$bazaaritem->price}, sale type: {$bazaaritem->sale_type}, seller ID: {$bazaaritem->user_id}.");
            $bazaaritem->delete();
            $this->alert('success', __('Лот успешно удален'));
        }

        $this->alert('danger', __('Ошибка! Лот не удален!'));

        return redirect()->route('bazaaritems.index');
    }
}