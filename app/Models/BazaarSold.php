<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BazaarSold extends Model
{
    protected $fillable = [
      'category_id', 'price', 'count', 'status', 'sale_type', 'type', 'amount', 'enchant', 'intensive_item_type', 'variation_opt2', 'variation_opt1',
      'wished', 'ident', 'bless', 'eroded', 'seller_id', 'buyer_id', 'lvl', 'seller_character_id', 'buyer_character_id', 'server', 'latest_id'
    ];

    protected $lineage_item;

    protected $appends = [
        'image_url', 'icon', 'name'
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
}
