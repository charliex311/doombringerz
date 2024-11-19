<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ActivityLog extends Model
{
    public $timestamps = ["created_at"];
    const UPDATED_AT = null;

    protected $fillable = [
      'user_id', 'ip', 'message', 'type', 'is_admin'
    ];
}
