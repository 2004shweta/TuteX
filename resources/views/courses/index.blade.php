<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Courses - {{ config('app.name', 'TuteX') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-900">
        <!-- Navigation -->
        <nav class="bg-gray-800 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex-shrink-0 flex items-center">
                            <a href="/" class="text-2xl font-bold text-purple-400">TuteX</a>
                        </div>
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="/" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Home</a>
                            <a href="{{ route('tutors.index') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Find Tutors</a>
                            <a href="{{ route('courses.index') }}" class="text-white px-3 py-2 rounded-md text-sm font-medium">Courses</a>
                            <a href="{{ route('contact') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Contact</a>
                            <a href="#" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Become a Tutor</a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                        <a href="{{ route('register') }}" class="ml-4 bg-purple-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-purple-700">Register</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Courses Section -->
        <div class="py-12 bg-gray-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <h2 class="text-base text-purple-400 font-semibold tracking-wide uppercase">Our Courses</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">
                        Explore Our Learning Programs
                    </p>
                </div>

                <div class="mt-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Course Card 1 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white">Mathematics</h3>
                            <p class="mt-2 text-gray-300">Master fundamental concepts and advanced topics in mathematics.</p>
                            <div class="mt-4">
                                <span class="text-purple-400 text-sm font-medium">Starting from $20/hour</span>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Card 2 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white">Physics</h3>
                            <p class="mt-2 text-gray-300">Understand the fundamental laws of nature and their applications.</p>
                            <div class="mt-4">
                                <span class="text-purple-400 text-sm font-medium">Starting from $25/hour</span>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Card 3 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white">Computer Science</h3>
                            <p class="mt-2 text-gray-300">Learn programming, algorithms, and software development.</p>
                            <div class="mt-4">
                                <span class="text-purple-400 text-sm font-medium">Starting from $30/hour</span>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Card 4 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white">English</h3>
                            <p class="mt-2 text-gray-300">Improve your language skills and communication abilities.</p>
                            <div class="mt-4">
                                <span class="text-purple-400 text-sm font-medium">Starting from $20/hour</span>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Card 5 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white">Chemistry</h3>
                            <p class="mt-2 text-gray-300">Explore the world of atoms, molecules, and chemical reactions.</p>
                            <div class="mt-4">
                                <span class="text-purple-400 text-sm font-medium">Starting from $25/hour</span>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details →</a>
                            </div>
                        </div>
                    </div>

                    <!-- Course Card 6 -->
                    <div class="bg-gray-800 rounded-lg overflow-hidden shadow-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-white">Economics</h3>
                            <p class="mt-2 text-gray-300">Understand economic principles and their real-world applications.</p>
                            <div class="mt-4">
                                <span class="text-purple-400 text-sm font-medium">Starting from $22/hour</span>
                            </div>
                            <div class="mt-4">
                                <a href="#" class="text-purple-400 hover:text-purple-300 text-sm font-medium">View Details →</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-gray-800">
            <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
                <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-300 hover:text-white">About</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-300 hover:text-white">Privacy</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-300 hover:text-white">Terms</a>
                    </div>
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-300 hover:text-white">Contact</a>
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