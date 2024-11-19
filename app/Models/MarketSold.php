<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MarketSold extends Model
{
    protected $fillable = [
      'category_id', 'price', 'count', 'status', 'sale_type', 'type', 'amount', 'enchant', 'intensive_item_type', 'variation_opt2', 'variation_opt1', 'wished', 'ident', 'bless', 'eroded', 'seller_id', 'buyer_id', 'server', 'latest_id'
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
