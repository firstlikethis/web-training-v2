@extends('layouts.app')

@section('content')
<div class="bg-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">คอร์สเรียนออนไลน์</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">คอร์สทั้งหมด</p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">เลือกคอร์สที่คุณสนใจเพื่อเริ่มต้นการเรียนรู้</p>
        </div>

        <!-- Category Filter -->
        <div class="mt-10 border-b border-gray-200 pb-5">
            <h3 class="text-lg font-medium text-gray-900 mb-4">กรองตามหมวดหมู่</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 border {{ !isset($selectedCategory) ? 'border-indigo-600 bg-indigo-50 text-indigo-700' : 'border-gray-300 bg-white text-gray-700' }} rounded-full text-sm font-medium hover:bg-gray-50 transition-colors duration-150">
                    ทั้งหมด
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('courses.index', ['category' => $category->id]) }}" class="inline-flex items-center px-4 py-2 border {{ isset($selectedCategory) && $selectedCategory == $category->id ? 'border-indigo-600 bg-indigo-50 text-indigo-700' : 'border-gray-300 bg-white text-gray-700' }} rounded-full text-sm font-medium hover:bg-gray-50 transition-colors duration-150">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Courses Grid -->
        <div class="mt-10">
            @if(isset($selectedCategory))
                <div class="mb-6">
                    <p class="text-sm text-gray-500">
                        กำลังแสดงคอร์สในหมวดหมู่: 
                        <span class="font-medium text-indigo-600">
                            {{ $categories->find($selectedCategory)->name }}
                        </span>
                        <a href="{{ route('courses.index') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 transition-colors duration-150">
                            (ล้างตัวกรอง)
                        </a>
                    </p>
                </div>
            @endif

            <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($courses as $course)
                    <div class="group relative bg-white border border-gray-200 rounded-lg overflow-hidden shadow-md hover:shadow-xl transition-all duration-300">
                        <div class="aspect-w-16 aspect-h-9 bg-gray-200 overflow-hidden relative">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <!-- เพิ่มปุ่ม Start -->
                            <div class="absolute inset-0 bg-indigo-900/70 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ !empty($course->slug) ? (auth()->check() ? route('courses.show', $course->slug) : route('login')) : route('courses.index') }}" class="px-5 py-3 bg-white text-indigo-700 rounded-md font-semibold transform scale-90 group-hover:scale-100 transition-transform duration-300">
                                    เริ่มเรียน
                                </a>
                            </div>
                        </div>
                        <div class="p-6">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $course->category->name }}
                            </span>
                            <div class="block mt-2">
                                <h3 class="text-xl font-semibold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200">{{ $course->title }}</h3>
                                <p class="mt-3 text-base text-gray-500">{{ Str::limit($course->description, 100) }}</p>
                            </div>
                            
                            @auth
                                @php
                                    $completedVideos = 0;
                                    $totalVideos = $course->videos->count();
                                    
                                    foreach ($course->videos as $video) {
                                        $progress = auth()->user()->progress()->where('video_id', $video->id)->first();
                                        if ($progress && $progress->completed) {
                                            $completedVideos++;
                                        }
                                    }
                                    
                                    $progressPercentage = $totalVideos > 0 ? ($completedVideos / $totalVideos) * 100 : 0;
                                @endphp
                                
                                @if($totalVideos > 0)
                                    <div class="mt-4">
                                        <div class="flex items-center justify-between text-sm">
                                            <span class="text-gray-500">ความคืบหน้า</span>
                                            <span class="text-indigo-600 font-medium">{{ $completedVideos }}/{{ $totalVideos }} วิดีโอ</span>
                                        </div>
                                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-indigo-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                                        </div>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 flex flex-col items-center justify-center">
                        <svg class="h-16 w-16 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">ไม่พบคอร์สเรียน</h3>
                        <p class="mt-1 text-base text-gray-500">ยังไม่มีคอร์สเรียนในหมวดหมู่นี้</p>
                        <a href="{{ route('courses.index') }}" class="mt-4 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors duration-150">
                            ดูคอร์สทั้งหมด
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection