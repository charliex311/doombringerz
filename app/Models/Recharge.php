<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Recharge extends Model
{
    protected $fillable = ['char_id', 'user_id', 'type', 'server', 'date'];

}
