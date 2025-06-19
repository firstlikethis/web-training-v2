<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function getQuestion($id)
    {
        $question = Question::with('options')->findOrFail($id);
        
        return response()->json([
            'question' => $question
        ]);
    }
    
    public function checkAnswer(Request $request, $id)
    {
        $validated = $request->validate([
            'option_id' => 'required|exists:question_options,id',
        ]);
        
        $question = Question::with('options')->findOrFail($id);
        $selectedOption = $question->options()->findOrFail($request->option_id);
        
        $isCorrect = $selectedOption->is_correct;
        
        return response()->json([
            'success' => true,
            'is_correct' => $isCorrect,
            'correct_option_id' => $question->correctOption->id ?? null,
        ]);
    }
}