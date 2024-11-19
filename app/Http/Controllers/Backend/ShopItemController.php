<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ShopItemRequest;
use App\Models\ShopItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ShopItemController extends Controller
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
    public function index(Request $request)
    {
        $shopitems = ShopItem::query();

        $category_id = $request->has('cat') ? $request->get('cat') : '0';

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $shopitems->where('title_'.app()->getLocale(), 'LIKE', "%{$search}%");
        }

        if ($category_id > 0) {
            $shopitems->where('category_id', $category_id);
        }

        $shopitems = $shopitems->latest()->paginate();

        return view('backend.pages.shop.index', compact('shopitems','category_id'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.shop.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopItemRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['image'] = $request->image->store('images', 'public');
        $this->alert('success', __('Предмет успешно добавлен'));

        $data['togethers'] = json_encode($request->togethers);

        ShopItem::create($data);
        return redirect()->route('shopitems.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShopItem $shopitem)
    {
        return view('backend.pages.shop.form', compact('shopitem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopItemRequest $request, ShopItem $shopitem): RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['image'])) {
            Storage::disk('public')->delete($shopitem->image);
            $data['image'] = $request->image->store('images', 'public');
        }

        $data['togethers'] = json_encode($request->togethers);

        $shopitem->update($data);

        $this->alert('success', __('Предмет успешно обновлен'));
        return redirect()->route('shopitems.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShopItem $shopitem)
    {
        $this->alert('success', __('Предмет успешно удален'));
        if ($shopitem->image !== NULL) {
            Storage::disk('public')->delete($shopitem->image);
        }
        $shopitem->delete();
        return redirect()->route('shopitems.index');
    }

    public function getProductByName(Request $request)
    {
        $products = ShopItem::where('title_' . app()->getLocale(), 'LIKE', "%{$request->product_name}%")->get();

        return response()->json([
            'status' => 'success',
            'products' => $products,
        ]);
    }
}
