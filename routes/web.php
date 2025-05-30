<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\ChatController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

Route::get('/welcome', function () {
    return view('welcome');
})->name('welcome');

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::get('/tutor/login', [LoginController::class, 'showTutorLoginForm'])->name('tutor.login');
Route::post('/tutor/login', [LoginController::class, 'tutorLogin'])->name('tutor.login.submit');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Password Reset Routes
Route::get('forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.email');

Route::get('reset-password/{token}', function () {
    return view('auth.reset-password');
})->middleware('guest')->name('password.reset');

Route::post('reset-password', function () {
    return view('auth.reset-password');
})->middleware('guest')->name('password.update');

// Public Routes
Route::get('/courses', function () {
    return view('courses.index');
})->name('courses.index');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/become-tutor', function () {
    return view('become-tutor');
})->name('become-tutor');

// Tutor registration routes (public)
Route::get('/tutors/create', [TutorController::class, 'create'])->name('tutors.create');
Route::post('/tutors', [TutorController::class, 'store'])->name('tutors.store');
Route::get('/tutors/{tutor}/dashboard', [TutorController::class, 'dashboard'])->name('tutors.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Tutor routes
    Route::get('/tutors', [TutorController::class, 'index'])->name('tutors.index');
    Route::get('/tutors/{tutor}', [TutorController::class, 'show'])->name('tutors.show');
    Route::put('/tutors/{tutor}', [TutorController::class, 'update'])->name('tutors.update');
    
    // Booking routes
    Route::resource('bookings', BookingController::class);
    Route::post('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Review routes
    Route::resource('reviews', ReviewController::class);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/education', [ProfileController::class, 'addEducation'])->name('profile.education.add');
    Route::delete('/profile/education/{education}', [ProfileController::class, 'deleteEducation'])->name('profile.education.delete');

    // Feedback routes
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Chat routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{chat}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat', [ChatController::class, 'store'])->name('chat.store');
});
