<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('category')->latest()->paginate(10);
        return view('admin.courses.index', compact('courses'));
    }
    
    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $course = new Course();
        $course->title = $validated['title'];
        $course->slug = Str::slug($validated['title']);
        $course->category_id = $validated['category_id'];
        $course->description = $validated['description'];
        $course->is_active = $request->has('is_active');
        
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $course->thumbnail = $path;
        }
        
        $course->save();
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'คอร์สถูกสร้างเรียบร้อยแล้ว');
    }
    
    public function edit($id)
    {
        $course = Course::findOrFail($id);
        $categories = Category::all();
        return view('admin.courses.edit', compact('course', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
        ]);
        
        $course->title = $validated['title'];
        $course->slug = Str::slug($validated['title']);
        $course->category_id = $validated['category_id'];
        $course->description = $validated['description'];
        $course->is_active = $request->has('is_active');
        
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $course->thumbnail = $path;
        }
        
        $course->save();
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'คอร์สถูกอัปเดตเรียบร้อยแล้ว');
    }
    
    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        
        // Delete thumbnail if exists
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }
        
        $course->delete();
        
        return redirect()->route('admin.courses.index')
            ->with('success', 'คอร์สถูกลบเรียบร้อยแล้ว');
    }
}