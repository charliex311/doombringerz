<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Article extends Model
{
    protected $fillable = [
      'title_ru', 'title_en', 'title_pt', 'title_es', 'description_en', 'description_ru', 'description_pt', 'description_es', 'image', 'type', 'status', 'add_image'
    ];

    protected $appends = [
        'image_url', 'add_image_url'
    ];

    public function getImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }

    public function getAddImageUrlAttribute()
    {
        return Storage::disk('public')->url($this->add_image);
    }
}
