<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Release extends Model
{
    protected $fillable = [
      'title_ru', 'title_en', 'title_br', 'title_es', 'image', 'date', 'is_release', 'sort', 'link', 'description_en', 'description_ru', 'description_br', 'description_es',
      'road_groups', 'category', 'expected_result'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }

}
