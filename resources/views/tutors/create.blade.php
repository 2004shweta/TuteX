<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Become a Tutor - {{ config('app.name', 'TuteX') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-white">
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
                            <a href="{{ route('tutors.create') }}" class="nav-link active">Become a Tutor</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary ml-4">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h1 class="text-4xl font-bold text-gray-900">Become a Tutor</h1>
                    <p class="mt-4 text-xl text-gray-600">Share your knowledge and help students achieve their academic goals</p>
                </div>

                <div class="max-w-3xl mx-auto">
                    <div class="bg-white shadow-md rounded-lg p-8">
                        <form action="{{ route('tutors.store') }}" method="POST" id="tutorForm">
                            @csrf
                            
                            @if ($errors->any())
                                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-red-700">
                                                There were some errors with your submission:
                                            </p>
                                            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if(session('debug'))
                                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                                    <pre class="text-sm">{{ print_r(session('debug'), true) }}</pre>
                                </div>
                            @endif

                            <div class="space-y-6">
                                <!-- Personal Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Personal Information</h3>
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                        <div>
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Information -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                                    <div class="grid grid-cols-1 gap-6">
                                        <div>
                                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                            <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                            <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                        <div>
                                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                            <input type="password" name="password" id="password" required 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                            <p class="mt-1 text-sm text-gray-500">Create a password for your tutor account</p>
                                            @error('password')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                                            <input type="password" name="password_confirmation" id="password_confirmation" required 
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        </div>
                                    </div>
                                </div>

                                <!-- Qualifications -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Qualifications</h3>
                                    <div class="space-y-6">
                                        <div>
                                            <label for="education" class="block text-sm font-medium text-gray-700">Education</label>
                                            <p class="mt-1 text-sm text-gray-500">Please list your educational qualifications (e.g., degrees, certifications)</p>
                                            <textarea name="education" id="education" rows="3" required 
                                                placeholder="Example:&#10;Bachelor's Degree in Mathematics, University of XYZ&#10;Teaching Certification, ABC Institute"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('education') }}</textarea>
                                            @error('education')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div>
                                            <label for="experience" class="block text-sm font-medium text-gray-700">Teaching Experience</label>
                                            <p class="mt-1 text-sm text-gray-500">Please describe your teaching experience</p>
                                            <textarea name="experience" id="experience" rows="3" required 
                                                placeholder="Example:&#10;5 years of teaching high school mathematics&#10;Private tutoring experience with students of various ages"
                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('experience') }}</textarea>
                                            @error('experience')
                                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Subjects -->
                                <div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-4">Subjects</h3>
                                    <div class="grid grid-cols-2 gap-4">
                                        @foreach(['Mathematics', 'Physics', 'Computer Science', 'English', 'Chemistry', 'Economics', 'Biology', 'History'] as $subject)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="subjects[]" value="{{ $subject }}" id="subject_{{ strtolower($subject) }}" 
                                                {{ in_array($subject, old('subjects', [])) ? 'checked' : '' }}
                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="subject_{{ strtolower($subject) }}" class="ml-2 block text-sm text-gray-900">{{ $subject }}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                    @error('subjects')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mt-8">
                                    <button type="submit" class="w-full btn-primary">
                                        Submit Application
                                    </button>
                                </div>

                                <div class="mt-6 text-center">
                                    <p class="text-sm text-gray-600">
                                        Already a tutor? 
                                        <a href="{{ route('tutor.login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                                            Login to your tutor dashboard
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-50">
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

    @push('scripts')
    <script>
        document.getElementById('tutorForm').addEventListener('submit', function(e) {
            // Log form data before submission
            const formData = new FormData(this);
            console.log('Form Data:', Object.fromEntries(formData));
        });
    </script>
    @endpush
</body>
</html> 