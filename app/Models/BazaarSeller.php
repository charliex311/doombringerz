<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BazaarSeller extends Model
{
    protected $fillable = [
      'user_id', 'trust_lvl', 'history', 'charge', 'charge_date', 'charge2', 'charge2_date'
    ];

    public function getHistoryAttribute()
    {
        //return Storage::disk('public')->url($this->image);
    }
}
