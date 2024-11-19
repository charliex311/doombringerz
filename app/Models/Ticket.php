<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Ticket extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'attachment', 'question', 'answer', 'title', 'uuid', 'answer_user_id', 'is_read', 'priority'
    ];

    protected $appends = [
        'attachment_url'
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->attachment);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answerer()
    {
        return $this->belongsTo(User::class, 'answer_user_id', 'id');
    }

    public function getRouteKey()
    {
        return $this->uuid;
    }

    public function getLastHistory()
    {
        if ($this->history !== NULL) {
            $histories = json_decode($this->history);
            if (!empty($histories)) {
                return end($histories);
            }
        }
        return FALSE;
    }
}
