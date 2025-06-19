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

        // ตรวจสอบว่า slug ไม่เป็นค่าว่างก่อนบันทึกข้อมูล
        static::saving(function ($course) {
            if (empty($course->slug) && !empty($course->title)) {
                $course->slug = Str::slug($course->title);
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