<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $timestamps = false;
    protected $fillable = ['key', 'value', 'default_key', 'server'];
}
