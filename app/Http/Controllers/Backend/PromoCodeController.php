<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\PromoCodeRequest;
use App\Http\Requests\PromoCodeGenerateRequest;
use App\Models\PromoCode;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PromoCodeController extends Controller
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
        $promocodes = PromoCode::query();

        $search = request()->query('search');
        if (request()->has('search') && is_string($search)) {
            $promocodes->where('code', 'LIKE', "%{$search}%");
        }
        $date = date('Y-m-d H:i', strtotime(date('Y-m-d H:i:s')) - 60*60*24 );
        //$promocodes->where('type', '!=', 2)->orWhere('type', 2);
        $promocodes->where('type', '!=', 2)->orWhere(function ($query) use($date) {
            $query->where('type', 2)
                ->where('updated_at', '>', $date);
        });
        $promocodes = $promocodes->latest()->paginate();

        return view('backend.pages.promocodes.index', compact('promocodes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.pages.promocodes.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PromoCodeRequest $request): RedirectResponse
    {
        //Заглушка
        $data = $request->validated();

        $items = [];
        for ($i=1;$i<50;$i++) {
            $item_id = 'item_'.$i.'_id';
            $item_name = 'item_'.$i.'_name';
            $item_amount = 'item_'.$i.'_amount';
            if ($request->has($item_id)) {
                $items[] = [
                    "id" => $request->input($item_id),
                    "name" => $request->input($item_name),
                    "amount" => $request->input($item_amount),
                ];
            }
        }
        $data['items'] = json_encode($items);

        PromoCode::create($data);

        $this->alert('success', __('Промокод успешно добавлен'));
        return redirect()->route('promocodes.index');
    }

    public function generate()
    {
        return view('backend.pages.promocodes.generate');
    }

    public function generate_store(PromoCodeGenerateRequest $request)
    {

        //Заглушка
        $this->alert('success', __('Промокоды успешно добавлены'));
        return redirect()->route('promocodes.index');

        //Собираем бонусные предметы, они одинаковые для всех промокодов
        $items = [];
        for($i=1;$i<50;$i++) {
            $item_id = 'item_'.$i.'_id';
            $item_name = 'item_'.$i.'_name';
            $item_amount = 'item_'.$i.'_amount';
            if($request->has($item_id)) {

                //Checking, that the bonus item is in the item DB
                if (!getitem($request->input($item_id))) {
                    $this->alert('danger', __('Неверный ID предмета!') . 'ID:' . $request->input($item_id));
                    return back();
                }

                $items[] = [
                    "id" => $request->input($item_id),
                    "name" => $request->input($item_name),
                    "amount" => $request->input($item_amount),
                ];
            }
        }
        $items_json = json_encode($items);

        if ($request->has('amount')) {
            for($a=0; $a<$request->amount; $a++) {
                $data = [
                    'title' => $request->title,
                    'code' => generationPromoCode(),
                    'type' => 2,
                    'type_restriction' => 0,
                    'user_id' => NULL,
                    'users' => NULL,
                    'date_start' => $request->date_start,
                    'date_end' => $request->date_end,
                    'items' => $items_json,
                ];
                PromoCode::create($data);
            }
        }

        $this->alert('success', __('Промокоды успешно добавлены'));

        return redirect()->route('promocodes.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PromoCode $promocode)
    {
        return view('backend.pages.promocodes.form', compact('promocode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromoCodeRequest $request, PromoCode $promocode): RedirectResponse
    {
        $data = $request->validated();

        $items = [];
        for($i=1;$i<50;$i++) {
            $item_id = 'item_'.$i.'_id';
            $item_name = 'item_'.$i.'_name';
            $item_amount = 'item_'.$i.'_amount';
            if($request->has($item_id)) {

                //Checking, that the bonus item is in the item DB
                if (!getitem($request->input($item_id))) {
                    $this->alert('danger', __('Неверный ID предмета!') . 'ID:' . $request->input($item_id));
                    return back();
                }

                $items[] = [
                    "id" => $request->input($item_id),
                    "name" => $request->input($item_name),
                    "amount" => $request->input($item_amount),
                ];
            }
        }
        $data['items'] = json_encode($items);

        $promocode->update($data);

        $this->alert('success', __('Промокод успешно обновлен'));
        return redirect()->route('promocodes.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PromoCode $promocode)
    {
        $promocode->delete();

        $this->alert('success', __('Промокод успешно удален'));
        return redirect()->route('promocodes.index');
    }
}