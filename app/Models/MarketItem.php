<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MarketItem extends Model
{
    protected $fillable = [
      'title_ru', 'title_en', 'description_ru', 'description_en', 'image', 'status', 'class', 'l2_id', 'category_id', 'price'
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
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name')->where('id', $this->type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->icon0;
        }
        return '';
    }

    public function getNameAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name')->where('id', $this->type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->name;
        }
        return '';
    }

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }
}
