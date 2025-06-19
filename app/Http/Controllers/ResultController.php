<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function show($video_id)
    {
        $video = Video::with(['questions.options', 'questions.answers' => function($query) {
            $query->where('user_id', auth()->id());
        }])->findOrFail($video_id);
        
        $userProgress = auth()->user()->progress()
            ->where('video_id', $video_id)
            ->first();
        
        if (!$userProgress || !$userProgress->completed) {
            return redirect()->route('videos.show', $video_id)
                ->with('error', 'คุณยังไม่ได้ดูวิดีโอนี้จนจบ');
        }
        
        $totalQuestions = $video->questions->count();
        $correctAnswers = 0;
        
        foreach ($video->questions as $question) {
            if ($question->answers->isNotEmpty() && $question->answers->first()->is_correct) {
                $correctAnswers++;
            }
        }
        
        $score = $totalQuestions > 0 ? ($correctAnswers / $totalQuestions) * 100 : 0;
        
        return view('videos.result', compact('video', 'score', 'correctAnswers', 'totalQuestions'));
    }
}