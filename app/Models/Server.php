<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Server extends Model
{
    protected $fillable = [
      'id', 'name', 'status', 'options'
    ];
}
