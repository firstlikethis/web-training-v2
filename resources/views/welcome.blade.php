@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-base font-semibold text-indigo-600 tracking-wide uppercase">ระบบเว็บฝึกอบรมออนไลน์</h2>
            <p class="mt-1 text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight">เรียนรู้ได้ทุกที่ทุกเวลา</p>
            <p class="max-w-xl mt-5 mx-auto text-xl text-gray-500">เข้าถึงคอร์สเรียนคุณภาพเพื่อพัฒนาทักษะของคุณ</p>
        </div>

        <div class="mt-10 text-center">
            @auth
                <a href="{{ route('courses.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    เข้าสู่คอร์สเรียน
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                    เข้าสู่ระบบ
                </a>
            @endauth
        </div>

        <div class="mt-20">
            <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center">คุณสมบัติของระบบ</h3>
            
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">เนื้อหาวิดีโอคุณภาพสูง</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            เรียนรู้ผ่านวิดีโอที่มีคุณภาพสูง พร้อมกับระบบเล่นวิดีโอที่ออกแบบมาเพื่อการเรียนรู้โดยเฉพาะ
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">คำถามแทรกในวิดีโอ</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            คำถามจะปรากฏในระหว่างการเรียน เพื่อทดสอบความเข้าใจและเพิ่มการมีส่วนร่วมในการเรียนรู้
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6 text-center">
                        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">ติดตามความก้าวหน้า</h3>
                        <p class="mt-2 text-sm text-gray-500">
                            ระบบติดตามความก้าวหน้าในการเรียนอัตโนมัติ สามารถดูสรุปผลการเรียนและกลับมาเรียนต่อได้ทันที
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection