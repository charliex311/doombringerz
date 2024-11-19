<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class BazaarItem extends Model
{
    protected $fillable = [
      'type','category_id','price','lvl','user_id','amount', 'character_id', 'account_id'
    ];

    protected $appends = [
        'icon', 'name', 'description', 'category_name', 'user'
    ];

    protected $casts = [
        'amount' => 'integer'
    ];

    public function getIconAttribute()
    {
        return getitemicon($this->type);
    }

    public function getDescriptionAttribute()
    {
        return getitemtooltipdescription($this->type, 0);
    }
    public function getNameAttribute()
    {
        return getitemtooltiptitle($this->type, 0);
    }
    public function getCategoryNameAttribute()
    {
        return getbazaarcategoryName($this->category_id, 0);
    }
    public function getUserAttribute()
    {
        return getuser($this->user_id);
    }

    public static function getPopulars()
    {
        return DB::select(DB::raw('SELECT type, SUM(count) as type_count
                      FROM bazaar_items
                      GROUP BY type ORDER BY type_count DESC;'));
    }


}
