<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ShopCategory extends Model
{
    protected $fillable = [
      'path', 'title_ru', 'main_category_id', 'sort', 'title_en', 'title_br', 'title_es', 'title_fr', 'description_en', 'description_ru', 'description_br', 'description_es', 'description_fr'
    ];
}
