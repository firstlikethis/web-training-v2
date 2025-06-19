<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Course;
use App\Models\Video;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // สร้างผู้ใช้ admin
        User::create([
            'name' => 'ผู้ดูแลระบบ',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // สร้างผู้ใช้ทั่วไป
        User::create([
            'name' => 'ผู้ใช้ทั่วไป',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        
        // สร้างหมวดหมู่
        $category1 = Category::create([
            'name' => 'การพัฒนาเว็บไซต์',
            'slug' => 'web-development',
            'description' => 'คอร์สเกี่ยวกับการพัฒนาเว็บไซต์ด้วยเทคโนโลยีต่างๆ',
        ]);
        
        $category2 = Category::create([
            'name' => 'การออกแบบกราฟิก',
            'slug' => 'graphic-design',
            'description' => 'คอร์สเกี่ยวกับการออกแบบกราฟิกและการใช้งานโปรแกรมต่างๆ',
        ]);
        
        // สร้างคอร์ส
        $course1 = Course::create([
            'category_id' => $category1->id,
            'title' => 'Laravel สำหรับผู้เริ่มต้น',
            'slug' => 'laravel-for-beginners',
            'description' => 'เรียนรู้การพัฒนาเว็บแอปพลิเคชันด้วย Laravel Framework ตั้งแต่พื้นฐานจนถึงการสร้างโปรเจคจริง',
            'thumbnail' => null,
            'is_active' => true,
        ]);
        
        $course2 = Course::create([
            'category_id' => $category2->id,
            'title' => 'การออกแบบ UI/UX เบื้องต้น',
            'slug' => 'ui-ux-design-basics',
            'description' => 'เรียนรู้หลักการและเทคนิคการออกแบบ UI/UX สำหรับเว็บไซต์และแอปพลิเคชัน',
            'thumbnail' => null,
            'is_active' => true,
        ]);
        
        // สร้างวิดีโอ
        $video1 = Video::create([
            'course_id' => $course1->id,
            'title' => 'บทที่ 1: แนะนำ Laravel',
            'description' => 'ทำความรู้จักกับ Laravel Framework และการติดตั้ง',
            'file_path' => 'sample/video1.mp4',
            'duration_seconds' => 300, // 5 นาที
            'order' => 1,
            'is_active' => true,
        ]);
        
        $video2 = Video::create([
            'course_id' => $course1->id,
            'title' => 'บทที่ 2: การสร้าง Routes และ Controllers',
            'description' => 'เรียนรู้การสร้าง Routes และ Controllers ใน Laravel',
            'file_path' => 'sample/video2.mp4',
            'duration_seconds' => 420, // 7 นาที
            'order' => 2,
            'is_active' => true,
        ]);
        
        // สร้างคำถาม
        $question1 = Question::create([
            'video_id' => $video1->id,
            'question_text' => 'Laravel ใช้รูปแบบการเขียนโปรแกรมแบบใด?',
            'time_to_show' => 120, // แสดงที่ 2 นาที
        ]);
        
        // สร้างตัวเลือกสำหรับคำถาม
        QuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Procedural Programming',
            'is_correct' => false,
        ]);
        
        QuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Object-Oriented Programming (OOP)',
            'is_correct' => true,
        ]);
        
        QuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Functional Programming',
            'is_correct' => false,
        ]);
        
        QuestionOption::create([
            'question_id' => $question1->id,
            'option_text' => 'Assembly Programming',
            'is_correct' => false,
        ]);
        
        // สร้างคำถามที่ 2
        $question2 = Question::create([
            'video_id' => $video1->id,
            'question_text' => 'คำสั่งใดใช้ในการติดตั้ง Laravel ผ่าน Composer?',
            'time_to_show' => 240, // แสดงที่ 4 นาที
        ]);
        
        QuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'composer install laravel',
            'is_correct' => false,
        ]);
        
        QuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'composer create-project laravel/laravel project-name',
            'is_correct' => true,
        ]);
        
        QuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'composer new laravel',
            'is_correct' => false,
        ]);
        
        QuestionOption::create([
            'question_id' => $question2->id,
            'option_text' => 'npm install laravel',
            'is_correct' => false,
        ]);
    }
}