@extends('layouts.app')

@section('content')
<div class="py-10 bg-gray-50">
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
                        <span class="ml-2 text-gray-900 font-medium">{{ $video->title }}</span>
                    </li>
                </ol>
            </nav>
        </div>
        
        <h1 class="text-2xl font-bold text-gray-900 mb-8">{{ $video->title }}</h1>
        
        <div x-data="{
            videoPlayer: null,
            currentTime: 0,
            questions: {{ json_encode($video->questions) }},
            userAnswers: {{ json_encode($userAnswers) }},
            activeQuestion: null,
            videoEnded: false,
            progressUpdatePending: false,
            lastProgressUpdate: 0,
            isFullscreen: false,
            showControls: true,
            controlsTimeout: null,
            
            init() {
                this.videoPlayer = document.getElementById('video-player');

                this.videoPlayer.addEventListener('loadedmetadata', () => {
                    if ({{ $userProgress && $userProgress->last_position > 0 ? 'true' : 'false' }}) {
                        let savedPosition = {{ $userProgress ? $userProgress->last_position : 0 }};
                        
                        if (savedPosition < this.videoPlayer.duration) {
                            this.videoPlayer.currentTime = savedPosition;
                            console.log('Resumed video at position: ' + savedPosition);
                        }
                    }
                });
                
                this.videoPlayer.addEventListener('timeupdate', () => {
                    this.currentTime = Math.floor(this.videoPlayer.currentTime);
                    this.checkForQuestions();
                    this.updateProgress();
                });
                
                this.videoPlayer.addEventListener('pause', () => {
                    // บันทึกทันทีเมื่อมีการหยุดวิดีโอ
                    this.saveProgress(false);
                    this.showControls = true;
                    clearTimeout(this.controlsTimeout);
                });
                
                this.videoPlayer.addEventListener('play', () => {
                    this.hideControlsAfterDelay();
                });
                
                this.videoPlayer.addEventListener('ended', () => {
                    this.videoEnded = true;
                    this.completeVideo();
                    this.showControls = true;
                });
                
                this.videoPlayer.addEventListener('mousemove', () => {
                    this.showControls = true;
                    this.hideControlsAfterDelay();
                });
                
                // เพิ่ม event listener เมื่อออกจากหน้า
                window.addEventListener('beforeunload', () => {
                    this.saveProgress(false);
                });
                
                // ตั้งเวลาบันทึกความคืบหน้าทุก 30 วินาที แม้ไม่มีการ interact
                setInterval(() => {
                    if (!this.videoPlayer.paused) {
                        this.saveProgress(false);
                    }
                }, 30000);
                
                // ตรวจสอบการเปลี่ยนแปลงสถานะ fullscreen
                document.addEventListener('fullscreenchange', () => {
                    this.isFullscreen = !!document.fullscreenElement;
                });
            },
            
            hideControlsAfterDelay() {
                clearTimeout(this.controlsTimeout);
                this.controlsTimeout = setTimeout(() => {
                    if (!this.videoPlayer.paused && !this.activeQuestion) {
                        this.showControls = false;
                    }
                }, 3000);
            },
            
            toggleFullscreen() {
                if (!document.fullscreenElement) {
                    const videoContainer = document.getElementById('video-container');
                    if (videoContainer.requestFullscreen) {
                        videoContainer.requestFullscreen();
                    } else if (videoContainer.webkitRequestFullscreen) {
                        videoContainer.webkitRequestFullscreen();
                    } else if (videoContainer.msRequestFullscreen) {
                        videoContainer.msRequestFullscreen();
                    }
                } else {
                    if (document.exitFullscreen) {
                        document.exitFullscreen();
                    } else if (document.webkitExitFullscreen) {
                        document.webkitExitFullscreen();
                    } else if (document.msExitFullscreen) {
                        document.msExitFullscreen();
                    }
                }
            },
            
            checkForQuestions() {
                if (this.activeQuestion) return;
                
                for (let i = 0; i < this.questions.length; i++) {
                    const question = this.questions[i];
                    if (this.currentTime >= question.time_to_show && !this.userAnswers.includes(question.id)) {
                        this.activeQuestion = question;
                        this.videoPlayer.pause();
                        // บันทึกความคืบหน้าเมื่อพบคำถาม
                        this.saveProgress(false);
                        break;
                    }
                }
            },
            
            formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = Math.floor(seconds % 60);
                return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            },
            
            updateProgress() {
                // บันทึกทุก 5 วินาที หรือเมื่อเวลาเปลี่ยนไปมากกว่า 5 วินาที
                if (this.currentTime % 5 === 0 && this.lastProgressUpdate !== this.currentTime) {
                    this.saveProgress(true);
                    this.lastProgressUpdate = this.currentTime;
                }
            },
            
            saveProgress(throttled) {
                // ป้องกันการส่งข้อมูลซ้ำๆ ในเวลาใกล้เคียงกัน
                if (this.progressUpdatePending) return;
                
                this.progressUpdatePending = true;
                
                axios.post('{{ route('progress.update') }}', {
                    video_id: {{ $video->id }},
                    progress_seconds: this.currentTime,
                    last_position: this.videoPlayer.currentTime
                }).then(response => {
                    console.log('Progress updated successfully:', response.data);
                    this.progressUpdatePending = false;
                }).catch(error => {
                    console.error('Failed to update progress:', error);
                    this.progressUpdatePending = false;
                    
                    // กรณีเกิดข้อผิดพลาด ลองใหม่หลังจากผ่านไป 10 วินาที
                    if (throttled) {
                        setTimeout(() => {
                            this.saveProgress(false);
                        }, 10000);
                    }
                });
            },
            
            answerQuestion(questionId, optionId) {
                axios.post(`/questions/${questionId}/answer`, {
                    question_option_id: optionId
                }).then(response => {
                    if (response.data.success) {
                        this.userAnswers.push(questionId);
                        this.activeQuestion = null;
                        this.videoPlayer.play();
                        // บันทึกความคืบหน้าหลังตอบคำถาม
                        this.saveProgress(false);
                    }
                }).catch(error => {
                    console.error('Failed to submit answer:', error);
                });
            },
            
            completeVideo() {
                this.saveProgress(false);
                
                axios.post('{{ route('progress.update') }}', {
                    video_id: {{ $video->id }},
                    progress_seconds: this.videoPlayer.duration,
                    last_position: this.videoPlayer.duration
                }).then(response => {
                    console.log('Video completed:', response.data);
                    if (response.data.completed) {
                        window.location.href = '{{ route('results.show', $video->id) }}';
                    }
                }).catch(error => {
                    console.error('Failed to complete video:', error);
                    // กรณีเกิดข้อผิดพลาด ลองใหม่หลังจากผ่านไป 3 วินาที
                    setTimeout(() => {
                        this.completeVideo();
                    }, 3000);
                });
            }
        }" class="space-y-8">
            
            <div id="video-container" class="relative bg-black rounded-xl overflow-hidden shadow-xl" 
                 @mousemove="showControls = true; hideControlsAfterDelay()">
                <!-- Video Player -->
                <div class="w-full aspect-w-16 aspect-h-9">
                    <video id="video-player" class="w-full h-full object-contain" preload="metadata">
                        <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
                
                <!-- Custom Video Controls -->
                <div class="absolute inset-0 flex flex-col justify-end"
                     :class="{ 'opacity-0': !showControls && !videoPlayer.paused }"
                     @click="videoPlayer.paused ? videoPlayer.play() : videoPlayer.pause()"
                     class="transition-opacity duration-300">
                    <div class="p-4 bg-gradient-to-t from-black/70 to-transparent" 
                        @click.stop>
                        <!-- Progress Bar -->
                        <div class="w-full h-1.5 bg-gray-600 rounded-full mb-4 cursor-pointer relative group"
                            @click.stop="videoPlayer.currentTime = ($event.offsetX / $event.target.offsetWidth) * videoPlayer.duration">
                            <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full"
                                :style="{ width: (videoPlayer.currentTime / videoPlayer.duration) * 100 + '%' }">
                            </div>
                            <!-- Hover Effect -->
                            <div class="absolute top-0 left-0 h-1.5 w-full rounded-full bg-gradient-to-r from-indigo-400/0 via-indigo-400/30 to-indigo-400/0 opacity-0 group-hover:opacity-100 transform translate-y-0 group-hover:-translate-y-1 transition-all duration-200"></div>
                        </div>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <!-- Play/Pause Button -->
                                <button @click.stop="videoPlayer.paused ? videoPlayer.play() : videoPlayer.pause()" 
                                    class="text-white focus:outline-none transform hover:scale-110 transition-transform duration-200">
                                    <svg x-show="videoPlayer && videoPlayer.paused" class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg x-show="videoPlayer && !videoPlayer.paused" class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                                
                                <!-- Time Display -->
                                <div class="text-white text-sm font-medium">
                                    <span x-text="formatTime(videoPlayer?.currentTime || 0)"></span> / <span x-text="formatTime(videoPlayer?.duration || 0)"></span>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-4">
                                <!-- Fullscreen Button -->
                                <button @click.stop="toggleFullscreen()" class="text-white focus:outline-none transform hover:scale-110 transition-transform duration-200">
                                    <svg x-show="!isFullscreen" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h4a1 1 0 010 2H6.414l2.293 2.293a1 1 0 11-1.414 1.414L5 6.414V8a1 1 0 01-2 0V4zm9 1a1 1 0 010-2h4a1 1 0 011 1v4a1 1 0 01-2 0V6.414l-2.293 2.293a1 1 0 11-1.414-1.414L13.586 5H12zm-9 7a1 1 0 012 0v1.586l2.293-2.293a1 1 0 111.414 1.414L6.414 15H8a1 1 0 010 2H4a1 1 0 01-1-1v-4zm13-1a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 010-2h1.586l-2.293-2.293a1 1 0 111.414-1.414L15 13.586V12a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <svg x-show="isFullscreen" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M5 4a1 1 0 00-1 1v4a1 1 0 01-2 0V4a3 3 0 013-3h4a1 1 0 010 2H5zm10 0a1 1 0 00-1 1v4a1 1 0 102 0V4a1 1 0 00-1-1zM5 16a1 1 0 001-1v-4a1 1 0 10-2 0v4a1 1 0 001 1zm10 0a1 1 0 001-1v-4a1 1 0 10-2 0v4a1 1 0 001 1z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Question Modal -->
            <div x-show="activeQuestion" x-cloak
                class="fixed inset-0 bg-black/75 flex items-center justify-center p-4 z-50"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <div class="bg-white rounded-xl max-w-2xl w-full p-8 shadow-2xl" @click.stop>
                    <div class="mb-2 text-indigo-600 font-medium">คำถาม</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6" x-text="activeQuestion ? activeQuestion.question_text : ''"></h3>
                    <div class="space-y-3">
                        <template x-for="option in activeQuestion ? activeQuestion.options : []" :key="option.id">
                            <button 
                                @click="answerQuestion(activeQuestion.id, option.id)" 
                                class="w-full py-3 px-6 border-2 border-gray-300 rounded-lg shadow-sm bg-white text-base font-medium text-gray-700 hover:bg-indigo-50 hover:border-indigo-300 hover:text-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200"
                                x-text="option.option_text"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Video finished modal -->
            <div x-show="videoEnded && !activeQuestion" x-cloak
                class="fixed inset-0 bg-black/75 flex items-center justify-center p-4 z-50"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95">
                <div class="bg-white rounded-xl max-w-md w-full p-8 shadow-2xl text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
                        <svg class="h-6 w-6 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">วิดีโอจบแล้ว</h3>
                    <p class="text-gray-500 mb-6">คุณได้ดูวิดีโอนี้จนจบแล้ว กำลังบันทึกความคืบหน้า...</p>
                    <div class="flex justify-center items-center">
                        <svg class="animate-spin h-5 w-5 text-indigo-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm text-gray-700">กำลังนำไปยังหน้าสรุปผล...</span>
                    </div>
                </div>
            </div>
            
            <!-- Video Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-2 bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <h3 class="text-lg font-semibold">รายละเอียดวิดีโอ</h3>
                    </div>
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">{{ $video->title }}</h2>
                        <div class="prose max-w-none text-gray-600 mb-4">
                            {{ $video->description }}
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>ความยาว: {{ gmdate('H:i:s', $video->duration_seconds) }}</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>คำถาม: {{ $video->questions->count() }} ข้อ</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Course Navigation -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 h-fit">
                    <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white">
                        <h3 class="text-lg font-semibold">คอร์ส: {{ $video->course->title }}</h3>
                    </div>
                    <div class="p-4">
                        <div class="text-sm text-gray-500 mb-3">บทเรียนในคอร์สนี้:</div>
                        <ul class="space-y-2">
                            @foreach($video->course->videos()->orderBy('order')->get() as $courseVideo)
                                @php
                                    $progress = auth()->user()->progress()->where('video_id', $courseVideo->id)->first();
                                    $isLocked = false;
                                    $previousCompleted = true;
                                    
                                    // ตรวจสอบว่าบทเรียนก่อนหน้าเรียนจบหรือยัง
                                    if ($courseVideo->order > 1) {
                                        $previousVideos = $video->course->videos()
                                            ->where('order', '<', $courseVideo->order)
                                            ->orderBy('order', 'asc')
                                            ->get();
                                            
                                        foreach ($previousVideos as $prevVideo) {
                                            $prevProgress = auth()->user()->progress()
                                                ->where('video_id', $prevVideo->id)
                                                ->where('completed', true)
                                                ->first();
                                                
                                            if (!$prevProgress) {
                                                $previousCompleted = false;
                                                break;
                                            }
                                        }
                                    }
                                    
                                    $isLocked = !$previousCompleted;
                                @endphp
                                
                                <li>
                                    @if($isLocked)
                                        <div class="flex items-center p-2 rounded-lg text-gray-400 bg-gray-50 cursor-not-allowed">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center bg-gray-200 text-gray-400 mr-3">
                                                {{ $loop->iteration }}
                                            </div>
                                            <div class="flex-1 truncate">{{ $courseVideo->title }}</div>
                                            <div class="ml-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                    <svg class="h-3.5 w-3.5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                    </svg>
                                                    ล็อค
                                                </span>
                                            </div>
                                        </div>
                                    @else
                                        <a href="{{ route('videos.show', $courseVideo->id) }}" 
                                        class="flex items-center p-2 rounded-lg {{ $video->id == $courseVideo->id ? 'bg-indigo-50 text-indigo-700 font-medium' : 'text-gray-700 hover:bg-gray-50' }} transition-colors duration-150">
                                            <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $video->id == $courseVideo->id ? 'bg-indigo-100 text-indigo-700' : 'bg-gray-100 text-gray-600' }} mr-3">
                                                {{ $loop->iteration }}
                                            </div>
                                            <div class="flex-1 truncate">{{ $courseVideo->title }}</div>
                                            @if($progress && $progress->completed)
                                                <div class="ml-2 text-green-500" title="เรียนจบแล้ว">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </a>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ isset($video->course) && !empty($video->course->slug) ? route('courses.show', $video->course->slug) : route('courses.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                    </svg>
                    กลับไปหน้าคอร์ส
                </a>
                
                @if($userProgress && $userProgress->completed)
                    <a href="{{ route('results.show', $video->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150">
                        ดูผลลัพธ์
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    /* Hide the native video controls when our custom controls are active */
    #video-player::-webkit-media-controls {
        display: none !important;
    }
    
    [x-cloak] { 
        display: none !important; 
    }
</style>
@endsection