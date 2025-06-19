<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Course;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    protected $videoService;
    
    public function __construct(VideoService $videoService)
    {
        $this->videoService = $videoService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'video_file' => 'required|file|mimes:mp4,webm,ogg|max:102400',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);
        
        $video = new Video();
        $video->title = $validated['title'];
        $video->course_id = $validated['course_id'];
        $video->description = $validated['description'];
        $video->order = $validated['order'];
        $video->is_active = $request->has('is_active');
        
        if ($request->hasFile('video_file')) {
            $path = $request->file('video_file')->store('videos', 'public');
            $video->file_path = $path;
            
            // ดึงความยาววิดีโออัตโนมัติ
            $fullPath = Storage::disk('public')->path($path);
            $video->duration_seconds = $this->videoService->getDuration($fullPath);
        }
        
        $video->save();
        
        return redirect()->route('admin.videos.index')
            ->with('success', 'วิดีโอถูกสร้างเรียบร้อยแล้ว');
    }

    public function update(Request $request, $id)
    {
        $video = Video::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'video_file' => 'nullable|file|mimes:mp4,webm,ogg|max:102400',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
            // ไม่ต้องการฟิลด์ duration_seconds อีกต่อไป
        ]);
        
        $video->title = $validated['title'];
        $video->course_id = $validated['course_id'];
        $video->description = $validated['description'];
        $video->order = $validated['order'];
        $video->is_active = $request->has('is_active');
        
        if ($request->hasFile('video_file')) {
            // ลบไฟล์เก่า
            if ($video->file_path) {
                Storage::disk('public')->delete($video->file_path);
            }
            
            $path = $request->file('video_file')->store('videos', 'public');
            $video->file_path = $path;
            
            // ดึงความยาววิดีโออัตโนมัติ
            $fullPath = Storage::disk('public')->path($path);
            $video->duration_seconds = $this->videoService->getDuration($fullPath);
        }
        
        $video->save();
        
        return redirect()->route('admin.videos.index')
            ->with('success', 'วิดีโอถูกอัปเดตเรียบร้อยแล้ว');
    }

    public function show($id)
    {
        $video = Video::with(['questions' => function($query) {
            $query->orderBy('time_to_show');
        }, 'questions.options'])->findOrFail($id);
        
        $userProgress = auth()->user()->progress()
            ->where('video_id', $id)
            ->first();
        
        $userAnswers = auth()->user()->answers()
            ->whereHas('question', function($query) use ($id) {
                $query->where('video_id', $id);
            })
            ->pluck('question_id')
            ->toArray();
        
        return view('videos.show', compact('video', 'userProgress', 'userAnswers'));
    }
    
    public function submitAnswer(Request $request, $id)
    {
        $validated = $request->validate([
            'question_option_id' => 'required|exists:question_options,id',
        ]);
        
        $question = Question::findOrFail($id);
        $option = $question->options()->findOrFail($request->question_option_id);
        
        // Check if user already answered this question
        $existingAnswer = UserAnswer::where('user_id', auth()->id())
            ->where('question_id', $question->id)
            ->first();
        
        if ($existingAnswer) {
            return response()->json([
                'success' => false,
                'message' => 'You have already answered this question',
            ]);
        }
        
        // Save user's answer
        $answer = UserAnswer::create([
            'user_id' => auth()->id(),
            'question_id' => $question->id,
            'question_option_id' => $option->id,
            'is_correct' => $option->is_correct,
        ]);
        
        return response()->json([
            'success' => true,
            'is_correct' => $option->is_correct,
            'correct_option_id' => $question->correctOption->id ?? null,
        ]);
    }
}