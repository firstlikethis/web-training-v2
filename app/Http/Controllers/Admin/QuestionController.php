<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Video;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index($video_id)
    {
        $video = Video::findOrFail($video_id);
        $questions = Question::where('video_id', $video_id)
            ->with('options')
            ->orderBy('time_to_show')
            ->get();
        
        return view('admin.questions.index', compact('video', 'questions'));
    }
    
    public function create($video_id)
    {
        $video = Video::findOrFail($video_id);
        return view('admin.questions.create', compact('video'));
    }
    
    public function store(Request $request, $video_id)
    {
        $video = Video::findOrFail($video_id);
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'time_to_show' => 'required|integer|min:0|max:' . $video->duration_seconds,
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'correct_option' => 'required|integer|min:0',
        ]);
        
        $question = Question::create([
            'video_id' => $video_id,
            'question_text' => $validated['question_text'],
            'time_to_show' => $validated['time_to_show'],
        ]);
        
        foreach ($validated['options'] as $key => $option) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $option['text'],
                'is_correct' => $key == $validated['correct_option'],
            ]);
        }
        
        return redirect()->route('admin.questions.index', $video_id)
            ->with('success', 'คำถามถูกสร้างเรียบร้อยแล้ว');
    }
    
    public function edit($id)
    {
        $question = Question::with('options', 'video')->findOrFail($id);
        return view('admin.questions.edit', compact('question'));
    }
    
    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);
        $video = $question->video;
        
        $validated = $request->validate([
            'question_text' => 'required|string',
            'time_to_show' => 'required|integer|min:0|max:' . $video->duration_seconds,
            'options' => 'required|array|min:2',
            'options.*.text' => 'required|string',
            'options.*.id' => 'nullable|exists:question_options,id',
            'correct_option' => 'required|integer|min:0',
        ]);
        
        $question->question_text = $validated['question_text'];
        $question->time_to_show = $validated['time_to_show'];
        $question->save();
        
        // Delete existing options
        $question->options()->delete();
        
        // Create new options
        foreach ($validated['options'] as $key => $option) {
            QuestionOption::create([
                'question_id' => $question->id,
                'option_text' => $option['text'],
                'is_correct' => $key == $validated['correct_option'],
            ]);
        }
        
        return redirect()->route('admin.questions.index', $question->video_id)
            ->with('success', 'คำถามถูกอัปเดตเรียบร้อยแล้ว');
    }
    
    public function destroy($id)
    {
        $question = Question::findOrFail($id);
        $video_id = $question->video_id;
        
        $question->delete();
        
        return redirect()->route('admin.questions.index', $video_id)
            ->with('success', 'คำถามถูกลบเรียบร้อยแล้ว');
    }
}