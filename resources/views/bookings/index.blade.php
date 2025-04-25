<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Bookings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @if($bookings->count() > 0)
                        <div class="space-y-6">
                            @foreach($bookings as $booking)
                                <div class="border rounded-lg p-6">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900">
                                                @if(auth()->user()->isStudent())
                                                    Session with {{ $booking->tutor->name }}
                                                @else
                                                    Session with {{ $booking->student->name }}
                                                @endif
                                            </h3>
                                            <p class="text-sm text-gray-500 mt-1">
                                                {{ $booking->start_time->format('l, F j, Y') }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ $booking->start_time->format('g:i A') }} - {{ $booking->end_time->format('g:i A') }}
                                            </p>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <span class="px-3 py-1 text-sm rounded-full 
                                                @if($booking->status === 'confirmed') bg-green-100 text-green-800
                                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                                @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                                @else bg-gray-100 text-gray-800 @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                            <a href="{{ route('bookings.show', $booking) }}" class="text-indigo-600 hover:text-indigo-900">
                                                View Details
                                            </a>
                                        </div>
                                    </div>

                                    @if($booking->notes)
                                        <div class="mt-4">
                                            <p class="text-sm text-gray-600">{{ $booking->notes }}</p>
                                        </div>
                                    @endif

                                    <div class="mt-4 flex justify-between items-center">
                                        <div class="text-lg font-semibold text-gray-900">
                                            ${{ number_format($booking->amount, 2) }}
                                        </div>
                                        <div class="flex space-x-2">
                                            @if($booking->status === 'pending' && auth()->user()->isTutor())
                                                <form action="{{ route('bookings.confirm', $booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                        Confirm
                                                    </button>
                                                </form>
                                            @endif
                                            @if(in_array($booking->status, ['pending', 'confirmed']))
                                                <form action="{{ route('bookings.cancel', $booking) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="inline-flex items-center px-3 py-1 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                        Cancel
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            {{ $bookings->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                @if(auth()->user()->isStudent())
                                    Get started by finding a tutor and booking a session.
                                @else
                                    You don't have any booking requests yet.
                                @endif
                            </p>
                            @if(auth()->user()->isStudent())
                                <div class="mt-6">
                                    <a href="{{ route('tutors.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Find a Tutor
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 