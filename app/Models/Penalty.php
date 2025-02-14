<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'penalty_points',
        'reason',
        'start_time',
        'end_time',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
