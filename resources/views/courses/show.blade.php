@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-start lg:space-x-8">
            <div class="lg:w-1/4">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">{{ $course->title }}</h2>
                <p class="text-gray-600 mb-6">{{ $course->description }}</p>
                <div class="bg-gray-100 p-4 rounded-lg mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">หมวดหมู่</h3>
                    <p class="text-gray-600">{{ $course->category->name }}</p>
                </div>
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">ความคืบหน้า</h3>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        @php
                            $completedCount = count(array_filter($userProgress, function($completed) { return $completed; }));
                            $totalVideos = count($course->videos);
                            $progressPercentage = $totalVideos > 0 ? ($completedCount / $totalVideos) * 100 : 0;
                        @endphp
                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $completedCount }} จาก {{ $totalVideos }} วิดีโอ</p>
                </div>
            </div>
            <div class="mt-8 lg:mt-0 lg:w-3/4">
                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul role="list" class="divide-y divide-gray-200">
                        @foreach($course->videos as $video)
                            <li>
                                <a href="{{ route('videos.show', $video->id) }}" class="block hover:bg-gray-50">
                                    <div class="px-4 py-4 sm:px-6">
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-medium text-indigo-600 truncate">
                                                {{ $video->title }}
                                            </p>
                                            <div class="ml-2 flex-shrink-0 flex">
                                                @if(isset($userProgress[$video->id]) && $userProgress[$video->id])
                                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                        เรียนจบแล้ว
                                                    </p>
                                                @else
                                                    <p class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                        ยังไม่ได้เรียน
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mt-2 flex justify-between">
                                            <div class="sm:flex">
                                                <p class="flex items-center text-sm text-gray-500">
                                                    <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ gmdate('H:i:s', $video->duration_seconds) }}
                                                </p>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $video->questions->count() }} คำถาม
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection