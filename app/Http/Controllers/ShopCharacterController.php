<?php

namespace App\Http\Controllers;

use App\Lib\GameServer;
use App\Models\Account;
use App\Models\Characters;
use App\Models\ShopCharacter;
use App\Models\User;
use App\Http\Requests\ShopCharacterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use SoapClient;

class ShopCharacterController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index(Request $request) {

        if (config('options.shops_status', '0') != '1' && auth()->user()->role != 'admin') {
            return redirect()->route('index');
        }

        $shopcharacters = ShopCharacter::query();

        if (request()->has('class_id') && request()->query('class_id') > 0) {
            $shopcharacters->where('class_id', request()->query('class_id'));
        }
        if (request()->has('race_id') && request()->query('race_id') > 0) {
            $shopcharacters->where('race_id', request()->query('race_id'));
        }
        if (request()->has('gender') && request()->query('gender') > 0) {
            $shopcharacters->where('gender', request()->query('gender'));
        }
        if (request()->has('lvl') && request()->query('lvl') > 0) {
            if (request()->query('lvl') == 1) {
                $shopcharacters->whereBetween('lvl', [0, 109]);
            } elseif (request()->query('lvl') == 2) {
                $shopcharacters->where('lvl', 110);
            }

        }

        $shopcharacters = $shopcharacters->latest()->paginate();

        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        return view('pages.cabinet.shop_characters', compact('shopcharacters', 'characters'));
    }

    public function buy(Request $request)
    {

        $shopcharacter = ShopCharacter::where('uuid', $request->post('item_uuid'))->first();

        if ($shopcharacter && $shopcharacter->price > 0 && $shopcharacter->price <= auth()->user()->balance) {
            $user_sale = User::find($shopcharacter->user_id);
            if ($user_sale && GameServer::unlockGameCharacter($shopcharacter->char_id, auth()->user()->wow_id)) {
                $shopcharacter->forceDelete();
                if ($shopcharacter->image) {
                    Storage::disk('public')->delete($shopcharacter->image);
                }

                auth()->user()->decrement('balance', $shopcharacter->price);
                $user_sale->balance += $shopcharacter->price;
                $user_sale->save();

                $this->alert('success', __('Персонаж успешно куплен!'));
                return back();
            }
        }

        $this->alert('danger', __('Ошибка! Не удалось купить персонажа! Попробуйте позже.'));
        return back();

    }

    public function store(ShopCharacterRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['price'] = abs($request->input('price'));
        $data['char_id'] = intval($request->input('char_id'));

        if ($data['price'] <= 0 || $data['char_id'] <=0 || !GameServer::checkGameCharacter($data['char_id'], auth()->user()->wow_id))  {
            $this->alert('danger', __('Ошибка! Не удалось выставить персонажа на продажу! Попробуйте позже.'));
            return back();
        }

        if (isset($data['image'])) {
            $data['image'] = $request->image->store('images', 'public');
        }

        if (GameServer::lockGameCharacter($data['char_id'])) {
            $shopcharacter = new ShopCharacter;
            $shopcharacter->fill($data);
            $shopcharacter->uuid = Str::uuid();
            $shopcharacter->account_id = auth()->user()->wow_id;
            $shopcharacter->user_id = auth()->user()->id;
            $shopcharacter->save();

            $this->alert('success', __('Вы успешно выставили персонажа на продажу!'));
            return back();
        }

        $this->alert('danger', __('Ошибка! Не удалось выставить персонажа на продажу! Попробуйте позже.'));
        return back();
    }

    public function show($character)
    {
        $shopcharacter = ShopCharacter::where('uuid', $character)->first();
        $character = GameServer::getGameCharacter($shopcharacter->char_id);

        if (!$character) {
            abort(404);
        }

        return view('pages.cabinet.shop_characters.full', compact('shopcharacter', 'character'));
    }

    public function destroy($character)
    {

        $shopcharacter = ShopCharacter::where('uuid', $character)->first();

        if ($shopcharacter && $shopcharacter->user_id == auth()->id()) {
            if (GameServer::unlockGameCharacter($shopcharacter->char_id, $shopcharacter->account_id)) {
                $shopcharacter->forceDelete();
                if ($shopcharacter->image) {
                    Storage::disk('public')->delete($shopcharacter->image);
                }

                $this->alert('success', __('Вы успешно отменили продажу персонажа!'));
                return back();
            }
        }

        $this->alert('danger', __('Ошибка! Не удалось отменить продажу персонажа! Попробуйте позже.'));
        return back();

    }

}
