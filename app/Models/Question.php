<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'video_id',
        'question_text',
        'time_to_show',
    ];

    public function video()
    {
        return $this->belongsTo(Video::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class);
    }

    public function correctOption()
    {
        return $this->hasOne(QuestionOption::class)->where('is_correct', true);
    }

    public function answers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}