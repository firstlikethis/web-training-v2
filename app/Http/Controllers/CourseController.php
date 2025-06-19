<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $categories = Category::with(['courses' => function($query) {
            $query->where('is_active', true);
        }])->get();
        
        return view('courses.index', compact('categories'));
    }
    
    public function show($slug)
    {
        $course = Course::where('slug', $slug)
            ->where('is_active', true)
            ->with(['videos' => function($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->firstOrFail();
        
        $userProgress = [];
        
        if (auth()->check()) {
            foreach ($course->videos as $video) {
                $progress = auth()->user()->progress()
                    ->where('video_id', $video->id)
                    ->first();
                
                $userProgress[$video->id] = $progress ? $progress->completed : false;
            }
        }
        
        return view('courses.show', compact('course', 'userProgress'));
    }
}