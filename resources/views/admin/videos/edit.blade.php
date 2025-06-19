@extends('layouts.admin')

@section('content')
<div class="pb-5 border-b border-gray-200">
    <h3 class="text-lg leading-6 font-medium text-gray-900">
        แก้ไขวิดีโอ
    </h3>
</div>

<div class="mt-10 sm:mt-0">
    <div class="md:grid md:grid-cols-3 md:gap-6">
        <div class="md:col-span-1">
            <div class="px-4 sm:px-0">
                <h3 class="text-lg font-medium leading-6 text-gray-900">ข้อมูลวิดีโอ</h3>
                <p class="mt-1 text-sm text-gray-600">
                    แก้ไขข้อมูลของวิดีโอ
                </p>
            </div>
        </div>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <form action="{{ route('admin.videos.update', $video->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="shadow overflow-hidden sm:rounded-md">
                    <div class="px-4 py-5 bg-white sm:p-6">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">ชื่อวิดีโอ</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $video->title) }}" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('title')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="course_id" class="block text-sm font-medium text-gray-700">คอร์ส</label>
                                <select id="course_id" name="course_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">เลือกคอร์ส</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id', $video->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="description" class="block text-sm font-medium text-gray-700">คำอธิบาย</label>
                                <textarea id="description" name="description" rows="3" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description', $video->description) }}</textarea>
                                @error('description')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-4">
                                <label for="video_file" class="block text-sm font-medium text-gray-700">ไฟล์วิดีโอ (เว้นว่างถ้าไม่ต้องการเปลี่ยน)</label>
                                
                                @if($video->file_path)
                                    <div class="mt-2 mb-4">
                                        <video class="h-40 w-auto rounded-md" controls>
                                            <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                        <p class="text-xs text-gray-500 mt-1">วิดีโอปัจจุบัน</p>
                                    </div>
                                @endif
                                
                                <input type="file" name="video_file" id="video_file" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('video_file')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">รองรับไฟล์ MP4, WebM, Ogg ขนาดไม่เกิน 100MB</p>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="duration_seconds" class="block text-sm font-medium text-gray-700">ความยาว (วินาที)</label>
                                <input type="number" name="duration_seconds" id="duration_seconds" value="{{ old('duration_seconds', $video->duration_seconds) }}" min="1" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('duration_seconds')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="order" class="block text-sm font-medium text-gray-700">ลำดับ</label>
                                <input type="number" name="order" id="order" value="{{ old('order', $video->order) }}" min="0" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('order')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <div class="flex items-start">
                                    <div class="flex items-center h-5">
                                        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $video->is_active) ? 'checked' : '' }} class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="is_active" class="font-medium text-gray-700">เปิดใช้งาน</label>
                                        <p class="text-gray-500">เลือกเพื่อให้วิดีโอนี้แสดงในหน้าเว็บไซต์</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <a href="{{ route('admin.videos.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 mr-2">
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
@endsection