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
                            <a href="{{ route('become-tutor') }}" class="nav-link active">Become a Tutor</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="nav-link">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary ml-4">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="bg-blue-600">
            <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl">
                        Become a Tutor
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-blue-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                        Share your knowledge, earn money, and make a difference in students' lives.
                    </p>
                </div>
            </div>
        </div>

        <!-- Benefits Section -->
        <div class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="section-title">Why Tutor with Us?</h2>
                    <p class="section-heading">
                        Benefits of Joining TuteX
                    </p>
                </div>

                <div class="mt-10">
                    <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                        <div class="relative">
                            <div class="feature-icon">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Competitive Earnings</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Set your own rates and earn what you deserve for your expertise.
                                </p>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="feature-icon">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Flexible Schedule</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Teach when it's convenient for you, from anywhere in the world.
                                </p>
                            </div>
                        </div>

                        <div class="relative">
                            <div class="feature-icon">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="ml-16">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Supportive Community</h3>
                                <p class="mt-2 text-base text-gray-500">
                                    Join a network of passionate educators and grow together.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Application Form -->
        <div class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="max-w-lg mx-auto">
                    <h2 class="text-2xl font-bold text-gray-900 mb-8">Apply to Become a Tutor</h2>
                    <form class="space-y-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" class="form-input" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" class="form-input" required>
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" class="form-input" required>
                        </div>

                        <div>
                            <label for="subjects" class="block text-sm font-medium text-gray-700">Subjects You Can Teach</label>
                            <select multiple name="subjects" id="subjects" class="form-input" required>
                                <option value="mathematics">Mathematics</option>
                                <option value="physics">Physics</option>
                                <option value="chemistry">Chemistry</option>
                                <option value="biology">Biology</option>
                                <option value="english">English</option>
                                <option value="computer-science">Computer Science</option>
                                <option value="economics">Economics</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">Hold Ctrl/Cmd to select multiple subjects</p>
                        </div>

                        <div>
                            <label for="experience" class="block text-sm font-medium text-gray-700">Teaching Experience</label>
                            <textarea name="experience" id="experience" rows="4" class="form-input" required></textarea>
                        </div>

                        <div>
                            <label for="qualifications" class="block text-sm font-medium text-gray-700">Qualifications</label>
                            <textarea name="qualifications" id="qualifications" rows="4" class="form-input" required></textarea>
                        </div>

                        <div>
                            <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
                            <textarea name="availability" id="availability" rows="4" class="form-input" required></textarea>
                        </div>

                        <div>
                            <label for="resume" class="block text-sm font-medium text-gray-700">Resume/CV</label>
                            <input type="file" name="resume" id="resume" class="form-input" accept=".pdf,.doc,.docx" required>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox" name="terms" id="terms" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" required>
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and Conditions</a>
                            </label>
                        </div>

                        <div>
                            <button type="submit" class="btn-primary w-full">
                                Submit Application
                            </button>
                        </div>
                    </form>
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
</body>
</html> 