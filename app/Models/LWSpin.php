<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LWSpin extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'item_id', 'date'];

}
