<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'file_path',
        'duration_seconds',
        'order',
        'is_active',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('time_to_show');
    }

    public function progress()
    {
        return $this->hasMany(UserProgress::class);
    }
}