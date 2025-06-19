@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-indigo-800 to-purple-800 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-900/80 to-purple-900/80"></div>
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800">
                    <path fill="none" stroke="white" stroke-width="1.5" d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63"></path>
                    <path fill="none" stroke="white" stroke-width="1.5" d="M-31 229L237 261 390 382 731 737M520 660L309 538"></path>
                    <path fill="none" stroke="white" stroke-width="1.5" d="M520 660L309 538"></path>
                    <circle cx="769" cy="229" r="5" fill="white" stroke="white"></circle>
                    <circle cx="539" cy="269" r="5" fill="white" stroke="white"></circle>
                    <circle cx="603" cy="493" r="5" fill="white" stroke="white"></circle>
                    <circle cx="731" cy="737" r="5" fill="white" stroke="white"></circle>
                    <circle cx="520" cy="660" r="5" fill="white" stroke="white"></circle>
                    <circle cx="309" cy="538" r="5" fill="white" stroke="white"></circle>
                    <circle cx="295" cy="764" r="5" fill="white" stroke="white"></circle>
                    <circle cx="40" cy="599" r="5" fill="white" stroke="white"></circle>
                    <circle cx="102" cy="382" r="5" fill="white" stroke="white"></circle>
                    <circle cx="127" cy="80" r="5" fill="white" stroke="white"></circle>
                    <circle cx="370" cy="105" r="5" fill="white" stroke="white"></circle>
                    <circle cx="578" cy="42" r="5" fill="white" stroke="white"></circle>
                    <circle cx="237" cy="261" r="5" fill="white" stroke="white"></circle>
                    <circle cx="390" cy="382" r="5" fill="white" stroke="white"></circle>
                </svg>
            </div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
            <div class="relative">
                <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">
                    <span class="block mb-1 animate-fade-in-up" style="animation-delay: 0.1s">ระบบเว็บฝึกอบรมออนไลน์</span>
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-purple-300 to-indigo-300 opacity-0 animate-fade-in-up" style="animation-delay: 0.5s">ที่ออกแบบมาเพื่อคุณ</span>
                </h1>
                <p class="mt-6 max-w-3xl text-xl text-indigo-100 opacity-0 animate-fade-in-up" style="animation-delay: 0.9s">
                    เรียนรู้ได้ทุกที่ทุกเวลา เข้าถึงคอร์สเรียนคุณภาพเพื่อพัฒนาทักษะของคุณอย่างไม่มีขีดจำกัด
                </p>
                <div class="mt-10 flex items-center gap-x-6 opacity-0 animate-fade-in-up" style="animation-delay: 1.3s">
                    @auth
                        <a href="{{ route('courses.index') }}" class="group relative overflow-hidden rounded-lg bg-white px-6 py-3 text-lg font-semibold text-indigo-800 shadow-md">
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative inline-flex items-center">
                                เข้าสู่คอร์สเรียน
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative overflow-hidden rounded-lg bg-white px-6 py-3 text-lg font-semibold text-indigo-800 shadow-md">
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative inline-flex items-center">
                                เข้าสู่ระบบ
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </a>
                    @endauth
                    <a href="{{ route('courses.index') }}" class="text-lg font-semibold text-white hover:text-indigo-200 transition-colors duration-200 flex items-center group">
                        <span>ดูคอร์สทั้งหมด</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Filter Section -->
    <div class="bg-white py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-block px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-2">หมวดหมู่</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    เลือกหมวดหมู่ที่คุณสนใจ
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">
                    มีคอร์สที่หลากหลายให้คุณได้เลือกเรียนตามความสนใจ
                </p>
            </div>
            
            <div class="mt-10 mx-auto max-w-4xl">
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('courses.index') }}" class="group inline-flex overflow-hidden items-center px-5 py-2.5 border-2 border-indigo-500 rounded-full text-sm font-medium text-indigo-700 bg-indigo-50 shadow-sm transition-all duration-200 hover:bg-indigo-600 hover:text-white hover:shadow">
                        <span class="relative z-10">ทั้งหมด</span>
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('courses.index', ['category' => $category->id]) }}" 
                           class="group overflow-hidden inline-flex items-center px-5 py-2.5 border-2 border-gray-200 rounded-full text-sm font-medium text-gray-700 bg-white shadow-sm transition-all duration-200 hover:border-indigo-500 hover:bg-indigo-600 hover:text-white hover:shadow">
                            <span class="relative z-10">{{ $category->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Courses Section -->
    @if(isset($featuredCourses) && $featuredCourses->count() > 0)
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-block px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-2">คอร์สแนะนำ</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    เริ่มต้นการเรียนรู้ของคุณ
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">
                    คอร์สยอดนิยมที่ผู้ใช้งานให้ความสนใจ
                </p>
            </div>

            <div class="mt-12 grid gap-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($featuredCourses as $course)
                <div class="group relative bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
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
                        <div class="flex items-center justify-between mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                {{ $course->category->name }}
                            </span>
                            <div class="flex items-center text-yellow-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <span class="ml-1 text-sm font-medium">ยอดนิยม</span>
                            </div>
                        </div>
                        <div class="block mt-2">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-indigo-600 transition-colors duration-200 line-clamp-2">{{ $course->title }}</h3>
                            <p class="mt-3 text-base text-gray-500 line-clamp-3">{{ Str::limit($course->description, 100) }}</p>
                        </div>
                        <div class="mt-4 flex items-center justify-between">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-500">{{ $course->videos->count() }} บทเรียน</span>
                            </div>
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <span class="ml-1 text-sm text-gray-500">เหมาะสำหรับทุกระดับ</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="mt-12 text-center">
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border-2 border-indigo-600 rounded-lg shadow-sm text-base font-medium text-indigo-700 bg-white hover:bg-indigo-600 hover:text-white transition-colors duration-200">
                    ดูคอร์สทั้งหมด
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <span class="inline-block px-3 py-1 text-sm font-semibold text-indigo-600 bg-indigo-100 rounded-full mb-2">คุณสมบัติของระบบ</span>
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    ออกแบบมาเพื่อการเรียนรู้ที่ดีที่สุด
                </h2>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500">
                    ระบบเว็บฝึกอบรมที่มีคุณสมบัติครบครัน พร้อมให้คุณใช้งานได้อย่างมีประสิทธิภาพ
                </p>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    <div class="bg-gradient-to-br from-white to-indigo-50 overflow-hidden rounded-xl shadow-lg border border-indigo-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="px-6 py-8">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white mx-auto mb-6">
                                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 text-center mb-3">เนื้อหาวิดีโอคุณภาพสูง</h3>
                            <p class="text-base text-gray-600 text-center">
                                เรียนรู้ผ่านวิดีโอที่มีคุณภาพสูง พร้อมกับระบบเล่นวิดีโอที่ออกแบบมาเพื่อการเรียนรู้โดยเฉพาะ
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                            <div class="h-1.5 w-10 bg-white/30 rounded-full mx-auto"></div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-white to-indigo-50 overflow-hidden rounded-xl shadow-lg border border-indigo-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="px-6 py-8">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white mx-auto mb-6">
                                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 text-center mb-3">คำถามแทรกในวิดีโอ</h3>
                            <p class="text-base text-gray-600 text-center">
                                คำถามจะปรากฏในระหว่างการเรียน เพื่อทดสอบความเข้าใจและเพิ่มการมีส่วนร่วมในการเรียนรู้
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                            <div class="h-1.5 w-10 bg-white/30 rounded-full mx-auto"></div>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-white to-indigo-50 overflow-hidden rounded-xl shadow-lg border border-indigo-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <div class="px-6 py-8">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white mx-auto mb-6">
                                <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 text-center mb-3">ติดตามความก้าวหน้า</h3>
                            <p class="text-base text-gray-600 text-center">
                                ระบบติดตามความก้าวหน้าในการเรียนอัตโนมัติ สามารถดูสรุปผลการเรียนและกลับมาเรียนต่อได้ทันที
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600">
                            <div class="h-1.5 w-10 bg-white/30 rounded-full mx-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA Section -->
    <div class="relative overflow-hidden bg-gradient-to-r from-indigo-700 to-purple-700">
        <div class="absolute inset-0 opacity-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800">
                <path fill="none" stroke="white" stroke-width="1.5" d="M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 295 764 126.5 879.5 40 599-197 493 102 382-31 229 126.5 79.5-69-63"></path>
                <path fill="none" stroke="white" stroke-width="1.5" d="M-31 229L237 261 390 382 731 737M520 660L309 538"></path>
                <path fill="none" stroke="white" stroke-width="1.5" d="M520 660L309 538"></path>
                <circle cx="769" cy="229" r="5" fill="white" stroke="white"></circle>
                <circle cx="539" cy="269" r="5" fill="white" stroke="white"></circle>
                <circle cx="603" cy="493" r="5" fill="white" stroke="white"></circle>
                <circle cx="731" cy="737" r="5" fill="white" stroke="white"></circle>
                <circle cx="520" cy="660" r="5" fill="white" stroke="white"></circle>
                <circle cx="309" cy="538" r="5" fill="white" stroke="white"></circle>
                <circle cx="295" cy="764" r="5" fill="white" stroke="white"></circle>
                <circle cx="40" cy="599" r="5" fill="white" stroke="white"></circle>
                <circle cx="102" cy="382" r="5" fill="white" stroke="white"></circle>
                <circle cx="127" cy="80" r="5" fill="white" stroke="white"></circle>
                <circle cx="370" cy="105" r="5" fill="white" stroke="white"></circle>
                <circle cx="578" cy="42" r="5" fill="white" stroke="white"></circle>
                <circle cx="237" cy="261" r="5" fill="white" stroke="white"></circle>
                <circle cx="390" cy="382" r="5" fill="white" stroke="white"></circle>
            </svg>
        </div>
        <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8 relative">
            <div class="lg:grid lg:grid-cols-2 lg:gap-8 items-center">
                <div>
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                        <span class="block">พร้อมเริ่มการเรียนรู้?</span>
                        <span class="block text-indigo-200 mt-1">เริ่มต้นใช้งานระบบวันนี้</span>
                    </h2>
                    <p class="mt-4 text-lg text-indigo-100 max-w-3xl">
                        ค้นพบคอร์สเรียนที่ตรงกับความสนใจของคุณ และเริ่มต้นพัฒนาทักษะได้ทันที ไม่ว่าคุณจะอยู่ที่ไหน เวลาใด ก็สามารถเข้าถึงการเรียนรู้ได้ตลอดเวลา
                    </p>
                </div>
                <div class="mt-12 lg:mt-0 flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 justify-center lg:justify-end">
                    @auth
                        <a href="{{ route('courses.index') }}" class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden rounded-lg bg-white text-lg font-bold text-indigo-700 shadow-2xl transition-all duration-300 ease-out hover:shadow-indigo-500/30">
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative flex items-center">
                                เข้าสู่คอร์สเรียน
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="group relative inline-flex items-center justify-center px-8 py-4 overflow-hidden rounded-lg bg-white text-lg font-bold text-indigo-700 shadow-2xl transition-all duration-300 ease-out hover:shadow-indigo-500/30">
                            <span class="absolute inset-0 bg-gradient-to-r from-indigo-100 to-purple-100 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></span>
                            <span class="relative flex items-center">
                                เข้าสู่ระบบ
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform duration-200" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </a>
                    @endauth
                    <a href="{{ route('courses.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 border border-transparent rounded-lg text-lg font-bold text-white hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-700/30 transition-all duration-200">
                        <span class="flex items-center">
                            ดูคอร์สทั้งหมด
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .animate-fade-in-up {
        animation: fade-in-up 0.5s ease forwards;
    }
</style>
@endsection