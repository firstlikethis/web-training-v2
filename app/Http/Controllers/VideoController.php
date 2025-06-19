<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Question;
use App\Models\UserAnswer;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class VideoController extends Controller
{
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