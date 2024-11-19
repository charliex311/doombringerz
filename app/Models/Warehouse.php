<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $lineage_item;

    protected $fillable = [
        'type','item_name','amount','user_id','server'
    ];

    protected $appends = [
        'icon', 'name'
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
}
