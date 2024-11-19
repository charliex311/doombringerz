<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BazaarCategory extends Model
{
    protected $fillable = [
      'path', 'title_ru', 'title_en', 'title_pt', 'title_es', 'description_en', 'description_ru', 'description_pt', 'description_es', 'image', 'sort'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }
}
