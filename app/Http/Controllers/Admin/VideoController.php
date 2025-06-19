<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index()
    {
        $videos = Video::with('course')->latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }
    
    public function create()
    {
        $courses = Course::all();
        return view('admin.videos.create', compact('courses'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'video_file' => 'required|file|mimes:mp4,webm,ogg|max:102400',
            'duration_seconds' => 'required|integer|min:1',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        $video = new Video();
        $video->title = $validated['title'];
        $video->course_id = $validated['course_id'];
        $video->description = $validated['description'];
        $video->duration_seconds = $validated['duration_seconds'];
        $video->order = $validated['order'];
        $video->is_active = $request->has('is_active');
        
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('videos', 'public');
            $video->file_path = $path;
        }
        
        $video->save();
        
        return redirect()->route('admin.videos.index')
            ->with('success', 'วิดีโอถูกสร้างเรียบร้อยแล้ว');
    }
    
    public function edit($id)
    {
        $video = Video::findOrFail($id);
        $courses = Course::all();
        return view('admin.videos.edit', compact('video', 'courses'));
    }
    
    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
            'duration_seconds' => 'required|integer|min:1',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        $video->title = $validated['title'];
        $video->course_id = $validated['course_id'];
        $video->description = $validated['description'];
        $video->duration_seconds = $validated['duration_seconds'];
        $video->order = $validated['order'];
        $video->is_active = $request->has('is_active');
        
        if ($request->hasFile('video_file')) {
            // Delete old video
            if ($video->file_path) {
                Storage::disk('public')->delete($video->file_path);
            }
            
            $path = $request->file('video_file')->store('videos', 'public');
            $video->file_path = $path;
        }
        
        $video->save();
        
        return redirect()->route('admin.videos.index')
            ->with('success', 'วิดีโอถูกอัปเดตเรียบร้อยแล้ว');
    }
    
    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        
        // Delete video file if exists
        if ($video->file_path) {
            Storage::disk('public')->delete($video->file_path);
        }
        
        $video->delete();
        
        return redirect()->route('admin.videos.index')
            ->with('success', 'วิดีโอถูกลบเรียบร้อยแล้ว');
    }
}