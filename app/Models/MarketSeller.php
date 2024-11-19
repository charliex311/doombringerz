<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MarketSeller extends Model
{
    protected $fillable = [
      'user_id', 'trust_lvl', 'history'
    ];

    public function getHistoryAttribute()
    {
        //return Storage::disk('public')->url($this->image);
    }
}
