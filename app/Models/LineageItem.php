<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LineageItem extends Model
{
    protected $table = 'lineage_items';

    protected $fillable = [
        'sid', 'module', 'id', 'name', 'add_name', 'description', 'set_bonus_desc', 'class', 'icon0', 'grade', 'consume_type', 'auction_block'
    ];

    protected $appends = [
        'icon0'
    ];

    public function getIcon0UrlAttribute()
    {
        return Storage::disk('public')->url($this->icon0);
    }

}
