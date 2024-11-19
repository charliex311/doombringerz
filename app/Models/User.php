<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use GameServer;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'google_id',
        'discord_id',
        'avatar',
        'pin',
        'password',
		'email_verified_at',
        'account_login',
        'account_password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
       'avatar_url'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAvatarUrlAttribute()
    {
        if ($this->avatar !== NULL) {
            if (substr($this->avatar, 0, 7) === 'images/') {
                $avatar = Storage::disk('public')->url($this->avatar);
            } else {
                $avatar = $this->avatar;
            }
        } else {
            $avatar = '/img/bug-page/admin-icon.png';
        }
        return $avatar;
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isSupport()
    {
        return $this->role === 'support';
    }

    public function isInvestor()
    {
        return $this->role === 'investor';
    }

    public function getAccountGMLvl()
    {
        $account = Account::where('user_id', $this->id)->where('server', session('server_id'))->latest()->first();
        if ($account) {
            $game_account = GameServer::getGameAccount($account->login, session('server_id'));
            if ($game_account) {
                return GameServer::getGameAccountGMLvl($game_account->id, session('server_id'));
            }
        }
        return 0;
    }

    public function isGMAdmin()
    {
        return $this->getAccountGMLvl() >= 3;
    }
}
