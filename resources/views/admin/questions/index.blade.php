@extends('layouts.admin')

@section('content')
<div class="pb-5 border-b border-gray-200 sm:flex sm:items-center sm:justify-between">
    <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900">
            จัดการคำถามสำหรับวิดีโอ
        </h3>
        <p class="mt-2 text-sm text-gray-500">
            {{ $video->title }} ({{ $video->course->title }})
        </p>
    </div>
    <div class="mt-3 sm:mt-0 sm:ml-4">
        <a href="{{ route('admin.questions.create', $video->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            เพิ่มคำถามใหม่
        </a>
    </div>
</div>

@if(session('success'))
    <div class="rounded-md bg-green-50 p-4 mt-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-green-800">
                    {{ session('success') }}
                </p>
            </div>
        </div>
    </div>
@endif

<div class="mt-8">
    @if($questions->isEmpty())
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:p-6 text-center">
                <p class="text-gray-500">ยังไม่มีคำถามสำหรับวิดีโอนี้</p>
                <div class="mt-4">
                    <a href="{{ route('admin.questions.create', $video->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        เพิ่มคำถามใหม่
                    </a>
                </div>
            </div>
        </div>
    @else
        @foreach($questions as $question)
            <div class="bg-white shadow overflow-hidden sm:rounded-md mb-4">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-start">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            {{ $question->question_text }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            แสดงที่เวลา {{ gmdate('H:i:s', $question->time_to_show) }}
                        </p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.questions.edit', $question->id) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            แก้ไข
                        </a>
                        <form action="{{ route('admin.questions.destroy', $question->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจหรือไม่ที่จะลบคำถามนี้?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                ลบ
                            </button>
                        </form>
                    </div>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">ตัวเลือก</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                                    @foreach($question->options as $option)
                                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                                            <div class="w-0 flex-1 flex items-center">
                                                @if($option->is_correct)
                                                    <svg class="flex-shrink-0 h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                @else
                                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                    </svg>
                                                @endif
                                                <span class="ml-2 flex-1 w-0 truncate">
                                                    {{ $option->option_text }}
                                                </span>
                                            </div>
                                            <div class="ml-4 flex-shrink-0">
                                                @if($option->is_correct)
                                                    <span class="font-medium text-green-600">ตัวเลือกที่ถูกต้อง</span>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="mt-6">
    <a href="{{ route('admin.videos.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
        กลับไปหน้าจัดการวิดีโอ
    </a>
</div>
@endsection