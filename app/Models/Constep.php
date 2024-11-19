<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Constep extends Model
{
    protected $fillable = [
      'title_ru', 'title_en', 'title_br', 'title_es', 'title_fr',
      'description_ru', 'description_en', 'description_br', 'description_es', 'description_fr',
      'sort',
      'btn1_title_ru', 'btn1_title_en', 'btn1_title_br', 'btn1_title_es', 'btn1_title_fr', 'btn1_url',
      'btn2_title_ru', 'btn2_title_en', 'btn2_title_br', 'btn2_title_es', 'btn2_title_fr', 'btn2_url',
      'btn3_title_ru', 'btn3_title_en', 'btn3_title_br', 'btn3_title_es', 'btn3_title_fr', 'btn3_url',
      'btn4_title_ru', 'btn4_title_en', 'btn4_title_br', 'btn4_title_es', 'btn4_title_fr', 'btn4_url',
    ];

}
