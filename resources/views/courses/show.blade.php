@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-start lg:space-x-8">
            <div class="lg:w-1/3 mb-8 lg:mb-0">
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-indigo-50 to-purple-50">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="h-20 w-20 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $course->title }}</h2>
                        <div class="flex items-center mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $course->category->name }}
                            </span>
                            <span class="ml-2 text-sm text-gray-500">{{ $course->videos->count() }} บทเรียน</span>
                        </div>
                        <p class="text-gray-600 mb-6">{{ $course->description }}</p>
                        
                        <div class="bg-indigo-50 rounded-lg p-4 mb-4">
                            <h3 class="text-lg font-semibold text-indigo-800 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                                </svg>
                                ความคืบหน้าคอร์ส
                            </h3>
                            <div class="w-full bg-white rounded-full h-3 mb-2 overflow-hidden shadow-inner">
                                @php
                                    $completedCount = count(array_filter($userProgress, function($completed) { return $completed; }));
                                    $totalVideos = count($course->videos);
                                    $progressPercentage = $totalVideos > 0 ? ($completedCount / $totalVideos) * 100 : 0;
                                @endphp
                                <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-3 rounded-full transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <p class="text-sm text-indigo-700 font-medium">
                                {{ $completedCount }} จาก {{ $totalVideos }} บทเรียน ({{ round($progressPercentage) }}%)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:w-2/3">
                <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M7 3a1 1 0 000 2h6a1 1 0 100-2H7zM4 7a1 1 0 011-1h10a1 1 0 110 2H5a1 1 0 01-1-1zM2 11a2 2 0 012-2h12a2 2 0 012 2v4a2 2 0 01-2 2H4a2 2 0 01-2-2v-4z" />
                            </svg>
                            บทเรียนทั้งหมด
                        </h3>
                    </div>
                    
                    <ul class="divide-y divide-gray-200">
                        @foreach($course->videos as $index => $video)
                            @php
                                $progress = auth()->user()->progress()->where('video_id', $video->id)->first();
                                $isLocked = false;
                                $previousCompleted = true;
                                
                                // ตรวจสอบว่าบทเรียนก่อนหน้าเรียนจบหรือยัง
                                if ($video->order > 1) {
                                    $previousVideos = $video->course->videos()
                                        ->where('order', '<', $video->order)
                                        ->orderBy('order', 'asc')
                                        ->get();
                                        
                                    foreach ($previousVideos as $prevVideo) {
                                        $prevProgress = auth()->user()->progress()
                                            ->where('video_id', $prevVideo->id)
                                            ->where('completed', true)
                                            ->first();
                                            
                                        if (!$prevProgress) {
                                            $previousCompleted = false;
                                            break;
                                        }
                                    }
                                }
                                
                                $isLocked = !$previousCompleted;
                            @endphp
                            
                            <li class="group hover:bg-indigo-50 transition-colors duration-150">
                                @if($isLocked)
                                    <div class="block">
                                        <div class="px-6 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-gray-100 text-gray-400 flex-shrink-0">
                                                        <span class="text-sm font-medium">{{ $index + 1 }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-400">
                                                            {{ $video->title }}
                                                        </p>
                                                        <p class="text-xs text-gray-400 mt-1 line-clamp-1">
                                                            {{ Str::limit($video->description, 80) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="ml-2 flex-shrink-0 flex items-center space-x-4">
                                                    <div class="flex items-center text-sm text-gray-400">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ gmdate('H:i:s', $video->duration_seconds) }}
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                            <svg class="-ml-0.5 mr-1.5 h-3.5 w-3.5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                                                            </svg>
                                                            ล็อค
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 sm:flex sm:justify-between">
                                                <div class="sm:flex">
                                                    <p class="flex items-center text-sm text-gray-400">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $video->questions->count() }} คำถาม
                                                    </p>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-gray-400 sm:mt-0 sm:ml-4">
                                                    <span class="font-medium">ต้องเรียนบทก่อนหน้าให้จบก่อน</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('videos.show', $video->id) }}" 
                                    class="block">
                                        <div class="px-6 py-4 sm:px-6">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-3">
                                                    <div class="flex items-center justify-center h-10 w-10 rounded-full bg-indigo-100 text-indigo-600 flex-shrink-0">
                                                        <span class="text-sm font-medium">{{ $index + 1 }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-sm font-medium text-gray-900 group-hover:text-indigo-600 transition-colors duration-150">
                                                            {{ $video->title }}
                                                        </p>
                                                        <p class="text-xs text-gray-500 mt-1 line-clamp-1">
                                                            {{ Str::limit($video->description, 80) }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="ml-2 flex-shrink-0 flex items-center space-x-4">
                                                    <div class="flex items-center text-sm text-gray-500">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ gmdate('H:i:s', $video->duration_seconds) }}
                                                    </div>
                                                    <div class="flex-shrink-0">
                                                        @if(isset($userProgress[$video->id]) && $userProgress[$video->id])
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="-ml-0.5 mr-1.5 h-3 w-3 text-green-500" fill="currentColor" viewBox="0 0 8 8">
                                                                    <circle cx="4" cy="4" r="3" />
                                                                </svg>
                                                                เรียนจบแล้ว
                                                            </span>
                                                        @else
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                <svg class="-ml-0.5 mr-1.5 h-3 w-3 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                                                                    <circle cx="4" cy="4" r="3" />
                                                                </svg>
                                                                ยังไม่ได้เรียน
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2 sm:flex sm:justify-between">
                                                <div class="sm:flex">
                                                    <p class="flex items-center text-sm text-gray-500">
                                                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                        </svg>
                                                        {{ $video->questions->count() }} คำถาม
                                                    </p>
                                                </div>
                                                <div class="mt-2 flex items-center text-sm text-indigo-600 sm:mt-0 sm:ml-4">
                                                    <span class="font-medium">เข้าเรียน</span>
                                                    <svg class="ml-1 h-5 w-5 text-indigo-500 group-hover:translate-x-1 transition-transform duration-200" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    
                    <!-- Empty State -->
                    @if($course->videos->isEmpty())
                    <div class="flex flex-col items-center justify-center py-12 px-6 text-center bg-gray-50">
                        <div class="bg-white p-4 rounded-full shadow-inner mb-4">
                            <svg class="w-16 h-16 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">ยังไม่มีบทเรียนในคอร์สนี้</h3>
                        <p class="mt-1 text-sm text-gray-500">บทเรียนกำลังอยู่ในระหว่างการสร้าง กรุณากลับมาตรวจสอบในภายหลัง</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="mt-10 flex justify-between">
            <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                กลับไปหน้าคอร์สทั้งหมด
            </a>
            
            @if($course->videos->isNotEmpty())
                @php
                    $firstVideo = $course->videos->sortBy('order')->first();
                @endphp
                <a href="{{ route('videos.show', $firstVideo->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                    เริ่มเรียนทันที
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            @endif
        </div>
    </div>
</div>
@endsection