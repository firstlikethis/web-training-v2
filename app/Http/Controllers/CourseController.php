<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->query('category');
        
        $categories = Category::all();
        
        $coursesQuery = Course::where('is_active', true)->with('category')->with('videos');
        
        if ($selectedCategory) {
            $coursesQuery->where('category_id', $selectedCategory);
        }
        
        $courses = $coursesQuery->get();
        
        return view('courses.index', compact('categories', 'courses', 'selectedCategory'));
    }
    
    public function show($slug)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error('Error in CourseController@show: ' . $e->getMessage());
            return redirect()->route('courses.index')->with('error', 'ไม่พบคอร์สที่คุณต้องการ');
        }
    }
    
    public function featured()
    {
        $featuredCourses = Course::where('is_active', true)
            ->with('category')
            ->latest()
            ->take(6)
            ->get();
            
        $categories = Category::all();
        
        return view('welcome', compact('featuredCourses', 'categories'));
    }
}