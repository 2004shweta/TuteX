<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Booking Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Session Details</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date & Time</p>
                                    <p class="mt-1 text-gray-900">
                                        {{ $booking->start_time->format('l, F j, Y') }}<br>
                                        {{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Status</p>
                                    <p class="mt-1">
                                        <span class="px-3 py-1 text-sm rounded-full 
                                            @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Amount</p>
                                    <p class="mt-1 text-gray-900">${{ number_format($booking->amount, 2) }}</p>
                                </div>

                                @if($booking->notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-500">Notes</p>
                                        <p class="mt-1 text-gray-900">{{ $booking->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Participant Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Participants</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Tutor</p>
                                    <div class="mt-2 flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="{{ $booking->tutor->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($booking->tutor->name) }}" alt="{{ $booking->tutor->name }}">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $booking->tutor->name }}</p>
                                            <p class="text-sm text-gray-500">{{ implode(', ', $booking->tutor->subjects ?? []) }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <p class="text-sm font-medium text-gray-500">Student</p>
                                    <div class="mt-2 flex items-center">
                                        <img class="h-10 w-10 rounded-full" src="{{ $booking->student->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($booking->student->name) }}" alt="{{ $booking->student->name }}">
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">{{ $booking->student->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $booking->student->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-3">
                        @if($booking->status === 'pending' && auth()->user()->isTutor())
                            <form action="{{ route('bookings.confirm', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Confirm Booking
                                </button>
                            </form>
                        @endif

                        @if(in_array($booking->status, ['pending', 'confirmed']))
                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Back to Bookings
                        </a>
                    </div>

                    <!-- Review Section -->
                    @if($booking->status === 'completed' && !$booking->review && auth()->user()->isStudent())
                        <div class="mt-8 border-t pt-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Leave a Review</h3>
                            <form action="{{ route('reviews.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                <input type="hidden" name="tutor_id" value="{{ $booking->tutor_id }}">

                                <div class="mb-4">
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating</label>
                                    <select name="rating" id="rating" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a rating</option>
                                        <option value="5">5 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="2">2 Stars</option>
                                        <option value="1">1 Star</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <label for="comment" class="block text-sm font-medium text-gray-700">Comment</label>
                                    <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                                </div>

                                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Submit Review
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 