<?php

namespace App\Services;

use FFMpeg\FFMpeg;
use FFMpeg\FFProbe;
use Illuminate\Http\UploadedFile;

class VideoService
{
    /**
     * ดึงความยาวของวิดีโอในวินาที
     */
    public function getDuration(string $path): int
    {
        try {
            $ffprobe = FFProbe::create();
            $duration = $ffprobe
                ->format($path)
                ->get('duration');
            
            return (int) round($duration);
        } catch (\Exception $e) {
            return 300;
        }
    }
}