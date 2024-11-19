<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopItem extends Model
{
    protected $fillable = [
      'title_ru', 'title_en','title_br', 'title_es','title_fr', 'image', 'wow_id', 'category_id', 'price', 'sale', 'status', 'label', 'description_en', 'description_ru', 'description_br', 'description_es','description_fr',
      'description_add_en', 'description_add_ru', 'description_add_br', 'description_add_es','description_add_fr', 'togethers'
    ];

    protected $appends = [
        'image_url', 'togethers_arr', 'discount'
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }

    public function getTogethersArrAttribute()
    {
        return ($this->togethers !== NULL) ? json_decode($this->togethers) : [];
    }

    public function getDiscountAttribute()
    {
        return ($this->sale > 0 && $this->price > 0) ? (($this->price - $this->sale) / $this->price) * 100 : 0;
    }
}
