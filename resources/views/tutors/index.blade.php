<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Find Tutors') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tutors Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @if($tutors->isEmpty())
                    <div class="col-span-full text-center py-8">
                        <h3 class="text-lg font-medium text-gray-900">No tutors available at the moment</h3>
                        <p class="mt-2 text-sm text-gray-500">Please check back later for available tutors.</p>
                    </div>
                @else
                    @foreach($tutors as $tutor)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img class="h-12 w-12 rounded-full" src="{{ $tutor->profile_picture ?? 'https://ui-avatars.com/api/?name=' . urlencode($tutor->name) }}" alt="{{ $tutor->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-medium text-gray-900">{{ $tutor->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ implode(', ', $tutor->subjects ?? []) }}</p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="flex items-center">
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="h-5 w-5 {{ $i <= $tutor->reviewsAsTutor()->avg('rating') ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="ml-2 text-sm text-gray-600">
                                            ({{ $tutor->reviewsAsTutor()->count() }} reviews)
                                        </span>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-600">{{ Str::limit($tutor->bio, 100) }}</p>
                                    <div class="mt-4 flex justify-between items-center">
                                        <span class="text-lg font-semibold text-gray-900">${{ $tutor->hourly_rate }}/hr</span>
                                    </div>

                                    <!-- Available Slots -->
                                    <div class="mt-4">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Available Slots (Next 7 Days)</h4>
                                        <div class="grid grid-cols-2 gap-2">
                                            @php
                                                $availableSlots = [];
                                                $bookedSlots = $tutor->bookingsAsTutor->pluck('start_time')->toArray();
                                                
                                                // Generate available slots for next 7 days
                                                for ($i = 0; $i < 7; $i++) {
                                                    $date = now()->addDays($i);
                                                    for ($hour = 9; $hour < 17; $hour++) {
                                                        $slot = $date->copy()->setHour($hour)->setMinute(0);
                                                        if (!in_array($slot->format('Y-m-d H:i:s'), $bookedSlots)) {
                                                            $availableSlots[] = $slot;
                                                        }
                                                    }
                                                }
                                                
                                                // Limit to 14 slots (2 per day)
                                                $availableSlots = array_slice($availableSlots, 0, 14);
                                            @endphp

                                            @foreach($availableSlots as $slot)
                                                <form action="{{ route('bookings.store') }}" method="POST" class="inline">
                                                    @csrf
                                                    <input type="hidden" name="tutor_id" value="{{ $tutor->id }}">
                                                    <input type="hidden" name="date" value="{{ $slot->format('Y-m-d') }}">
                                                    <input type="hidden" name="start_time" value="{{ $slot->format('H:i') }}">
                                                    <input type="hidden" name="duration" value="1">
                                                    <button type="submit" class="w-full text-sm px-3 py-1 bg-indigo-100 text-indigo-700 rounded hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                                        {{ $slot->format('D, M j') }} {{ $slot->format('g:i A') }}
                                                    </button>
                                                </form>
                                            @endforeach
                                        </div>
                                        @if(count($availableSlots) > 0)
                                            <p class="mt-2 text-sm text-gray-500">Showing {{ count($availableSlots) }} available slots. Click "View Profile" for more options.</p>
                                        @else
                                            <p class="mt-2 text-sm text-gray-500">No available slots for the next 7 days. Please check back later.</p>
                                        @endif
                                    </div>

                                    <!-- View Profile Button -->
                                    <div class="mt-4">
                                        <a href="{{ route('tutors.show', $tutor) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                            View Profile
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $tutors->links() }}
            </div>
        </div>
    </div>
</x-app-layout> 