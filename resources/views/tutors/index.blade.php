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
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg">
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