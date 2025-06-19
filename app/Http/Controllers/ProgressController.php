<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\UserProgress;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'video_id' => 'required|exists:videos,id',
            'progress_seconds' => 'required|numeric|min:0',
            'last_position' => 'required|numeric|min:0',
        ]);
        
        $video = Video::findOrFail($request->video_id);
        
        // Mark as completed if progress is more than 90% of video duration
        $completed = false;
        if ($request->progress_seconds >= ($video->duration_seconds * 0.9)) {
            $completed = true;
        }
        
        $progress = UserProgress::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'video_id' => $request->video_id,
            ],
            [
                'progress_seconds' => $request->progress_seconds,
                'last_position' => $request->last_position,
                'completed' => $completed,
            ]
        );
        
        return response()->json([
            'success' => true,
            'completed' => $completed,
        ]);
    }
}