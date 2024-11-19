<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BazaarItemsPatch extends Model
{
    protected $table = 'bazaar_items_patch';

    protected $fillable = [
      'item_id', 'Patch'
    ];

}
