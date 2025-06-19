<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cocur\Slugify\Slugify;
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
            if (empty($category->slug) && !empty($category->name)) {
                $slugify = new Slugify();
                
                // พยายามสร้าง slug ตามปกติก่อน
                $slug = $slugify->slugify($category->name);
                
                // ถ้า slug ว่างเปล่าหรือไม่มีการเปลี่ยนแปลง (ภาษาไทย)
                if (empty($slug) || $slug === $category->name) {
                    // ใช้ ID + timestamp แทน สำหรับภาษาไทย
                    $id = $category->id ?? date('YmdHis');
                    $slug = 'category-' . $id;
                }
                
                $category->slug = $slug;
            }
        });
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}