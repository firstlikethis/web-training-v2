@extends('layouts.admin')

@section('content')
<div class="pb-5 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        แก้ไขคำถาม
    </h3>
    <p class="mt-2 text-sm text-gray-500">
        สำหรับวิดีโอ: {{ $question->video->title }}
    </p>
</div>

<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">ข้อมูลคำถาม</h3>
                <p class="mt-1 text-sm text-gray-600">
                    แก้ไขข้อมูลของคำถาม
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('admin.questions.update', $question->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="question_text" class="block text-sm font-medium text-gray-700">คำถาม</label>
                                <textarea id="question_text" name="question_text" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('question_text', $question->question_text) }}</textarea>
                                @error('question_text')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="time_to_show" class="block text-sm font-medium text-gray-700">เวลาที่แสดง (วินาที)</label>
                                <input type="number" name="time_to_show" id="time_to_show" value="{{ old('time_to_show', $question->time_to_show) }}" min="0" max="{{ $question->video->duration_seconds }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('time_to_show')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">
                                    ความยาววิดีโอ: {{ gmdate('H:i:s', $question->video->duration_seconds) }} ({{ $question->video->duration_seconds }} วินาที)
                                </p>
                            </div>

                            <div class="col-span-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">ตัวเลือก</h4>
                                <div class="space-y-3" id="options-container">
                                    @foreach($question->options as $index => $option)
                                        <div class="grid grid-cols-12 gap-3 items-center option-row">
                                            <div class="col-span-10">
                                                <input type="text" name="options[{{ $index }}][text]" value="{{ old('options.'.$index.'.text', $option->option_text) }}" placeholder="ตัวเลือกที่ {{ $index + 1 }}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                                <input type="hidden" name="options[{{ $index }}][id]" value="{{ $option->id }}">
                                            </div>
                                            <div class="col-span-2">
                                                <div class="flex items-center">
                                                    <input type="radio" id="correct_option_{{ $index }}" name="correct_option" value="{{ $index }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300" {{ $option->is_correct ? 'checked' : '' }}>
                                                    <label for="correct_option_{{ $index }}" class="ml-2 block text-sm text-gray-700">ถูกต้อง</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-3">
                                    <button type="button" id="add-option" class="inline-flex items-center px-3 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200">
                                        + เพิ่มตัวเลือก
                                    </button>
                                </div>
                                @error('options')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @error('options.*.text')
                                    <p class="mt-2 text-sm text-red-600">กรุณากรอกข้อความสำหรับทุกตัวเลือก</p>
                                @enderror
                                @error('correct_option')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.questions.index', $question->video_id) }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 mr-2">
                            ยกเลิก
                        </a>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            อัปเดต
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const optionsContainer = document.getElementById('options-container');
        const addOptionButton = document.getElementById('add-option');
        let optionCount = {{ count($question->options) }}; // Start with existing options count
        
        addOptionButton.addEventListener('click', function() {
            const newOptionRow = document.createElement('div');
            newOptionRow.className = 'grid grid-cols-12 gap-3 items-center option-row';
            newOptionRow.innerHTML = `
                <div class="col-span-10">
                    <input type="text" name="options[${optionCount}][text]" placeholder="ตัวเลือกที่ ${optionCount + 1}" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                </div>
                <div class="col-span-2">
                    <div class="flex items-center">
                        <input type="radio" id="correct_option_${optionCount}" name="correct_option" value="${optionCount}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                        <label for="correct_option_${optionCount}" class="ml-2 block text-sm text-gray-700">ถูกต้อง</label>
                    </div>
                </div>
            `;
            optionsContainer.appendChild(newOptionRow);
            optionCount++;
        });
    });
</script>
@endsection