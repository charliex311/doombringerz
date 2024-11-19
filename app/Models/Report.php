<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
      'attachment', 'question', 'answer', 'title', 'uuid', 'user_id', 'char_id', 'answer_user_id', 'history', 'status', 'is_read', 'is_lock', 'priority', 'server', 'category_id',
      'subcategory_id', 'link', 'comment', 'like', 'dislike', 'like_users', 'replicate', 'replicate_users', 'link_trello', 'steps', 'expected_result'
    ];

    protected $appends = [
        'attachment_url'
    ];

    public function getAttachmentUrlAttribute()
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

    public function getRouteKeyName()
    {
        return 'id';
    }
}
