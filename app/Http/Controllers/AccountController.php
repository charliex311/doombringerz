<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\TransferAccountRequest;
use App\Models\Account;
use App\Models\ActivityLog;
use App\Models\LWSpin;
use App\Models\Warehouse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Mail;
use GameServer;
use  App\Lib\SRP6Service;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('server.status');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|Response
     */
    public function index()
    {
        $account = Account::where('user_id', auth()->id())->where('server', session('server_id'))->latest()->first();
        session()->put('prefix', strtoupper(random_str(3)));

        $characters_count = 0;
        $characters_play_time = 0;
        $last_login = null;
        $game_account = false;
        $characters = [];

        if ($account) {
            $game_account = GameServer::getGameAccount($account->login, session('server_id'));
            if ($game_account) {
                $characters_count = GameServer::getCharactersCount($game_account->id, session('server_id'));
                $characters_play_time = GameServer::getCharactersPlayTime($game_account->id, session('server_id'));
                $last_login = $game_account->last_login;

                $characters = GameServer::getCharacters($game_account->id, session('server_id'));
            }
        }

        $free_spin = LWSpin::query()->where('user_id', auth()->id())->whereDate('date', now())->doesntExist();

        $warehouse_count = Warehouse::where('user_id', auth()->id())->count();

        $logs = ActivityLog::where('user_id', auth()->id())->where('is_admin', 0)->limit(5)->get();

        //Задаем метку, что это редирект с успешной регистрации
        $down_reg = (session()->get('reg_txt_url', '') != '') ? true : false;

        return view('pages.cabinet.cabinet', compact('game_account', 'characters', 'characters_count', 'characters_play_time', 'last_login', 'warehouse_count', 'logs', 'down_reg', 'free_spin'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AccountRequest $request
     * @return RedirectResponse
     */
    public function store(AccountRequest $request): RedirectResponse
    {
        $accounts_count = Account::where('user_id', auth()->id())->where('server', session('server_id'))->count();
        if ($accounts_count < 15) {
            $password = encrypt($request->password);

            //Делаем проверку, что в логине используются только латинские буквы
            $chr_en = "a-zA-Z0-9\s";
            if (!preg_match("/^[$chr_en]+$/", $request->input('login'))) {
                $this->alert('danger', __('Ошибка! Игровой аккаунт не создан! Используйте только латинские буквы в логине!'));
                return back();
            }

            //Делаем проверку, что в пароле используются только латинские буквы
            $chr_en = "a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
            if (!preg_match("/^[$chr_en]+$/", $request->input('password'))) {
                $this->alert('danger', __('Ошибка! Игровой аккаунт не создан! Используйте только латинские буквы в пароле!'));
                return back();
            }

            $account = new Account;
            $account->login = $request->input('login');

            if (config('options.prefix') !== NULL && config('options.prefix') === "1") {
                $account->login = $request->input('prefix') . "_" . $account->login;
            }
            $account->user_id = auth()->id();
            $account->server = session('server_id');


            list($salt, $verifier) = SRP6Service::getSaltAndVerifier($account->login, $request->password);

            if (GameServer::createGameAccount($account, $salt, $verifier, auth()->user()->email, session('server_id', 1))) {
                $account->save();
                $this->alert('success', __('Вы успешно создали игровой аккаунт'));
                return back();
            }

            $this->alert('danger', __('Ошибка при создании игрового аккаунта'));
        }
        return back();
    }

    public function change(ChangePasswordRequest $request): RedirectResponse
    {
        Account::where('user_id', auth()->id())->where('login', $request->input('login'))->where('server', session('server_id'))->firstOrFail();

	$account_valid = false;
        $new_password = encrypt_whirlpool($request->input('new_password'));

        if ($request->input('password') !== NULL) {

            $password = encrypt_whirlpool($request->input('password'));

            //Проверяем, что введенный текущий пароль совпадает с паролем в БД
            $account_valid = GameServer::validPasswordAccount($request->input('login'), $password);

        } else {

            //Сверяем пин код мастер аккаунта
            if (auth()->user()->pin === $request->input('pin')) {
                $account_valid = true;
            }

        }

	if ($account_valid) {

        //Делаем проверку, что в пароле используются только латинские буквы
        $chr_en = "a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
        if (!preg_match("/^[$chr_en]+$/", $request->input('new_password'))) {
            $this->alert('danger', __('Ошибка! Игровой аккаунт не создан! Используйте только латинские буквы в пароле!'));
            return back();
        }

        //Устанавливаем новый пароль
        GameServer::setPasswordAccount($request->input('login'), $new_password);

        $this->alert('success', __('Вы успешно сменили пароль игрового аккаунта: ') . $request->input('login'));

    } else {
        $this->alert('danger', __('Ошибка! Пароль не изменён! Вы ввели не верно Pin код или старый пароль игрового аккаунта: ') . $request->input('login'));
    }

        return back();
    }

    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        Account::where('user_id', auth()->id())->where('login', $request->input('login'))->where('server', session('server_id'))->firstOrFail();

		//Генерирую случайный пароль
        	$passw = generationPassword();
       		$new_password = encrypt_whirlpool($passw);

		//Отсылаем письмо с новым паролем на почту!
		$email = auth()->user()->email;

		$mail_text = __('Ваш пароль для игрового аккаунта ') . $request->input('login') . __(' успешно сброшен!') . " \n";
		$mail_text .= __('Новый пароль: ') . $passw . "\n";
		$mail_text .= __('Если Вы не сбрасывали пароль, то обратитесь к администратору!');

		try {
			Mail::raw($mail_text, function($message) use($email) {
		           $message->to($email);
	        	   $message->subject(__('Ваш пароль успешно сброшен!'));
			});
		} catch (\Exception $ex) {
			//Ошибка при отправке письма
		}


        //Устанавливаем новый пароль
        GameServer::setPasswordAccount($request->input('login'), $new_password);

        $this->alert('success', __('Вы успешно сбросили пароль игрового аккаунта: ') . $request->input('login'));

        return back();
    }

    public function backend_change_password(ChangePasswordRequest $request): RedirectResponse
    {
        $account = Account::where('user_id', $request->input('user_id'))->where('login', $request->input('login'))->where('server', $request->input('server_id'))->first();

        if (!$account) {
            $this->alert('danger', __('Ошибка! Повторите позже!'));
            return back();
        }

        //Делаем проверку, что в пароле используются только латинские буквы
        $chr_en = "a-zA-Z0-9\s`~!@#$%^&*()_+-={}|:;<>?,.\/\"\'\\\[\]";
        if (!preg_match("/^[$chr_en]+$/", $request->input('new_password'))) {
            $this->alert('danger', __('Ошибка! Используйте только латинские буквы в пароле!'));
            return back();
        }

        //Записываем в конфиг подключения значения для текущего сервера
        $server = getserver($request->input('server_id'));
        $options = json_decode($server->options);
        config(['database.ip' => $options->ip]);
        config(['database.l2word_db_type' => $options->l2world_db_type]);
        config(['database.connections.lin2db.host' => $options->lin2db_host]);
        config(['database.connections.lin2db.port' => $options->lin2db_port]);
        config(['database.connections.lin2db.database' => $options->lin2db_database]);
        config(['database.connections.lin2db.username' => $options->lin2db_username]);
        config(['database.connections.lin2db.password' => $options->lin2db_password]);
        config(['database.connections.lin2world.host' => $options->lin2world_host]);
        config(['database.connections.lin2world.port' => $options->lin2world_port]);
        config(['database.connections.lin2world.database' => $options->lin2world_database]);
        config(['database.connections.lin2world.username' => $options->lin2world_username]);
        config(['database.connections.lin2world.password' => $options->lin2world_password]);

        //Устанавливаем новый пароль
        $new_password = encrypt($request->input('new_password'));
        GameServer::setPasswordAccount($request->input('login'), $new_password);

        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Изменил пароль для игрового аккаунта ". $request->input('login'));
        $this->alert('success', __('Вы успешно сменили пароль игрового аккаунта: ') . $request->input('login'));

        return back();
    }


    public function transfer_account(TransferAccountRequest $request): RedirectResponse
    {
        $account = Account::where('user_id', $request->input('user_id'))->where('login', $request->input('login'))->where('server', $request->input('server_id'))->first();

        if (!$account) {
            $this->alert('danger', __('Ошибка! Повторите позже!'));
            return back();
        }

        //Задаем для аккаунта новый МА
        $account->user_id = $request->input('transfer_user_id');
        $account->save();

        Log::channel('adminlog')->info(auth()->user()->role . " " . auth()->user()->name . ": Перенёс игровой аккаунт ". $request->input('login') . " в Мастер Аккаунт " . $request->input('user_name'));
        $this->alert('success', __('Вы успешно перенесли игровой аккаунт: ') . $request->input('login') . ' в Мастер Аккаунт: ' . $request->input('user_name'));

        return back();
    }

}
