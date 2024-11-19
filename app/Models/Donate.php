<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    protected $fillable = ['user_id', 'amount', 'server', 'payment_id', 'char_name', 'status', 'payment_system', 'fail', 'system', 'coins'];
}
