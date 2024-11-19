<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PromoCode extends Model
{
    protected $fillable = [
      'title','code','type','type_restriction','user_id','users','date_start','date_end','items'
    ];
}
