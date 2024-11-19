<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Faq extends Model
{
    protected $fillable = [
      'question_ru', 'question_en', 'question_br', 'question_es', 'question_fr', 'answer_ru', 'answer_en', 'answer_br', 'answer_es', 'answer_fr' , 'sort'
    ];

}
