<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $tutor->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Tutor Information -->
                        <div class="md:col-span-2">
                            <div class="flex items-center mb-6">
                                <img class="h-24 w-24 rounded-full" src="{{ $tutor->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($tutor->name) }}" alt="{{ $tutor->name }}">
                                <div class="ml-4">
                                    <h3 class="text-2xl font-bold text-gray-900">{{ $tutor->name }}</h3>
                                    <div class="flex items-center mt-1">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="h-5 w-5 {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">({{ $totalReviews }} reviews)</span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">About</h4>
                                <p class="text-gray-600">{{ $tutor->bio }}</p>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Subjects</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tutor->subjects as $subject)
                                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-full text-sm">
                                            {{ $subject }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Recent Reviews</h4>
                                @if($recentReviews->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($recentReviews as $review)
                                            <div class="border rounded-lg p-4">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center">
                                                        <img class="h-8 w-8 rounded-full" src="{{ $review->student->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($review->student->name) }}" alt="{{ $review->student->name }}">
                                                        <span class="ml-2 font-medium">{{ $review->student->name }}</span>
                                                    </div>
                                                    <div class="flex items-center">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <svg class="h-4 w-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                            </svg>
                                                        @endfor
                                                    </div>
                                                </div>
                                                <p class="mt-2 text-gray-600">{{ $review->comment }}</p>
                                                <p class="mt-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No reviews yet</p>
                                @endif
                            </div>

                            <!-- Real-time Feedback Section -->
                            <div class="mb-6">
                                <h4 class="text-lg font-semibold text-gray-900 mb-2">Provide Feedback</h4>
                                <form action="{{ route('feedback.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                                    
                                    <div>
                                        <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                        <div class="flex items-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <button type="button" class="rating-star" data-rating="{{ $i }}">
                                                    <svg class="h-6 w-6 text-gray-300 hover:text-yellow-400 cursor-pointer" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                </button>
                                            @endfor
                                            <input type="hidden" name="rating" id="rating" required>
                                        </div>
                                    </div>

                                    <div>
                                        <label for="feedback" class="block text-sm font-medium text-gray-700">Your Feedback</label>
                                        <textarea name="feedback" id="feedback" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required placeholder="Share your experience with this tutor..."></textarea>
                                    </div>

                                    <div>
                                        <label for="session_id" class="block text-sm font-medium text-gray-700">Session (Optional)</label>
                                        <select name="session_id" id="session_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select a session</option>
                                            @foreach($completedSessions as $session)
                                                <option value="{{ $session->id }}">{{ $session->date }} - {{ $session->start_time }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Submit Feedback
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Booking Section -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-lg">
                                <h4 class="text-lg font-semibold text-gray-900 mb-4">Book a Session</h4>
                                <p class="text-2xl font-bold text-gray-900 mb-4">${{ $tutor->hourly_rate }}/hr</p>

                                <form action="{{ route('bookings.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">

                                    <div class="mb-4">
                                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>

                                    <div class="mb-4">
                                        <label for="duration" class="block text-sm font-medium text-gray-700">Duration (hours)</label>
                                        <select name="duration" id="duration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="1">1 hour</option>
                                            <option value="2">2 hours</option>
                                            <option value="3">3 hours</option>
                                        </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    </div>

                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Book Now
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script src="{{ asset('js/feedback.js') }}"></script>
@endpush 