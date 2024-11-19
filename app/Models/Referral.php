<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Referral extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'code', 'note', 'status', 'user_id', 'total', 'users', 'history'
    ];

    protected $appends = [
        'ref_users'
    ];

    public function getRefUsersAttribute()
    {
        return ($this->users === NULL) ? [] : json_decode($this->users);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
