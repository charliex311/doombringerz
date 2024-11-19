<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use GameServer;

class Account extends Model
{
    protected $account;

    protected $fillable = [
        'login'
    ];

    protected $casts = [
        'last_login' => 'datetime'
    ];

}
