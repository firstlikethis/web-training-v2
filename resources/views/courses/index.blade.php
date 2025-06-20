@extends('layouts.app')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <span class="inline-block px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-2">คอร์สเรียนออนไลน์</span>
            <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">คอร์สทั้งหมด</h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">เลือกคอร์สที่คุณสนใจเพื่อเริ่มต้นการเรียนรู้</p>
        </div>

        <!-- Category Filter -->
        <div class="mt-10">
            <div class="flex flex-col items-center space-y-4">
                <h3 class="text-lg font-semibold text-gray-900 self-start sm:self-center">กรองตามหมวดหมู่</h3>
                <div class="flex flex-wrap justify-center gap-3">
                    <a href="{{ route('courses.index') }}" 
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 shadow-sm 
                        {{ !isset($selectedCategory) ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300' }}">
                        ทั้งหมด
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('courses.index', ['category' => $category->id]) }}" 
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 shadow-sm 
                            {{ isset($selectedCategory) && $selectedCategory == $category->id ? 'bg-gradient-to-r from-indigo-600 to-purple-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Selected Category Info -->
        @if(isset($selectedCategory))
            <div class="mt-8 bg-indigo-50 rounded-lg p-4 max-w-3xl mx-auto">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-indigo-100 rounded-full p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-indigo-700">
                            กำลังแสดงคอร์สในหมวดหมู่: 
                            <span class="font-medium">
                                {{ $categories->find($selectedCategory)->name }}
                            </span>
                            <a href="{{ route('courses.index') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 transition-colors duration-150 inline-flex items-center">
                                <span>ล้างตัวกรอง</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Courses Grid -->
        <div class="mt-10">
            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($courses as $course)
                    <div data-aos="fade-up" class="group relative bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 overflow-hidden relative">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-indigo-50 to-purple-50">
                                    <svg class="h-16 w-16 text-indigo-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- Overlay -->
                            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/80 to-purple-900/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-all duration-300">
                                <a href="{{ !empty($course->slug) ? (auth()->check() ? route('courses.show', $course->slug) : route('login')) : route('courses.index') }}" 
                                   class="px-6 py-3 bg-white text-indigo-700 rounded-lg font-semibold transform -translate-y-3 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300 shadow-lg hover:bg-indigo-50">
                                    เริ่มเรียน
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $course->category->name }}
                            </span>
                            <div class="block mt-2">
                                <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">{{ $course->title }}</h3>
                                <p class="mt-3 text-base text-gray-500 line-clamp-3">{{ Str::limit($course->description, 100) }}</p>
                            </div>
                            
                            @auth
                                @php
                                    $completedVideos = 0;
                                    $totalVideos = $course->videos->count();
                                    $lockedVideos = 0;
                                    
                                    if ($totalVideos > 0) {
                                        foreach ($course->videos as $video) {
                                            $progress = auth()->user()->progress()->where('video_id', $video->id)->first();
                                            
                                            if ($progress && $progress->completed) {
                                                $completedVideos++;
                                            }
                                            
                                            if ($video->order > 1) {
                                                $previousVideo = $course->videos->where('order', $video->order - 1)->first();
                                                if ($previousVideo) {
                                                    $prevProgress = auth()->user()->progress()
                                                        ->where('video_id', $previousVideo->id)
                                                        ->where('completed', true)
                                                        ->first();
                                                        
                                                    if (!$prevProgress) {
                                                        $lockedVideos++;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    
                                    $progressPercentage = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;
                                @endphp
                                
                                @if($totalVideos > 0)
                                    <div class="mt-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500">ความคืบหน้า</span>
                                            <span class="text-indigo-600 font-medium">{{ $completedVideos }}/{{ $totalVideos }} บทเรียน</span>
                                        </div>
                                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                                            <div class="bg-gradient-to-r from-indigo-500 to-purple-600 h-2 rounded-full transition-all duration-500 ease-out" style="width: {{ $progressPercentage }}%"></div>
                                        </div>
                                        
                                        @if($lockedVideos > 0)
                                            <div class="flex items-center mt-2 text-xs text-gray-500">
                                                <svg class="h-3.5 w-3.5 mr-1 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                <span>{{ $lockedVideos }} บทเรียนถูกล็อค</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endauth

                            <div class="mt-4 flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="ml-1 text-sm text-gray-500">{{ $course->videos->count() }} บทเรียน</span>
                                </div>
                                <a href="{{ !empty($course->slug) ? (auth()->check() ? route('courses.show', $course->slug) : route('login')) : route('courses.index') }}" 
                                   class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center group">
                                    <span>ดูรายละเอียด</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 flex flex-col items-center justify-center">
                        <div class="bg-indigo-50 rounded-full p-6 mb-4">
                            <svg class="h-16 w-16 text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">ไม่พบคอร์สเรียน</h3>
                        <p class="text-base text-gray-500 text-center mb-6">ยังไม่มีคอร์สเรียนในหมวดหมู่นี้</p>
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center px-5 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            ดูคอร์สทั้งหมด
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection