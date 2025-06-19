@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">ผลลัพธ์</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">สรุปผลการเรียน</p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">คุณได้เรียนวิดีโอ "{{ $video->title }}" จบแล้ว</p>
        </div>

        <div class="mt-10 bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">ข้อมูลการเรียน</h3>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ชื่อวิดีโอ</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $video->title }}</dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">คะแนน</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <span class="text-2xl font-bold text-indigo-600">{{ round($score) }}%</span>
                                <span class="ml-2 text-sm text-gray-500">({{ $correctAnswers }} ถูก จาก {{ $totalQuestions }} ข้อ)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $score }}%"></div>
                            </div>
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">สถานะ</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                เรียนจบแล้ว
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">รายการคำถามและคำตอบของคุณ</h3>
            
            <div class="space-y-4">
                @foreach($video->questions as $question)
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-md font-medium text-gray-900">{{ $question->question_text }}</h4>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">แสดงที่เวลา {{ gmdate('H:i:s', $question->time_to_show) }}</p>
                        </div>
                        <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
                            <div class="space-y-2">
                                @foreach($question->options as $option)
                                    <div class="flex items-center">
                                        @php
                                            $isUserAnswer = $question->answers->isNotEmpty() && $question->answers->first()->question_option_id == $option->id;
                                            $bgClass = 'bg-white';
                                            $textClass = 'text-gray-700';
                                            
                                            if ($option->is_correct) {
                                                $bgClass = 'bg-green-50';
                                                $textClass = 'text-green-700';
                                            } elseif ($isUserAnswer && !$option->is_correct) {
                                                $bgClass = 'bg-red-50';
                                                $textClass = 'text-red-700';
                                            }
                                        @endphp
                                        
                                        <div class="flex-1 py-2 px-4 {{ $bgClass }} rounded-md {{ $textClass }}">
                                            {{ $option->option_text }}
                                            
                                            @if($option->is_correct)
                                                <span class="ml-2 text-green-500">(ตัวเลือกที่ถูกต้อง)</span>
                                            @endif
                                            
                                            @if($isUserAnswer)
                                                <span class="ml-2 text-indigo-500">(คำตอบของคุณ)</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-10 flex justify-between">
            <a href="{{ route('videos.show', $video->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                กลับไปหน้าวิดีโอ
            </a>
            <a href="{{ isset($video->course) && !empty($video->course->slug) ? route('courses.show', $video->course->slug) : route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                กลับไปหน้าคอร์ส
            </a>
        </div>
    </div>
</div>
@endsection