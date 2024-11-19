<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Lib\SRP6Service;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use Mail;

class EmailVerifyController extends Controller
{
    public function notice() {
        return view('auth.verify');
    }

    public function resend(Request $request): RedirectResponse
    {
        // $request->user()->sendEmailVerificationNotification();

		$token = Str::random(64);

        $data = UserVerify::create([
            'user_id' => $request->user()->id,
            'token' => $token,
        ]);

		$email = $data->user['email'];

		Mail::send('emails.emailVerificationEmail', ['token' => $token], function($message) use($email) {
            $message->to($email);
            $message->subject('Email Verification Mail');
        });

		return back()->with('status', 'verification-link-sent');
    }

    public function verify($token): RedirectResponse
    {
		$verifyUser = UserVerify::where('token', $token)->first();

        if ($verifyUser && !$verifyUser->user['email_verified_at']) {
            $verifyUser->user->update([
				'email_verified_at' => now(),
			]);

			$verifyUser->delete();

            //Создаем игровой аккаунт
            $account = new Account;
            $account->login = $verifyUser->user->account_login;
            $account->user_id = $verifyUser->user->id;
            $account->server = session('server_id', 1);

            list($salt, $verifier) = SRP6Service::getSaltAndVerifier($verifyUser->user->account_login, $verifyUser->user->account_password);

            if (GameServer::createGameAccount($account, $salt, $verifier, $verifyUser->user->email, session('server_id', 1))) {
                $account->save();
                $verifyUser->user->update(['account_login' => NULL, 'account_password' => NULL]);

                $this->alert('success', __('Вы успешно создали игровой аккаунт'));
            }
        }

        return redirect()->route('cabinet');
    }
}
