<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StatisticsGameItem extends Model
{
    protected $fillable = [
      'item_id', 'amount', 'difference'
    ];
}