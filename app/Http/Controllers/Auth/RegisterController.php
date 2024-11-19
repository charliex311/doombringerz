<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserVerify;
use App\Models\Referral;
use App\Services\Sms;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Auth\Events\Verified;
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Validation\Validator as ReturnValidator;
use TimeHunter\LaravelGoogleReCaptchaV2\Validations\GoogleReCaptchaV2ValidationRule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Session;
use Mail;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return ReturnValidator
     */

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => ['required', 'string', 'min:3', 'max:32', 'unique:users'],
            'email'    => ['sometimes', 'email', 'max:35', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
            'ok'       => ['accepted'],
            //'recaptcha_v3'         => ['required_without:g-recaptcha-response', 'recaptchav3:register,0.5'],
            //'g-recaptcha-response' => [array_key_exists('g-recaptcha-response', $data) ? new GoogleReCaptchaV2ValidationRule() : 'nullable']
        ], [
            'ok.accepted' => __('Вы должны принять Политику конфиденциальности и Пользовательское соглашение.'),
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'pin'      => $data['pin'],
            'password' => Hash::make($data['password']),
            'avatar'   => getRandomAvatar(),
            'account_login'    => $data['account_login'],
            'account_password' => $data['account_password'],
        ]);
    }

    public function register(Request $request)
    {
        session()->put('reg_action', 1);

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = array(
            'name'                  => $request->input('name'),
            'email'                 => $request->input('email') !== NULL ? $request->input('email') : '',
            'password'              => $request->input('password'),
            'password_confirmation' => $request->input('password_confirmation'),
            'pin'                   => generationCode(),
            'account_login'         => $request->input('name'),
            'account_password'      => $request->input('password'),
        );

        $user = $this->create($data);
        if ($user) {
            $this->activityLog(2, 'successful register. User: ' . $user->name);
            Auth::guard()->login($user);
        }

        //Начисляем бонус за реферала
        if (session()->has('ref_code')) {
            $res = $this->setBonus(session()->get('ref_code'));
        }

        //Отправляем письмо с верификацией эмейл
        if ($request->input('email') !== NULL) {
            $token = Str::random(64);
            $data_usv = UserVerify::create([
                'user_id' => auth()->id(),
                'token'   => $token,
            ]);

            $email = $data["email"];
            try {
                Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($email) {
                    $message->to($email);
                    $message->subject(__('Электронная почта для подтверждения'));
                });
            } catch (\Exception $ex) {
                //
            }
        }

        // event(new Registered($user));
        //Создаем файл с данными регистрации и передаем пользователю
        $reg_info = "Congratulations! You have successfully created a master account." . "\n\n";
        $reg_info .= "Your Account Name: " . $data["name"] . "\n";
        $reg_info .= "Your Email: " . $data["email"] . "\n";
        $reg_info .= "Your password: " . $data["password"] . "\n";
        $reg_info .= "Your Pin code: " . $data["pin"] . "\n\n";
        $reg_info .= "Save this file in a secret location. And do not tell anyone your password and PIN code!" . "\n";
        $reg_txt_url = 'public/regs_txt/' . generationPassword() . '.txt';
        Storage::disk('local')->put($reg_txt_url, $reg_info);
        session()->put('reg_txt_url', $reg_txt_url);
        session()->put('down_reg', 1);

        return $request->wantsJson()
            ? new JsonResponse([], 201)
            : redirect()->route('login');
    }

    public function setBonus($ref_code)
    {
        if (!($referral = Referral::where('code', $ref_code)->first())) return FALSE;

        $users = ($referral->users === NULL) ? [] : json_decode($referral->users);
        $users[] = [
            'user_id' => auth()->id(),
            'date'    => date('Y-m-d'),
        ];
        $referral->users = json_encode($users);

        $history = json_decode($referral->history);
        $history[] = [
            'accrued'        => config('options.referral_percent_issued', '1'),
            'user_id'        => auth()->id(),
            'transaction_id' => '0',
            'amount'         => '0',
            'coins'          => '0',
            'payment_system' => 'for_register',
        ];

        $referral->total += config('options.referral_percent_issued', '1');
        $referral->history = json_encode($history);
        $referral->save();

        $user = User::find($referral->user_id);
        if ($user) {
            $user->balance += config('options.referral_percent_issued', '1');
            $user->save();
        }

        $user = User::find(auth()->id());
        if ($user) {
            $user->balance += config('options.referral_percent_registered', '1');
            $user->save();
        }

        Session::forget('ref_code');

        Log::channel('paymentslog')->info("Robot: The accrual of game currency via a referral link has been completed. Parameters: " . json_encode($referral));
        $this->alert('success', __('Вы успешно получили Бонус за регистрацию по реферальному коду!'));

        return TRUE;
    }
}

