@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-indigo-800 to-blue-700">
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/90 to-blue-900/80"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-indigo-900/30"></div>
            <div class="absolute inset-0">
                <svg class="absolute right-0 top-0 h-full w-full" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                    <defs>
                        <pattern id="dots" width="40" height="40" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="1" fill="rgba(255,255,255,0.1)"></circle>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#dots)"></rect>
                </svg>
            </div>
        </div>
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">ระบบเว็บฝึกอบรมออนไลน์</h1>
            <p class="mt-6 text-xl text-indigo-100 max-w-3xl">เรียนรู้ได้ทุกที่ทุกเวลา เข้าถึงคอร์สเรียนคุณภาพเพื่อพัฒนาทักษะของคุณ</p>
            <div class="mt-10 flex items-center gap-x-6">
                @auth
                    <a href="{{ route('courses.index') }}" class="rounded-md bg-white px-4 py-3 text-base font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 transition-colors duration-200">
                        เข้าสู่คอร์สเรียน
                    </a>
                @else
                    <a href="{{ route('login') }}" class="rounded-md bg-white px-4 py-3 text-base font-semibold text-indigo-700 shadow-sm hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-indigo-600 transition-colors duration-200">
                        เข้าสู่ระบบ
                    </a>
                @endauth
                <a href="{{ route('courses.index') }}" class="text-base font-semibold leading-6 text-white hover:text-indigo-200 transition-colors duration-200">ดูคอร์สทั้งหมด <span aria-hidden="true">→</span></a>
            </div>
        </div>
    </div>

    <!-- Category Filter Section -->
    <div class="bg-white py-10 border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">หมวดหมู่</h2>
                <p class="mt-1 text-2xl font-extrabold text-gray-900">เลือกหมวดหมู่ที่คุณสนใจ</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-4 py-2 border border-indigo-500 rounded-full text-sm font-medium text-indigo-700 bg-indigo-50 hover:bg-indigo-100 transition-all duration-200">
                    ทั้งหมด
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('courses.index', ['category' => $category->id]) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-full text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-indigo-300 hover:text-indigo-600 transition-all duration-200">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Featured Courses Section -->
    @if(isset($featuredCourses) && $featuredCourses->count() > 0)
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">คอร์สแนะนำ</h2>
                <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">เริ่มต้นการเรียนรู้ของคุณ</p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">คอร์สยอดนิยมที่ผู้ใช้งานให้ความสนใจ</p>
            </div>

            <div class="mt-12 grid gap-8 md:grid-cols-2 lg:grid-cols-3">
                @foreach($featuredCourses as $course)
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
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-indigo-600 rounded-md shadow-sm text-base font-medium text-indigo-700 bg-white hover:bg-indigo-50 transition-colors duration-200">
                    ดูคอร์สทั้งหมด
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Features Section -->
    <div class="py-16 bg-white sm:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">คุณสมบัติของระบบ</h2>
                <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">ออกแบบมาเพื่อการเรียนรู้ที่ดีที่สุด</p>
                <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">ระบบเว็บฝึกอบรมที่มีคุณสมบัติครบครัน</p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-gradient-to-br from-gray-50 to-white overflow-hidden shadow-lg rounded-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300 hover:border-indigo-200">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-indigo-500 text-white">
                                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 text-xl font-semibold text-gray-900">เนื้อหาวิดีโอคุณภาพสูง</h3>
                            <p class="mt-3 text-base text-gray-500">
                                เรียนรู้ผ่านวิดีโอที่มีคุณภาพสูง พร้อมกับระบบเล่นวิดีโอที่ออกแบบมาเพื่อการเรียนรู้โดยเฉพาะ
                            </p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-50 to-white overflow-hidden shadow-lg rounded-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300 hover:border-indigo-200">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-indigo-500 text-white">
                                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 text-xl font-semibold text-gray-900">คำถามแทรกในวิดีโอ</h3>
                            <p class="mt-3 text-base text-gray-500">
                                คำถามจะปรากฏในระหว่างการเรียน เพื่อทดสอบความเข้าใจและเพิ่มการมีส่วนร่วมในการเรียนรู้
                            </p>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-50 to-white overflow-hidden shadow-lg rounded-lg border border-gray-200 hover:shadow-xl transition-shadow duration-300 hover:border-indigo-200">
                        <div class="px-4 py-5 sm:p-6 text-center">
                            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-full bg-indigo-500 text-white">
                                <svg class="h-7 w-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="mt-5 text-xl font-semibold text-gray-900">ติดตามความก้าวหน้า</h3>
                            <p class="mt-3 text-base text-gray-500">
                                ระบบติดตามความก้าวหน้าในการเรียนอัตโนมัติ สามารถดูสรุปผลการเรียนและกลับมาเรียนต่อได้ทันที
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="bg-indigo-700">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
            <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                <span class="block">พร้อมเริ่มการเรียนรู้?</span>
                <span class="block text-indigo-200">เริ่มต้นใช้งานระบบวันนี้</span>
            </h2>
            <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                <div class="inline-flex rounded-md shadow">
                    @auth
                        <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 transition-colors duration-200">
                            เข้าสู่คอร์สเรียน
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-indigo-600 bg-white hover:bg-indigo-50 transition-colors duration-200">
                            เข้าสู่ระบบ
                        </a>
                    @endauth
                </div>
                <div class="ml-3 inline-flex rounded-md shadow">
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 transition-colors duration-200">
                        ดูคอร์สทั้งหมด
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection