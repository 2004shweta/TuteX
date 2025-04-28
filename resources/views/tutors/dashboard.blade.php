<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tutor Dashboard - {{ config('app.name', 'TuteX') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-bold text-blue-600">TuteX</a>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="/" class="nav-link">Home</a>
                            <a href="{{ route('tutors.index') }}" class="nav-link">Find Tutors</a>
                            <a href="{{ route('courses.index') }}" class="nav-link">Courses</a>
                            <a href="{{ route('contact') }}" class="nav-link">Contact</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <span class="text-gray-700 mr-4">Welcome, {{ $tutor->first_name }}!</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-md rounded-lg p-8">
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900">Tutor Dashboard</h1>
                        <p class="mt-2 text-gray-600">Manage your tutoring profile and applications</p>
                    </div>

                    <!-- Profile Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Personal Information</h2>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Full Name</p>
                                    <p class="text-gray-900">{{ $tutor->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Email</p>
                                    <p class="text-gray-900">{{ $tutor->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Phone</p>
                                    <p class="text-gray-900">{{ $tutor->phone }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-6 rounded-lg">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Qualifications</h2>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm text-gray-500">Education</p>
                                    <p class="text-gray-900 whitespace-pre-line">{{ $tutor->education ?? 'Not provided' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Experience</p>
                                    <p class="text-gray-900 whitespace-pre-line">{{ $tutor->experience ?? 'Not provided' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subjects -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Subjects</h2>
                        <div class="flex flex-wrap gap-2">
                            @if($tutor->subjects && count($tutor->subjects) > 0)
                                @foreach($tutor->subjects as $subject)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $subject }}
                                    </span>
                                @endforeach
                            @else
                                <p class="text-gray-500">No subjects selected</p>
                            @endif
                        </div>
                    </div>

                    <!-- Application Status -->
                    <div class="mt-8 bg-gray-50 p-6 rounded-lg">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Application Status</h2>
                        <div class="flex items-center">
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($tutor->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                @elseif($tutor->status === 'approved')
                                    bg-green-100 text-green-800
                                @else
                                    bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($tutor->status) }}
                            </span>
                            <p class="ml-4 text-gray-600">
                                @if($tutor->status === 'pending')
                                    Your application is under review. We'll notify you once it's processed.
                                @elseif($tutor->status === 'approved')
                                    Congratulations! Your application has been approved.
                                @else
                                    We're sorry, but your application was not approved at this time.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white">
            <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
                <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                    <div class="px-5 py-2">
                        <a href="#" class="footer-link">About</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="footer-link">Privacy</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="footer-link">Terms</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="footer-link">Contact</a>
                    </div>
                </nav>
                <p class="mt-8 text-center text-base text-gray-400">
                    &copy; {{ date('Y') }} TuteX. All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</body>
</html> 