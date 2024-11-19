<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $appends = [
        'icon', 'name'
    ];

    protected $casts = [
        'start_price' => 'integer',
        'buyout_price' => 'integer',
        'current_bet' => 'integer',
        'count' => 'integer',
        'amount' => 'integer',
        'end_at' => 'datetime'
    ];

    public function getIconAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name', 'add_name')->where('id', $this->type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->icon0;
        }
        return '';
    }

    public function getNameAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name', 'add_name')->where('id', $this->type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->name;
        }
        return '';
    }

    public function getAddNameAttribute()
    {
        if (!$this->lineage_item) {
            $this->lineage_item = LineageItem::select('icon0', 'name', 'add_name')->where('id', $this->type)->first();
        }
        if ($this->lineage_item) {
            return $this->lineage_item->add_name;
        }
        return null;
    }

    public function augmentation0() {
        return $this->hasOne(Augmentation::class, 'id', 'intensive_item_type');
    }

    public function augmentation1() {
        return $this->hasOne(Augmentation::class, 'id', 'variation_opt1');
    }

    public function augmentation2() {
        return $this->hasOne(Augmentation::class, 'id', 'variation_opt2');
    }
}
