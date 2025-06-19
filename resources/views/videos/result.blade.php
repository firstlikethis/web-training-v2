@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('courses.index') }}" class="hover:text-gray-700">คอร์สทั้งหมด</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('courses.show', $video->course->slug) }}" class="ml-2 hover:text-gray-700">{{ $video->course->title }}</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('videos.show', $video->id) }}" class="ml-2 hover:text-gray-700">{{ $video->title }}</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2 text-gray-900 font-medium">สรุปผล</span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="text-center mb-10">
            <span class="inline-block px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-2">ผลลัพธ์</span>
            <h2 class="text-3xl font-bold text-gray-900 sm:text-4xl">สรุปผลการเรียน</h2>
            <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">คุณได้เรียนวิดีโอ "{{ $video->title }}" จบแล้ว</p>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Score Card -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-10 transform transition-all duration-300 hover:shadow-2xl">
                <div class="px-8 py-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-500 mb-1">คะแนนของคุณ</h3>
                            <div class="flex items-end">
                                <span class="text-6xl font-bold text-indigo-600">{{ round($score) }}%</span>
                                <span class="ml-4 text-gray-500 text-lg">({{ $correctAnswers }} ถูก จาก {{ $totalQuestions }} ข้อ)</span>
                            </div>
                            <div class="mt-4">
                                @if($score >= 80)
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>ดีเยี่ยม</span>
                                    </div>
                                @elseif($score >= 60)
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                        </svg>
                                        <span>ดี</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                        </svg>
                                        <span>ต้องปรับปรุง</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div>
                            <div class="relative pt-5">
                                <div class="overflow-hidden h-5 text-xs flex rounded-full bg-gray-200">
                                    <div class="w-full bg-gradient-to-r from-indigo-500 to-purple-600 shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center transition-all duration-1000 ease-out" style="width: {{ $score }}%"></div>
                                </div>
                                <div class="mt-4 flex justify-between">
                                    <div class="text-xs text-gray-400">0%</div>
                                    <div class="text-xs text-gray-400">50%</div>
                                    <div class="text-xs text-gray-400">100%</div>
                                </div>
                            </div>
                            <div class="mt-6 flex justify-center">
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5 text-indigo-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                                    </svg>
                                    <span>บทเรียนเรียนจบแล้ว</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                    <div class="h-1.5 w-16 bg-white/30 rounded-full mx-auto"></div>
                </div>
            </div>

            <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                รายการคำถามและคำตอบของคุณ
            </h3>
            
            <div class="space-y-6">
                @foreach($video->questions as $index => $question)
                    <div class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="px-6 py-4 bg-gradient-to-r {{ $question->answers->isNotEmpty() && $question->answers->first()->is_correct ? 'from-green-600 to-emerald-600' : 'from-yellow-600 to-amber-600' }} text-white">
                            <h4 class="text-lg font-medium flex items-center">
                                <span class="flex-shrink-0 h-7 w-7 flex items-center justify-center rounded-full bg-white/20 mr-2 text-sm font-medium">
                                    {{ $index + 1 }}
                                </span>
                                <span>{{ $question->question_text }}</span>
                            </h4>
                            <p class="mt-1 text-sm text-white/80">แสดงที่เวลา {{ gmdate('H:i:s', $question->time_to_show) }}</p>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($question->options as $option)
                                    @php
                                        $isUserAnswer = $question->answers->isNotEmpty() && $question->answers->first()->question_option_id == $option->id;
                                        $bgClass = 'bg-white border-gray-200';
                                        $borderClass = 'border';
                                        $textClass = 'text-gray-700';
                                        
                                        if ($option->is_correct) {
                                            $bgClass = 'bg-green-50 border-green-200';
                                            $borderClass = 'border-2';
                                            $textClass = 'text-green-700';
                                        } elseif ($isUserAnswer && !$option->is_correct) {
                                            $bgClass = 'bg-red-50 border-red-200';
                                            $borderClass = 'border-2';
                                            $textClass = 'text-red-700';
                                        }
                                    @endphp
                                    
                                    <div class="flex items-center {{ $borderClass }} {{ $bgClass }} rounded-lg p-4 {{ $textClass }}">
                                        @if($option->is_correct)
                                            <svg class="h-5 w-5 text-green-500 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                            </svg>
                                        @elseif($isUserAnswer && !$option->is_correct)
                                            <svg class="h-5 w-5 text-red-500 mr-3 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <div class="h-5 w-5 border border-gray-300 rounded-full mr-3 flex-shrink-0"></div>
                                        @endif
                                        
                                        <div class="flex-1">
                                            {{ $option->option_text }}
                                        </div>
                                        
                                        <div class="ml-4 flex items-center">
                                            @if($option->is_correct)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    ตัวเลือกที่ถูกต้อง
                                                </span>
                                            @endif
                                            
                                            @if($isUserAnswer)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 ml-2">
                                                    คำตอบของคุณ
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if($question->answers->isNotEmpty() && !$question->answers->first()->is_correct)
                                <div class="mt-4 p-4 border border-yellow-200 rounded-lg bg-yellow-50">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800">เกร็ดความรู้</h3>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p>
                                                    คำตอบที่ถูกต้องคือ "{{ $question->correctOption->option_text }}" ลองทบทวนเนื้อหาในส่วนนี้เพื่อความเข้าใจมากขึ้น
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10 flex justify-between">
                <a href="{{ route('videos.show', $video->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10 12.796V3.204L4.519 8 10 12.796zm-.659.753l-5.48-4.796a1 1 0 010-1.506l5.48-4.796A1 1 0 0111 3.204v9.592a1 1 0 01-1.659.753z" />
                    </svg>
                    กลับไปหน้าวิดีโอ
                </a>
                <a href="{{ isset($video->course) && !empty($video->course->slug) ? route('courses.show', $video->course->slug) : route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                    กลับไปหน้าคอร์ส
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection