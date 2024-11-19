<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Feature extends Model
{
    protected $fillable = [
      'title_ru', 'title_en', 'title_br', 'title_es', 'title_fr', 'status', 'sort', 'link', 'description_en', 'description_ru', 'description_br', 'description_es','description_fr', 'image'
    ];

    protected $appends = [
        'image_url'
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }

}
