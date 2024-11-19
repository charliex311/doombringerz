<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ReleaseNote extends Model
{
    protected $fillable = [
      'title_ru', 'title_en', 'title_br', 'title_es', 'description_en', 'description_ru', 'description_pt', 'description_es', 'server', 'category_id', 'date', 'status', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
