<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    protected static function boot()
    {
        parent::boot();

        // สร้าง slug อัตโนมัติก่อนบันทึก
        static::saving(function ($category) {
            if (empty($category->slug)) {
                $randomNumber = mt_rand(100000, 999999);
                $category->slug = 'category' . $randomNumber;
                
                $existingCategory = self::where('slug', $category->slug)->first();
                while ($existingCategory) {
                    $randomNumber = mt_rand(100000, 999999);
                    $category->slug = 'category' . $randomNumber;
                    $existingCategory = self::where('slug', $category->slug)->first();
                }
            }
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}