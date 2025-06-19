@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">คอร์สเรียนออนไลน์</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">คอร์สทั้งหมด</p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">เลือกคอร์สที่คุณสนใจเพื่อเริ่มต้นการเรียนรู้</p>
        </div>

        <div class="mt-12">
            @foreach($categories as $category)
                @if($category->courses->isNotEmpty())
                    <div class="mb-10">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">{{ $category->name }}</h3>
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($category->courses as $course)
                                <div class="bg-white overflow-hidden shadow rounded-lg">
                                    <div class="relative pb-2/3">
                                        @if($course->thumbnail)
                                            <img class="absolute h-full w-full object-cover" src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                                        @else
                                            <div class="absolute h-full w-full bg-gray-200 flex items-center justify-center">
                                                <svg class="h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="px-4 py-5 sm:p-6">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $course->title }}</h4>
                                        <p class="mt-1 text-sm text-gray-500">{{ Str::limit($course->description, 100) }}</p>
                                        <div class="mt-4">
                                            <a href="{{ !empty($course->slug) ? route('courses.show', $course->slug) : route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                                                เข้าเรียน
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endsection