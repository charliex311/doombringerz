<?php

namespace App\Http\Controllers\Auth;

use App\Events\SessionRegenerate;
use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\User;
use App\Services\Sms;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use TimeHunter\LaravelGoogleReCaptchaV2\Validations\GoogleReCaptchaV2ValidationRule;
use GuzzleHttp\Client;
use Socialite;


class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(Request $request)
    {
        session()->put('sign_action', 1);
        return redirect()->route('home');
    }

    public function login_2fa(Request $request)
    {
        return view('auth.login_2fa');
    }

    public function loginGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function loginDiscord()
    {
        return Socialite::driver('discord')->redirect();
    }

    /**
     * Handle an authentication attempt.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function authenticate(Request $request): RedirectResponse
    {
        session()->put('log_action', 1);

        /*
                $request->validate([
                    'email'                => ['email'],
                    'phone'                => ['string', 'max:20'],
                    'password'             => ['required'],
                    'recaptcha_v3'         => ['required_without:g-recaptcha-response', 'recaptchav3:login,0.5'],
                    'g-recaptcha-response' => [array_key_exists('g-recaptcha-response', $request->all()) ? new GoogleReCaptchaV2ValidationRule() : 'nullable']
                ]);
        */

        //Проверяем, по email или телефону идет авторизация
        if ($request->input('email') !== NULL) {
            $user = User::where('email', $request->input('email'))->orWhere('name', $request->input('email'))->first();
            if ($user && config('options.ga_users_status', '0') == '1' && $user->status_2fa == '1') {
                if (Hash::check($request->input('password'), $user->password)) {
                    session()->put('user', $user);
                    session()->put('email', $user->email);
                    session()->put('password', $request->input('password'));
                    return redirect()->route('user.login_2fa');
                }
            } else {
                if (Auth::attempt(['email' => $user->email, 'password' => $request->input('password')], $request->has('remember'))) {
                    $this->activityLog(2, ' successful login. User: ' . auth()->user()->name);
                    $request->session()->regenerate();
                    return redirect()->route('cabinet');
                }
            }

            $this->alert('danger', __('Пользователя с данным E-Mail не существует или пароль неверный.'));
            return back();

        } else {

            $user = User::where('phone', $request->input('phone'))->first();
            if ($user && config('options.ga_users_status', '0') == '1' && $user->status_2fa == '1') {
                if (Hash::check($request->input('password'), $user->password)) {
                    session()->put('user', $user);
                    session()->put('phone', $request->input('phone'));
                    session()->put('password', $request->input('password'));
                    return redirect()->route('user.login_2fa');
                }
            } else {
                if (Auth::attempt($request->only(['phone', 'password']), !$request->has('remember'))) {
                    $this->activityLog(2, ' successful login. User: ' . auth()->user()->name);
                    $request->session()->regenerate();
                    return redirect()->route('cabinet');
                }
            }

            $this->alert('danger', __('Пользователя с данным номером телефона не существует или пароль неверный.'));
            return back();
        }

    }

    public function authenticate_2fa(Request $request): RedirectResponse
    {
        $user = session()->get('user');

        if (!$user || (!session()->has('email') && !session()->has('phone')) || !session()->has('password')) {
            return redirect()->route('login');
        }

        //Get QR code for Google Authenticator
        $client = new Client();
        $queryUrl = "https://www.authenticatorApi.com/Validate.aspx?Pin=" . $request->input('code_2fa') . "&SecretCode="  . config('app.name', '') . $user->secretcode_2fa;
        $response = $client->get($queryUrl);
        $qrcode = (string)$response->getBody();

        if ($qrcode === 'True') {

            //Проверяем, по email или телефону идет авторизация
            if (session()->get('email') !== NULL) {
                $data['email'] = session()->get('email');
            } else {
                $data['phone'] = session()->get('phone');
            }
            $data['password'] = session()->get('password');
            if (Auth::attempt($data, !$request->has('remember'))) {
                $this->activityLog(2, ' successful login. User: ' . auth()->user()->name);
                $request->session()->regenerate();
                return redirect()->route('cabinet');
            }

        }

        $this->alert('danger', __('Код авторизации неверный! Попробуйте еще раз.'));
        return back();
    }

    public function authenticateGoogle(Request $request)
    {
        try {
            $user_google = Socialite::driver('google')->user();

            //Check if the user exists, otherwise create a new user
            $user = User::where('google_id', $user_google->id)->first();
            if (!$user) {
                $user = new User;
                $user->google_id = $user_google->id;
            }

            //Check if the user is not banned
            if ($user->is_ban === 1) {
                $this->alert('danger', __('Пользователь забанен!'));
                return redirect()->route('index');
            }

            $user->name = $user_google->name;
            $user->email = $user_google->email;
            $user->avatar = $user_google->avatar;
            $user->password = Hash::make(generationPassword());
            $user->save();

            Auth::login($user, !$request->has('remember'));

            $this->activityLog(2, ' successful login. User: ' . $user->name);
            $request->session()->regenerate();
            return redirect()->route('index');

        } catch (Exception $e) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
            return redirect()->route('index');
        }
    }

    public function authenticateDiscord(Request $request)
    {
        try {
            $user_discord = Socialite::driver('discord')->user();

            //Check if the user exists, otherwise create a new user
            $user = User::where('discord_id', $user_discord->id)->first();
            if (!$user) {
                $user = new User;
                $user->google_id = $user_discord->id;
            }

            //Check if the user is not banned
            if ($user->is_ban === 1) {
                $this->alert('danger', __('Пользователь забанен!'));
                return redirect()->route('index');
            }

            $user->name = $user_discord->name;
            $user->email = $user_discord->email;
            $user->avatar = $user_discord->avatar;
            $user->password = Hash::make(generationPassword());
            $user->save();

            Auth::login($user, !$request->has('remember'));

            $this->activityLog(2, ' successful login. User: ' . $user->name);
            $request->session()->regenerate();
            return redirect()->route('index');

        } catch (Exception $e) {
            $this->alert('danger', __('Произошла ошибка! Попробуйте позже.'));
            return redirect()->route('index');
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->activityLog(2, ' logout. User: ' . auth()->user()->name);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
}
