<?php

namespace App\Http\Controllers;

use App\Lib\GameServer;
use App\Models\Account;
use App\Models\Characters;
use App\Models\ShopItem;
use App\Models\ShopCoupon;
use App\Models\ShopCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use SoapClient;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    public function index(Request $request) {

        $category_id = $request->has('category_id') ? $request->get('category_id') : '0';
        if ($category_id == 0) {
            foreach(getmainshopcategories() as $category) {
                $category_id = $category->id;
                break;
            }
        }

        $child_id = $request->has('child_id') ? $request->get('child_id') : '0';
        $server_id = $request->has('server_id') ? $request->get('server_id') : '1';

        $shopitems = ShopItem::query();

        //We do a search in all categories, if there is no search, then we display the result by category
        $search = $request->has('search') ? $request->get('search') : '';
        if ($search != '') {
            $shopitems->where('title_'.app()->getLocale(), 'LIKE', "%{$search}%");
        } else {
            if ($category_id > 0) {
                if (childshopcategories_count($category_id) > 0) {
                    $category_ids = getchildshopcategories($category_id)->pluck('id');
                    $shopitems->whereIn('category_id', $category_ids);
                } else {
                    $shopitems->where('category_id', $category_id);
                }
            }
        }
        if (auth()->user() !== NULL && auth()->user()->role == 'admin') {
            //
        } else {
            $shopitems->where('status', '1');
        }
        $shopitems->latest('updated_at');
        $total_shopitems = $shopitems->count();
        $shopitems = $shopitems->get();

        $shopitems_popular = ShopItem::orderBy(DB::raw('RAND()'))->take(3)->get();

        $cart = $this->get_cart($request);

        return view('pages.cabinet.shop.list', compact('shopitems', 'shopitems_popular', 'category_id', 'cart', 'total_shopitems', 'server_id', 'child_id'));
    }

    public function show($shopitem, Request $request)
    {
        $server_id = $request->has('server_id') ? $request->get('server_id') : '1';
        $shopitem = ShopItem::where('id', $shopitem)->first();
        if (!$shopitem) {
            abort(404);
        }

        $related_shopitems = ShopItem::where('category_id', $shopitem->category_id)->inRandomOrder()->limit(3)->get();

        $category = ShopCategory::where('id', $shopitem->category_id)->first();
        if (!$category) {
            $category = [];
        }

        $cart = $this->get_cart($request);

        //Получаем товары, которые покупают вместе для последнего товара в корзине
        $togethers = [];
        $shopitem_togethers = (isset($shopitem) && $shopitem->togethers !== NULL) ? json_decode($shopitem->togethers) : [];
        foreach ($shopitem_togethers as $shopitem_together_id) {
            $shopitem_t = ShopItem::find($shopitem_together_id);
            if ($shopitem_t) {
                $togethers[] = $shopitem_t;
            }
        }

        return view('pages.cabinet.shop.full', compact('shopitem', 'related_shopitems', 'cart', 'server_id', 'category', 'togethers'));
    }

    public function checkout(Request $request) {

        if (auth()->user()->wow_id != 0) {
            $characters = GameServer::getGameCharacters(auth()->user()->wow_id);
        } else {
            $characters = [];
        }

        $cart = $this->get_cart($request);
        if ($cart['total']['amount'] == 0) return Redirect::to(route('shop'));

        return view('pages.cabinet.shop.checkout', compact('characters', 'cart'));
    }

    public function complete(Request $request)
    {

        //Записываем блок в кеш
        $lock = Cache::lock('checkout_complete' . auth()->id() . '_lock', 5);
        if ($lock->get()) {

            $cart = $this->get_cart($request);
            if ($cart['total']['amount'] <= 0) return Redirect::to(route('shop'));

            if (auth()->user()->balance < $cart['total']['amount']) {
                $this->alert('danger', __('У вас не достаточно монет на балансе!'));
                return back();
            }

            $shopitem = ShopItem::find($request->post('item_id'));

            /*
            $character = GameServer::getGameCharacter($request->post('character_guid'));
            if ($character) {
                if (auth()->user()->balance < $shopitem->price) {
                    $this->alert('danger', __('Недостаточно') . ' ' . config('options.coin_name', 'CoL') . ' ' . __('на балансе!'));
                } else {

                    // send to wow
                    $soapurl = config('options.soap_url', '#');
                    $soap = new \SoapClient(NULL, array(
                        'location'   => $soapurl,
                        'uri'        => 'urn:TC',
                        'style'      => SOAP_RPC,
                        'login'      => config('options.soap_login', ''),
                        'password'   => config('options.soap_password', ''),
                        'keep_alive' => FALSE //keep_alive only works in php 5.4.
                    ));

                    $count = 1;
                    $itemSend = $shopitem->wow_id;

                    if ($shopitem->category_id == 1) {
                        $command = "send item " . $character->name . " \"WM: Donation Items\" \"Thank you for your support!\" " . $itemSend . ":" . $count;
                    } elseif ($shopitem->category_id == 2) {
                        $command = "send money " . $character->name . " \"WM: Donation Gold\" \"Thank you for your support!\" " . $count;
                    } elseif ($shopitem->category_id == 3) {
                        $command = "character rename " . $character->name;
                    } elseif ($shopitem->category_id == 4) {
                        $command = "character changefaction " . $character->name;
                    } elseif ($shopitem->category_id == 5) {
                        $command = "character changerace " . $character->name;
                    } elseif ($shopitem->category_id == 6) {
                        $command = "character customize " . $character->name;
                    }

                    //$result = $soap->executeCommand(new \SoapParam($command, "command"));

                    // end send to wow



                    auth()->user()->decrement('balance', $shopitem->price);
                    $this->alert('success', __('Предмет успешно куплен!'));

                    return back();
                }

            } else {
                $this->alert('danger', __('Персонаж с таким именем не найден! Обратитесь к администратору.'));
            }

            */

            auth()->user()->decrement('balance', abs($cart['total']['amount']));

            //We white, that the user used this coupon
            if ($request->session()->has('coupon_code')) {
                $coupon = ShopCoupon::where('code', $request->session()->get('coupon_code'))->first();
                if ($coupon) {
                    $used_users = json_decode($coupon->users);
                    if ($used_users === NULL) $used_users = array();
                    $used_users[] = auth()->user()->id;
                    $users = json_encode($used_users);
                    $coupon->users = $users;
                    $coupon->save();
                }
            }

            $request->session()->forget('cart');
            $request->session()->forget('coupon_discount');
            $request->session()->forget('coupon_code');

            foreach ($cart['cart'] as $item) {
                Log::channel('paymentslog')->info('Robot: Player ' . auth()->user()->name . ' (' . auth()->user()->email . ') ' . ' successfully bought in the store Product: ' . $item['title'] . ' in quantity ' . $item['qty'] . ' by price ' . $item['price']);
                $this->activityLog(1, 'successfully bought in the store Product: ' . $item['title'] . ' in quantity ' . $item['qty'] . ' by price ' . $item['price']);
            }

            $this->alert('success', __('Заказ успешно оформлен!'));

            $lock->release();

            return Redirect::to(route('shop.cart.success'));
        }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }

    public function success(Request $request) {

        $cart = $this->get_cart($request);
        return view('pages.cabinet.shop.success', compact('cart'));
    }

    public function add_cart(Request $request)
    {
        $item_id = $request->input('item_id');
        $server_id = $request->input('server_id');
        $shopitem = ShopItem::where('id', $item_id)->first();
        if (!$shopitem) {
            return back();
        }

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
        } else {
            $cart = array();
        }

        if (!empty($cart)) {
            $cart_item_find = FALSE;
            $i = -1;
            foreach ($cart as $cart_item) {
                $i++;
                if ($cart_item['id'] == $item_id) {
                    $cart[$i]['qty'] ++;
                    $cart_item_find = TRUE;
                }
            }
            if ($cart_item_find !== TRUE) {
                $cart[] = array(
                    'id' => $item_id,
                    'qty' => 1,
                    'server_id' => $server_id,
                );
            }
        } else {
            $cart[] = array(
                'id' => $item_id,
                'qty' => 1,
                'server_id' => '1',
            );
        }

        $request->session()->put('cart', $cart);
        return back();
    }

    public function delete_cart(Request $request)
    {
        $item_id = $request->input('item_id');
        $shopitem = ShopItem::where('id', $item_id)->first();
        if (!$shopitem) {
            return back();
        }

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
        } else {
            $cart = array();
        }

        if (!empty($cart)) {
            $cart_tmp = array();
            foreach ($cart as $cart_item) {
                if ($cart_item['id'] != $item_id) {
                    $cart_tmp[] = $cart_item;
                }
            }
            $cart = $cart_tmp;
        }

        $request->session()->put('cart', $cart);
        return back();
    }

    public function update_cart(Request $request)
    {
        $item_id = $request->input('item_id');
        $item_qty = abs($request->input('item_qty'));
        $shopitem = ShopItem::where('id', $item_id)->first();
        if (!$shopitem || $item_qty < 1) {
            return back();
        }

        if ($item_qty > 100) $item_qty = 100;

        if ($request->session()->has('cart')) {
            $cart = $request->session()->get('cart');
        } else {
            $cart = array();
        }

        if (!empty($cart)) {
            $cart_item_find = FALSE;
            $i = -1;
            foreach ($cart as $cart_item) {
                $i++;
                if ($cart_item['id'] == $item_id) {
                    $cart[$i]['qty'] = $item_qty;
                    $cart_item_find = TRUE;
                }
            }
            if ($cart_item_find !== TRUE) {
                $cart[] = array(
                    'id' => $item_id,
                    'qty' => 1,
                    'server_id' => '1',
                );
            }
        }

        $request->session()->put('cart', $cart);
        return back();
    }

    public function apply_coupon(Request $request)
    {
        $coupon = ShopCoupon::where('code', $request->input('coupon_code'))
            ->where('date_start', '<', date('Y-m-d H:i:s'))
            ->where('date_end', '>', date('Y-m-d H:i:s'))
            ->first();
        if (!$coupon) {
            $this->alert('danger', __('Неверный код купона! Или срок купона истек!'));
            return back();
        }

        //type=0 - Personal, type=1 - Public
        if ($coupon->type == 0) {
            if ($coupon->user_id != auth()->user()->id) {
                $this->alert('danger', __('Купон выдан другому пользователю!'));
                return back();
            }
            $used_users = json_decode($coupon->users);
            if (!empty($used_users) && in_array(auth()->user()->id, $used_users)) {
                $this->alert('danger', __('Вы уже использовали этот купон!'));
                return back();
            }
        } else {
            $used_users = json_decode($coupon->users);
            if (!empty($used_users) && in_array(auth()->user()->id, $used_users)) {
                $this->alert('danger', __('Вы уже использовали этот купон!'));
                return back();
            }
        }

        $cart = $this->get_cart($request);
        if ($cart['total']['amount'] == 0) return Redirect::to(route('shop'));

        $request->session()->put('coupon_discount', $coupon->percent);
        $request->session()->put('coupon_code', $coupon->code);

        $this->alert('success', __('Купон успешно применен!'));
        return back();
    }

    public function remove_coupon(Request $request)
    {
        $request->session()->forget('coupon_discount');
        $request->session()->forget('coupon_code');

        $this->alert('success', __('Купон успешно удалён!'));
        return back();
    }

    private function get_cart($request) {

        if ($request->session()->has('cart')) {
            $my_cart = $request->session()->get('cart');
            $title = "title_" . app()->getLocale();
            $description = "description_" .app()->getLocale();

            $total_amount = 0;
            $total_sale = 0;
            $total_qty = 0;
            $shopcart = array();

            if (!empty($my_cart)) {
                foreach ($my_cart as $my_cart_item) {
                    $shopitem = ShopItem::find($my_cart_item['id']);
                    if ($shopitem) {
                        $total_amount += (abs($shopitem->price) * abs($my_cart_item['qty']));
                        $total_sale += (abs($shopitem->sale) * abs($my_cart_item['qty']));
                        $total_qty += abs($my_cart_item['qty']);

                        $shopcart[] = array(
                            'id'    => $shopitem->id,
                            'title' => $shopitem->$title,
                            'description' => $shopitem->$description,
                            'image' => $shopitem->image,
                            'price' => abs($shopitem->price),
                            'sale' => abs($shopitem->sale),
                            'qty'   => abs($my_cart_item['qty']),
                            'server_id'   => abs($my_cart_item['server_id']),
                        );
                    }
                }
            }

            if ($total_qty == 0) {
                $total_qty_text = __('0 товаров');
            } elseif ($total_qty == 1) {
                $total_qty_text = $total_qty . ' ' . __('товар');
            } else {
                $total_qty_text = $total_qty . ' ' . __('товаров');
            }

            $coupon_discount = 0;
            $coupon_code = '';
            if ($request->session()->has('coupon_discount') && $request->session()->has('coupon_code')) {
                $coupon_discount = intval($total_amount * $request->session()->get('coupon_discount') / 100);
                $coupon_code = $request->session()->get('coupon_code');
            }

            //Получаем товары, которые покупают вместе для последнего товара в корзине
            $togethers = [];
            $shopitem_togethers = (isset($shopitem) && $shopitem->togethers !== NULL) ? json_decode($shopitem->togethers) : [];
            foreach ($shopitem_togethers as $shopitem_together_id) {
                $shopitem_t = ShopItem::find($shopitem_together_id);
                if ($shopitem_t) {
                    $togethers[] = $shopitem_t;
                }
            }

            $cart = array(
                'cart' => $shopcart,
                'togethers' => $togethers,
                'total' => array(
                    'total' => $total_qty_text,
                    'amount' => ($total_amount - $coupon_discount < 0) ? 0 : $total_amount - $coupon_discount,
                    'subtotal' => $total_amount,
                    'discount' => $coupon_discount + $total_sale,
                    'coupon' => $coupon_code,
                ),
            );

        }
        else {
            $cart = array(
                'cart' => array(),
                'total' => array(
                    'total' => __('0 товаров'),
                    'amount' => 0,
                    'subtotal' => 0,
                    'discount' => 0,
                    'coupon' => '',
                ),
            );
        }

        return $cart;
    }

}
