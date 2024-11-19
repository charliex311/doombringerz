<?php

namespace App\Http\Controllers;

use App\Lib\SRP6Service;
use App\Models\Session;
use App\Models\User;
use App\Models\Account;
use App\Models\ShopItem;
use App\Models\ShopPurchase;
use App\Models\Warehouse;
use App\Models\Reflink;
use App\Http\Requests\BalanceRequest;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ChangeUserPasswordRequest;
use App\Http\Requests\ChangeUserEmailRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use GameServer;

class UserController extends Controller
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

    public function index() {
        $users = User::query();

        $search = request()->query('search');
        if ($search) {
            $users->where('name', 'LIKE', "%{$search}%");
            $users->orWhere('email', 'LIKE', "%{$search}%");
            $users->orWhere('phone', 'LIKE', "%{$search}%");
        }

        $accountsearch = request()->query('accountsearch');
        if ($accountsearch) {
            $users_find = [];

            $users_res = DB::connection('mysql')->table('accounts')->where('login', 'LIKE', "%{$accountsearch}%")->get();
            foreach ($users_res as $user_res) {
                $users_find[] = $user_res->user_id;
            }

            $users->whereIn('id', $users_find);
        }

        $charsearch = request()->query('charsearch');
        if ($charsearch) {

            $accounts = GameServer::searchGameAccountByCharacter($charsearch);

            if($accounts) {
                $users_find = [];
                foreach ($accounts as $account) {
                    if(!$account) break;
                    $user = DB::connection('mysql')->table('accounts')->where('login', 'LIKE', "%{$account->account_name}%")->first();
                    $users_find[] = $user->user_id;
                }
                $users->whereIn('id', $users_find);
            } else {
                $users->where('name', 'LIKE', "%{'None Chars'}%");
            }

        }

        $users = $users->paginate();
        return view('backend.pages.users.list', compact('users'));
    }

    public function details(User $user) {

        $data = [];
        foreach(getservers() as $server) {
            $options = json_decode($server->options);

            //Записываем в конфиг подключения значения для текущего сервера
            config(['database.ip' => $options->ip]);
            config(['database.wowword_db_type' => $options->wowword_db_type]);
            config(['database.connections.wowdb.host' => $options->wowdb_host]);
            config(['database.connections.wowdb.port' => $options->wowdb_port]);
            config(['database.connections.wowdb.database' => $options->wowdb_database]);
            config(['database.connections.wowdb.username' => $options->wowdb_username]);
            config(['database.connections.wowdb.password' => $options->wowdb_password]);
            config(['database.connections.wowworld.host' => $options->wowworld_host]);
            config(['database.connections.wowworld.port' => $options->wowworld_port]);
            config(['database.connections.wowworld.database' => $options->wowworld_database]);
            config(['database.connections.wowworld.username' => $options->wowworld_username]);
            config(['database.connections.wowworld.password' => $options->wowworld_password]);

            $account = Account::where('user_id', $user->id)->where('server', $server->id)->latest()->first();
            session()->put('prefix', strtoupper(random_str(3)));

            $characters_count = 0;
            $characters_play_time = 0;
            $last_login = null;
            $game_account = false;
            $characters = [];
            if ($account) {
                $game_account = GameServer::getGameAccount($account->login, $server->id);
                if ($game_account) {
                    $characters_count = GameServer::getCharactersCount($game_account->id, $server->id);
                    $characters_play_time = GameServer::getCharactersPlayTime($game_account->id, $server->id);
                    $last_login = $game_account->last_login;

                    $characters = GameServer::getCharacters($game_account->id, $server->id);
                }
            }

            $data[] = [
                "server" => $server,
                "account" => $account,
                "game_account" => $game_account,
                "characters" => $characters,
            ];
        }

        return view('backend.pages.users.info', compact('data', 'user'));
    }

    public function warehouse(User $user)
    {
        $items = [];
        foreach (getservers() as $server) {
            $items[$server->id] = Warehouse::where('user_id', $user->id)->where('server', $server->id)->where('amount', '>', 0)->get();
        }

        return view('backend.pages.users.warehouse', compact('items', 'user'));
    }

    public function warehouse_update(Request $request)
    {
        $item_id = abs(intval($request->item_id));
        $quantity = abs(intval($request->item_quantity));
        $user_id = abs(intval($request->user_id));
        $server_id = abs(intval($request->server_id));

        $user = User::where('id', $user_id)->first();
        $warehouse = Warehouse::where('id', $item_id)->where('user_id', $user_id)->where('server', $server_id)->first();

        if (!$user || !$warehouse) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
            return back();
        }

        $quantity_old = $warehouse->amount;
        $warehouse->amount = $quantity;

        if ($warehouse->save()) {
            $this->alert('success', __('Вы успешно изменили количество предмета на складе МА!'));
            Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Изменил количество предмета ID: " . $warehouse->type . " с ".$quantity_old." на ".$quantity." шт. для пользователя {$user->name} ({$user->email})");
            return back();
        }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }

    public function warehouse_delete(Request $request)
    {
        $item_id = abs(intval($request->item_id));
        $user_id = abs(intval($request->user_id));
        $server_id = abs(intval($request->server_id));

        $user = User::where('id', $user_id)->first();
        $warehouse = Warehouse::where('id', $item_id)->where('user_id', $user_id)->where('server', $server_id)->first();

        if (!$user || !$warehouse) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
            return back();
        }

        $item_id_old = $warehouse->type;
        $quantity_old = $warehouse->amount;

        if ($warehouse->delete()) {
            $this->alert('success', __('Вы успешно удалили предмет со склада МА!'));
            Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Удалил со склада предмет ID: " . $item_id_old . " в количестве ".$quantity_old." шт. для пользователя {$user->name} ({$user->email})");
            return back();
        }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }

    public function admin(User $user): RedirectResponse
    {
        $user->role = 'admin';
        $user->save();
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Appointed {$user->name} as administrator");
        $this->alert('success', __('Вы успешно назначили') . ' ' . $user->name . ' ' . __('администратором'));
        return back();
    }

    public function support(User $user): RedirectResponse
    {
        $user->role = 'support';
        $user->save();
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Appointed {$user->name} support agent");
        $this->alert('success', __('Вы успешно назначили') . ' ' . $user->name . ' ' . __('агентом поддержки'));
        return back();
    }

    public function investor(User $user): RedirectResponse
    {
        $user->role = 'investor';
        $user->save();
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Appointed {$user->name} as investor");
        $this->alert('success', __('Вы успешно назначили') . ' ' . $user->name . ' ' . __('доступ Инвестора'));
        return back();
    }

    public function user(User $user): RedirectResponse
    {
        $user->role = 'user';
        $user->save();
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Appointed {$user->name} regular user");
        $this->alert('success', __('Вы успешно назначили') . ' ' . $user->name . ' ' . __('обычным пользователем'));
        return back();
    }

    public function setBalance(BalanceRequest $request): RedirectResponse
    {
        $user = User::where('id', $request->input('user_id'))->firstOrFail();
        $user->balance = $request->input('balance');
        $user->save();
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Changed balance for user {$user->name} to " . $request->input('balance') . ' ' . config('options.coin_name', 'CoL'));
        $this->alert('success', __('Вы успешно изменили баланс пользователю') . ' ' . $user->name . ' ' . __('на') . ' ' . $request->input('balance') . ' ' . config('options.coin_name', 'CoL'));
        return back();
    }

    public function setItem(ItemRequest $request): RedirectResponse
    {
        $quantity = abs(intval($request->item_quantity));
        $shopitem = ShopItem::where('l2_id', abs(intval($request->item_id)))->first();

        $user = User::where('id', $request->input('user_id'))->first();
        if (!$user || !$shopitem) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
            return back();
        }

        //Record data on the purchase of a one-time item
        if ($shopitem->purchase_type == '1') {
            $shop_purchases = ShopPurchase::where('item_id', $shopitem->id)->where('user_id', $user->id)->first();
            if (!$shop_purchases) {
                $shop_purchases = new ShopPurchase;
            } else {
                if (strtotime($shop_purchases->validity) > strtotime(date('Y-m-d H:i:s'))) {
                    $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
                    return back();
                }
            }
            $shop_purchases->item_id = $shopitem->id;
            $shop_purchases->user_id = $user->id;
            $shop_purchases->validity = date('Y-m-d H:i:s', strtotime('+' . $shopitem->use_time . ' day', strtotime(date('Y-m-d H:i:s'))));
            $shop_purchases->save();
        }

        //Check if the product is already there, then add the quantity to it
        $warehouse = Warehouse::where('type', $shopitem->l2_id)->where('user_id', $user->id)->where('server', 1)->first();
        if ($warehouse) {
            $warehouse->amount += $quantity;
        } else {

            //We add the goods to the warehouse
            $warehouse = new Warehouse;
            $warehouse->type = $shopitem->l2_id;
            $warehouse->user_id = $user->id;
            $warehouse->amount = $quantity;
            $warehouse->enchant = 0;
            $warehouse->intensive_item_type = 0;
            $warehouse->variation_opt2 = 0;
            $warehouse->variation_opt1 = 0;
            $warehouse->wished = 0;
            $warehouse->ident = 0;
            $warehouse->bless = 0;
            $warehouse->server = 1;
        }

        if ($warehouse->save()) {

            //Add buy_pack in user
            if ($user && in_array($shopitem->id, ['19','20','21'])) {
                $user->buy_pack = 1;
                $user->save();
            }

            $this->alert('success', __('Предмет успешно отправлен на склад МА!'));
            Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Добавил предмет " . $shopitem->title_en . " для пользователя {$user->name} ({$user->email}) в количестве " . $quantity);
            return back();
        }

        $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
        return back();
    }

    public function backend_change_password(ChangeUserPasswordRequest $request): RedirectResponse
    {
        $user = User::where('id', $request->input('user_id'))->first();

        if (!$user) {
            $this->alert('danger', __('Ошибка! Повторите позже!'));
            return back();
        }

        //Делаем проверку, что в пароле используются только латинские буквы
        $chr_en = "a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
        if (!preg_match("/^[$chr_en]+$/", $request->input('new_password'))) {
            $this->alert('danger', __('Ошибка! Используйте только латинские буквы в пароле!'));
            return back();
        }

        $new_password = Hash::make($request->input('new_password'));

        //Устанавливаем новый пароль
        $user->password = $new_password;
        $user->save();

        $this->alert('success', __('Вы успешно сменили пароль Мастер Аккаунта: ') . $request->input('login'));

        return back();
    }

    public function backend_change_email(ChangeUserEmailRequest $request): RedirectResponse
    {
        $user = User::where('id', $request->input('user_id'))->first();

        if (!$user) {
            $this->alert('danger', __('Ошибка! Повторите позже!'));
            return back();
        }

        //Устанавливаем новый email
        $user->email = $request->input('email');
        $user->email_verified_at = NULL;
        $user->save();

        $this->alert('success', __('Вы успешно сменили email Мастер Аккаунта') . ': ' . $request->input('login'));
        return back();
    }

    public function backend_account_create(User $user): RedirectResponse
    {
        $account = Account::where('login', $user->account_login)->first();
        if (!$account) {

            if ($user->account_login === null || $user->account_password === null) {
                $this->alert('danger', __('Произошла ошибка! Игровой Аккаунт не может быть привязан.'));
                return back();
            }

            //Создаем игровой аккаунт
            $account = new Account;
            $account->login = $user->account_login;
            $account->user_id = $user->id;
            $account->server = session('server_id', 1);
            $account->save();

            list($salt, $verifier) = SRP6Service::getSaltAndVerifier($user->account_login, $user->account_password);

            if (GameServer::createGameAccount($account, $salt, $verifier, $user->email, session('server_id', 1))) {
                $user->update(['account_login' => null, 'account_password' => null]);
            }

            $this->alert('success', __('Вы успешно создали / привязали Игровой Аккаунт'));
            return back();
        }

        $this->alert('danger', __('Игровой Аккаунт уже привязан!'));
        return back();
    }

    public function getUserByName(Request $request)
    {
        $users = User::where('name', 'LIKE', "%{$request->user_name}%")->get();

        return response()->json([
            'status' => 'success',
            'users' => $users,
        ]);
    }

    public function ban(Request $request, User $user)
    {
        $ban_reason = 'Banned by Admin';
        $user->ban = date('Y-m-d H:i:s', strtotime('+30 days'));
        $user->ban_reason = $ban_reason;
        $user->remember_token = '';
        $user->save();

        $this->activityLog(2, ' Banned. Reason: ' . $ban_reason . '.');
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Banned user {$user->name} ({$user->email})");
        $this->alert('success', __('Вы успешно забанили') . ' ' . __('пользователя') . ' ' . $user->name);

        $session = Session::where('user_id', $user->id)->first();
        if ($session) {
            $session->delete();
        }

        return back();
    }

    public function unban(Request $request, User $user): RedirectResponse
    {
        $ban_reason = 'Unbanned by Admin';
        $user->ban = date('Y-m-d H:i:s');
        $user->ban_reason = $ban_reason;
        $user->save();

        $this->activityLog(2, ' Unbanned. Reason: ' . $ban_reason . '.');
        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Unbanned user {$user->name} ({$user->email})");
        $this->alert('success', __('Вы успешно разбанили') . ' ' . __('пользователя') . ' ' . $user->name);
        return back();
    }

}
