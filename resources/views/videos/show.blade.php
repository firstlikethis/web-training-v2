@extends('layouts.app')

@section('content')
<div class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">{{ $video->title }}</h1>
        
        <div x-data="{
            videoPlayer: null,
            currentTime: 0,
            questions: {{ json_encode($video->questions) }},
            userAnswers: {{ json_encode($userAnswers) }},
            activeQuestion: null,
            videoEnded: false,
            
            init() {
                this.videoPlayer = document.getElementById('video-player');
                this.videoPlayer.currentTime = {{ $userProgress ? $userProgress->last_position : 0 }};
                
                this.videoPlayer.addEventListener('timeupdate', () => {
                    this.currentTime = Math.floor(this.videoPlayer.currentTime);
                    this.checkForQuestions();
                    this.updateProgress();
                });
                
                this.videoPlayer.addEventListener('ended', () => {
                    this.videoEnded = true;
                    this.completeVideo();
                });
            },
            
            checkForQuestions() {
                if (this.activeQuestion) return;
                
                for (let i = 0; i < this.questions.length; i++) {
                    const question = this.questions[i];
                    if (this.currentTime >= question.time_to_show && !this.userAnswers.includes(question.id)) {
                        this.activeQuestion = question;
                        this.videoPlayer.pause();
                        break;
                    }
                }
            },
            
            updateProgress() {
                if (this.currentTime % 10 === 0) {
                    axios.post('{{ route('progress.update') }}', {
                        video_id: {{ $video->id }},
                        progress_seconds: this.currentTime,
                        last_position: this.videoPlayer.currentTime
                    });
                }
            },
            
            answerQuestion(questionId, optionId) {
                axios.post(`/questions/${questionId}/answer`, {
                    question_option_id: optionId
                }).then(response => {
                    if (response.data.success) {
                        this.userAnswers.push(questionId);
                        this.activeQuestion = null;
                        this.videoPlayer.play();
                    }
                });
            },
            
            completeVideo() {
                axios.post('{{ route('progress.update') }}', {
                    video_id: {{ $video->id }},
                    progress_seconds: this.videoPlayer.duration,
                    last_position: this.videoPlayer.duration
                }).then(response => {
                    if (response.data.completed) {
                        window.location.href = '{{ route('results.show', $video->id) }}';
                    }
                });
            }
        }" class="space-y-8">
            
            <div class="w-full aspect-w-16 aspect-h-9 bg-black rounded-lg overflow-hidden">
                <video id="video-player" class="w-full h-full object-contain" controls>
                    <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            
            <!-- Question Modal -->
            <div x-show="activeQuestion" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg max-w-lg w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4" x-text="activeQuestion ? activeQuestion.question_text : ''"></h3>
                    <div class="space-y-3">
                        <template x-for="option in activeQuestion ? activeQuestion.options : []" :key="option.id">
                            <button 
                                @click="answerQuestion(activeQuestion.id, option.id)" 
                                class="w-full py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                x-text="option.option_text"
                            ></button>
                        </template>
                    </div>
                </div>
            </div>
            
            <!-- Video finished modal -->
            <div x-show="videoEnded && !activeQuestion" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4 z-50">
                <div class="bg-white rounded-lg max-w-lg w-full p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">วิดีโอจบแล้ว</h3>
                    <p class="text-gray-500 mb-4">คุณได้ดูวิดีโอนี้จนจบแล้ว กำลังบันทึกความคืบหน้า...</p>
                    <div class="flex justify-center">
                        <svg class="animate-spin h-5 w-5 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">รายละเอียดวิดีโอ</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">ชื่อวิดีโอ</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $video->title }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">ความยาว</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ gmdate('H:i:s', $video->duration_seconds) }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">คอร์ส</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $video->course->title }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">คำอธิบาย</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $video->description }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <div class="flex justify-between">
                <a href="{{ route('courses.show', $video->course->slug) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    กลับไปหน้าคอร์ส
                </a>
                
                @if($userProgress && $userProgress->completed)
                    <a href="{{ route('results.show', $video->id) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                        ดูผลลัพธ์
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection