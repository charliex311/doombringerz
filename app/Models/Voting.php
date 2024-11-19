<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Voting extends Model
{
    protected $fillable = ['vote_id', 'user_id', 'ip', 'status', 'amount', 'vote_system', 'hwid','created_at', 'updated_at'];

    protected $table = 'votes';

}
