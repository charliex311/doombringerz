<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use App\Models\Account;
use App\Models\Warehouse;
use App\Models\User;
use App\Models\ShopItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use GameServer;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('server.status');
    }

    public function index()
    {
        $characters = [];
        $characters_count = 0;
        $account = Account::where('user_id', auth()->id())->latest()->first();
        if ($account) {
            $characters = GameServer::getCharacters($account->id, session('server_id'));
            $characters_count = count($characters);
        }
        $warehouse_count = Warehouse::where('user_id', auth()->id())->count();

        return view('pages.cabinet.promocodes', compact('characters',  'characters_count', 'warehouse_count'));
    }

    public function check(Request $request)
    {
        $code = strval($request->input('code'));
        $promocode_code = PromoCode::where('code', $code)->first();
        if (!$promocode_code) {
            return response()->json([
                'status' => 'error',
                'msg' => __('Код не найден!'),
            ]);
        }
        $promocode = PromoCode::where('code', $code)
            ->where('date_start', '<', date('Y-m-d H:i:s'))
            ->where('date_end', '>', date('Y-m-d H:i:s'))
            ->first();
        if (!$promocode) {
            return response()->json([
                'status' => 'error',
                'msg' => __('Срок кода истек!'),
            ]);
        }

        //type=0 - Personal, type=1 - Public, type=2 - One time use
        if ($promocode->type == 0) {

            if ($promocode->user_id != auth()->user()->id) {
                return response()->json([
                    'status' => 'error',
                    'msg' => __('Код не распространяется на вас!'),
                ]);
            }

        } elseif ($promocode->type == 2) {

            $used_users = json_decode($promocode->users);
            if ($used_users !== NULL || !empty($used_users)) {
                return response()->json([
                    'status' => 'error',
                    'msg'    => __('Код не распространяется на вас!'),
                ]);
            }

        } else {

            //type_restriction=0 - 1 per MA, type=1 - 1 per Character
            if ($promocode->type_restriction == 0) {

                $used_users = json_decode($promocode->users);
                if ($used_users !== NULL || !empty($used_users)) {
                    foreach ($used_users as $used_user) {
                        if ($used_user->user_id == auth()->user()->id) {
                            return response()->json([
                                'status' => 'error',
                                'msg'    => __('Код не распространяется на вас!'),
                            ]);
                        }
                    }
                }
            }

        }

        $msg = '';
        if ($promocode->items !== NULL) {
            $items = json_decode($promocode->items);
            $msg .= '<span class="bonuslist-title">' . __('Вы получите Бонусные предметы:') . '</span>';
            foreach ($items as $item) {
                $msg .= '<span class="bonuslist-item">';
                /*
                if (strpos(getitem($item->id)->icon0, '.png')) {
                    $msg .= '<img src="/storage/' . getitem($item->id)->icon0 . '" style="width: 32px;"/> ';
                } else {
                    $shop_item = ShopItem::where('wow_id', $item->id)->first();
                    if ($shop_item) {
                        $msg .= '<img src="' . $shop_item->image_url . '"/> ';
                    } else {
                        $msg .= '<img src="/images/items/' . getitem($item->id)->icon0 . '.png"/> ';
                    }
                }
                */
                $msg .= $item->name . ' ' . __('в количестве') . ' ' . $item->amount . ' ' . __('шт.');
                $msg .= '</span>';
            }
        }

        $request->session()->put('promocode', $promocode->code);

        return response()->json([
            'status' => 'success',
            'msg' => $msg,
            'type' => $promocode->type_restriction,
        ]);
    }

    public function apply(Request $request)
    {
        if (session()->has('promocode')) {
            $code = session('promocode');
        } else {
            $code = strval($request->input('code'));
        }
        $account_id = 0;
        $char_id = 0;
        $character = FALSE;

        //Записываем блок в кеш
        $lock = Cache::lock('spin_lw' . auth()->id() . '_lock', 5);
        if ($lock->get()) {

            $promocode_code = PromoCode::where('code', $code)->first();
            if (!$promocode_code) {
                $this->alert('danger', __('Код не найден!'));
                return back();
            }
            $promocode = PromoCode::where('code', $code)
                ->where('date_start', '<', date('Y-m-d H:i:s'))
                ->where('date_end', '>', date('Y-m-d H:i:s'))
                ->first();
            if (!$promocode) {
                $this->alert('danger', __('Срок кода истек!'));
                return back();
            }


            //type_restriction=0 - 1 per MA, type=1 - 1 per Character
            if ($promocode->type == 0) {
                if ($promocode->user_id != auth()->user()->id) {
                    $this->alert('danger', __('Код не распространяется на вас!'));
                    return back();
                }

                //type_restriction=0 - 1 per MA, type=1 - 1 per Character
                if ($promocode->type_restriction == 0) {

                    $used_users = json_decode($promocode->users);
                    if ($used_users !== NULL || !empty($used_users)) {
                        foreach ($used_users as $used_user) {
                            if ($used_user->user_id == auth()->user()->id) {
                                $this->alert('danger', __('Код не распространяется на вас!'));
                                return back();
                            }
                        }
                    }

                } else {

                    $char_id = ($request->has('char_id')) ? intval($request->input('char_id')) : 0;
                    if ($char_id <= 0) {
                        $this->alert('danger', __('Для активации Промокода необходимо выбрать персонажа!'));
                        return back();
                    }

                    $character = GameServer::getCharacter($char_id);
                    $account = Account::where('user_id', auth()->id())->where('server', session('server_id'))->where('account_id', $character->account_id)->first();

                    if (!$account) {
                        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                        return back();
                    }
                    $account_id = $account->account_id;

                    $used_users = json_decode($promocode->users);

                    if ($used_users !== NULL || !empty($used_users)) {
                        foreach ($used_users as $used_user) {
                            if ($used_user->user_id == auth()->user()->id) {
                                if (!empty($used_user->accounts) && in_array($account_id, $used_user->accounts)) {
                                    $this->alert('danger', __('Вы уже использовали этот Промокод для этого Игрового Аккаунта! Попробуйте выбрать другого персонажа.'));
                                    return back();
                                }
                            }
                        }
                    }
                }

            } elseif ($promocode->type == 2) {

                $used_users = json_decode($promocode->users);
                if ($used_users !== NULL || !empty($used_users)) {
                    return response()->json([
                        'status' => 'error',
                        'msg'    => __('Код не распространяется на вас!'),
                    ]);
                }

            } else {

                //type_restriction=0 - 1 per MA, type=1 - 1 per Character
                if ($promocode->type_restriction == 0) {

                    $used_users = json_decode($promocode->users);
                    if ($used_users !== NULL || !empty($used_users)) {
                        foreach ($used_users as $used_user) {
                            if ($used_user->user_id == auth()->user()->id) {
                                $this->alert('danger', __('Код не распространяется на вас!'));
                                return back();
                            }
                        }
                    }

                } else {

                    $char_id = ($request->has('char_id')) ? intval($request->input('char_id')) : 0;
                    if ($char_id <= 0) {
                        $this->alert('danger', __('Для активации Промокода необходимо выбрать персонажа!'));
                        return back();
                    }

                    $character = GameServer::getCharacter($char_id);
                    if (!$character) {
                        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                        return back();
                    }
                    $account = Account::where('user_id', auth()->id())->where('server', session('server_id'))->where('account_id', $character->account_id)->first();

                    if (!$account) {
                        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                        return back();
                    }
                    $account_id = $account->account_id;

                    $used_users = json_decode($promocode->users);

                    if ($used_users !== NULL || !empty($used_users)) {
                        foreach ($used_users as $used_user) {
                            if ($used_user->user_id == auth()->user()->id) {
                                if (!empty($used_user->accounts) && in_array($account_id, $used_user->accounts)) {
                                    $this->alert('danger', __('Вы уже использовали этот Промокод для этого Игрового Аккаунта! Попробуйте выбрать другого персонажа.'));
                                    return back();
                                }
                            }
                        }
                    }

                }
            }

            //Сохраняем в промокод данные об активации
            $used_users_new = array();
            if ($promocode->items !== NULL) {
                $user_id = auth()->user()->id;
                $used_users = json_decode($promocode->users);

                if ($used_users === NULL || empty($used_users)) {
                    $accounts[] = $account_id;
                    $used_users_new[] = [
                        'user_id'  => auth()->user()->id,
                        'accounts' => $accounts,
                    ];
                } else {
                    $user_find = FALSE;
                    foreach ($used_users as $used_user) {
                        if ($used_user->user_id == auth()->user()->id) {
                            $user_find = TRUE;
                            $accounts = $used_user->accounts;
                            $accounts[] = $account_id;
                            $used_users_new[] = [
                                'user_id'  => auth()->user()->id,
                                'accounts' => $accounts,
                            ];
                        } else {
                            $used_users_new[] = $used_user;
                        }
                    }

                    if ($user_find === FALSE) {
                        $accounts[] = $account_id;
                        $used_users_new[] = [
                            'user_id'  => auth()->user()->id,
                            'accounts' => $accounts,
                        ];
                    }
                }
            }

            $promocode->users = json_encode($used_users_new);
            $promocode->save();

            //Выдаем пользователю награду
            if ($promocode->items !== NULL) {
                $items = json_decode($promocode->items);
                if (!empty($items)) {
                    foreach ($items as $item) {

                        if ($promocode->type_restriction == 0) {

                            $exist_item = Warehouse::where('type', $item->id)
                                ->where('user_id', auth()->id())
                                ->where('server', session('server_id'))
                                ->first();

                            if ($exist_item) {
                                $exist_item->increment('amount', abs(intval($item->amount)));
                            } else {
                                $warehouse = new Warehouse;
                                $warehouse->type = $item->id;
                                $warehouse->amount = abs(intval($item->amount));
                                $warehouse->item_name = $item->name;
                                $warehouse->user_id = auth()->id();
                                $warehouse->server = session('server_id');
                                $warehouse->save();
                            }

                            Log::channel('paymentslog')->info('Робот: Игрок ' . auth()->user()->name . ' (' . auth()->user()->email . ') ' . ' успешно активировал Промокод ' . $promocode->code . ' и получил Бонусный предмет ' . $item->name . ' в кол-ве ' . abs(intval($item->amount)) . ' на склад МА');

                        } else {

                            if ($char_id > 0) {

                                $warehouse = new Warehouse;
                                $warehouse->type = $item->id;
                                $warehouse->amount = abs(intval($item->amount));
                                $warehouse->enchant = 0;
                                $warehouse->bless = 0;
                                $warehouse->eroded = 0;
                                $warehouse->ident = 0;
                                $warehouse->wished = 0;
                                $warehouse->variation_opt1 = 0;
                                $warehouse->variation_opt2 = 0;
                                $warehouse->intensive_item_type = 0;
                                $warehouse->hLocked = 0;
                                $warehouse->use_count = 0;
                                $warehouse->bless_option = 0;
                                $warehouse->item_name = $item->name;
                                $warehouse->item_desc = '';
                                $warehouse->user_id = auth()->id();
                                $warehouse->server = session('server_id');

                                if (GameServer::transferItemGameServer($char_id, $character, abs(intval($item->amount)), $warehouse)) {
                                    Log::channel('paymentslog')->info('Робот: Игрок ' . auth()->user()->name . ' (' . auth()->user()->email . ') ' . ' успешно активировал Промокод и получил Бонусный предмет' . $item->name . ' в кол-ве ' . abs(intval($item->amount)) . ' в инвентарь персонажа ' . (isset($character->char_name) ? $character->char_name : ''));
                                }
                            }

                        }
                    }
                }

            }

            $lock->release();

            $this->alert('success', __('Код успешно активирован!') . ' ' . __('Проверьте свой склад в Личном Кабинете или инвентарь персонажа.'));
            return back();
        }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }

}
