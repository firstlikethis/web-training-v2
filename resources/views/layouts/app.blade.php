<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'ระบบเว็บฝึกอบรม') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 h-screen antialiased">
    <div id="app">
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ url('/') }}" class="font-bold text-xl text-indigo-600">
                                {{ config('app.name', 'ระบบเว็บฝึกอบรม') }}
                            </a>
                        </div>
                        
                        @auth
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('courses.index') }}" class="border-indigo-500 text-gray-900 inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium">
                                คอร์สทั้งหมด
                            </a>
                        </div>
                        @endauth
                    </div>
                    
                    <div class="flex items-center">
                        @auth
                            <div class="ml-3 relative" x-data="{ open: false }">
                                <div>
                                    <button @click="open = !open" class="max-w-xs bg-white rounded-full flex items-center text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        <span class="sr-only">เปิดเมนูผู้ใช้</span>
                                        <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-indigo-500">
                                            <span class="text-sm font-medium leading-none text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </span>
                                    </button>
                                </div>
                                <div x-show="open" @click.away="open = false" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 w-full text-left">
                                            ออกจากระบบ
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium">เข้าสู่ระบบ</a>
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        <!-- Flash Message -->
        @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4 max-w-7xl mx-auto mt-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4 max-w-7xl mx-auto mt-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
        @endif

        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>