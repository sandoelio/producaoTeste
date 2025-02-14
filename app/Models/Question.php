<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['question_text', 'answer_correct', 'points', 'image'];

    
    public function question()
    {
        return $this->belongsTo(\App\Models\Question::class);
    }

}


