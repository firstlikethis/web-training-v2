<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'thumbnail',
        'is_active',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($course) {
            if (empty($course->slug)) {
                $randomNumber = mt_rand(100000, 999999);
                $course->slug = 'course' . $randomNumber;
                
                $existingCourse = self::where('slug', $course->slug)->first();
                while ($existingCourse) {
                    $randomNumber = mt_rand(100000, 999999);
                    $course->slug = 'course' . $randomNumber;
                    $existingCourse = self::where('slug', $course->slug)->first();
                }
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function videos()
    {
        return $this->hasMany(Video::class)->orderBy('order');
    }
}