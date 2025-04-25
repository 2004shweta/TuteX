<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ url('/') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    {{ __('Home') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if(auth()->user()->isStudent())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Upcoming Sessions -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Upcoming Sessions</h3>
                                @if($upcomingBookings->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($upcomingBookings as $booking)
                                            <div class="border rounded-lg p-4">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="font-medium">{{ $booking->tutor->name }}</p>
                                                        <p class="text-sm text-gray-600">{{ $booking->start_time->format('M d, Y H:i') }}</p>
                                                    </div>
                                                    <span class="px-2 py-1 text-sm rounded-full {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No upcoming sessions</p>
                                @endif
                            </div>

                            <!-- Find Tutors -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Find Tutors</h3>
                                <p class="text-gray-600 mb-4">Browse through our qualified tutors and book a session.</p>
                                <a href="{{ route('tutors.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    Browse Tutors
                                </a>
                            </div>

                            <!-- Book a Session -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Book a Session</h3>
                                <form action="{{ route('bookings.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label for="tutor_id" class="block text-sm font-medium text-gray-700">Select Tutor</label>
                                        <select name="tutor_id" id="tutor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="">Choose a tutor</option>
                                            @foreach($availableTutors as $tutor)
                                                <option value="{{ $tutor->id }}">{{ $tutor->name }} - ${{ $tutor->hourly_rate }}/hr</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="date" id="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required min="{{ date('Y-m-d') }}">
                                    </div>

                                    <div>
                                        <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                                        <input type="time" name="start_time" id="start_time" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    </div>

                                    <div>
                                        <label for="duration" class="block text-sm font-medium text-gray-700">Duration (hours)</label>
                                        <select name="duration" id="duration" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                            <option value="1">1 hour</option>
                                            <option value="2">2 hours</option>
                                            <option value="3">3 hours</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes (optional)</label>
                                        <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                    </div>

                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Book Session
                                    </button>
                                </form>
                            </div>
                        </div>
                    @elseif(auth()->user()->isTutor())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Today's Schedule -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Today's Schedule</h3>
                                @if($todayBookings->count() > 0)
                                    <div class="space-y-4">
                                        @foreach($todayBookings as $booking)
                                            <div class="border rounded-lg p-4">
                                                <div class="flex justify-between items-center">
                                                    <div>
                                                        <p class="font-medium">{{ $booking->student->name }}</p>
                                                        <p class="text-sm text-gray-600">{{ $booking->start_time->format('H:i') }} - {{ $booking->end_time->format('H:i') }}</p>
                                                    </div>
                                                    <span class="px-2 py-1 text-sm rounded-full {{ $booking->status === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($booking->status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-gray-500">No sessions scheduled for today</p>
                                @endif
                            </div>

                            <!-- Profile Stats -->
                            <div class="bg-white p-6 rounded-lg shadow">
                                <h3 class="text-lg font-semibold mb-4">Profile Stats</h3>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <p class="text-2xl font-bold text-indigo-600">{{ $totalBookings }}</p>
                                        <p class="text-sm text-gray-600">Total Sessions</p>
                                    </div>
                                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                                        <p class="text-2xl font-bold text-indigo-600">{{ $averageRating }}</p>
                                        <p class="text-sm text-gray-600">Average Rating</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 