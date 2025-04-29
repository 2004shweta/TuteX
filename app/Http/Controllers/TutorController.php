<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $tutors = User::where('role', 'tutor')
            ->with(['bookingsAsTutor' => function($query) {
                $query->where('start_time', '>', now())
                    ->where('status', '!=', 'cancelled');
            }])
            ->paginate(12);

        return view('tutors.index', compact('tutors'));
    }

    public function show(User $tutor)
    {
        if ($tutor->role !== 'tutor') {
            abort(404);
        }

        \Log::info('Loading tutor profile', ['tutor_id' => $tutor->id]);

        $averageRating = $tutor->reviewsAsTutor()->avg('rating') ?? 0;
        $totalReviews = $tutor->reviewsAsTutor()->count();
        \Log::info('Review statistics', [
            'average_rating' => $averageRating,
            'total_reviews' => $totalReviews
        ]);

        $recentReviews = $tutor->reviewsAsTutor()
            ->with('student')
            ->latest()
            ->take(5)
            ->get();
        \Log::info('Recent reviews loaded', [
            'count' => $recentReviews->count(),
            'reviews' => $recentReviews->toArray()
        ]);
            
        // Get completed sessions for the current user with this tutor
        $completedSessions = Booking::where('tutor_id', $tutor->id)
            ->where('student_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('tutors.show', compact('tutor', 'averageRating', 'totalReviews', 'recentReviews', 'completedSessions'));
    }

    /**
     * Show the form for creating a new tutor.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('tutors.create');
    }

    /**
     * Store a newly created tutor in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Debug the incoming request data
            \Log::info('Tutor Registration Request Data:', $request->all());

            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone' => 'required|string|max:20',
                'password' => 'required|string|min:8|confirmed',
                'education' => 'required|string',
                'experience' => 'required|string',
                'subjects' => 'required|array',
                'subjects.*' => 'string'
            ]);

            // Check if user already exists with this email
            $existingUser = User::where('email', $request->email)->first();
            
            if ($existingUser) {
                // If user exists, update their role to tutor and password
                $existingUser->update([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'role' => 'tutor',
                    'password' => Hash::make($request->password),
                    'phone' => $request->phone,
                    'subjects' => $request->subjects,
                    'education' => $request->education,
                    'experience' => $request->experience,
                    'bio' => $request->education . "\n\n" . $request->experience,
                    'status' => 'pending'
                ]);
                $tutor = $existingUser;
            } else {
                // Create new tutor user
                $tutor = User::create([
                    'name' => $request->first_name . ' ' . $request->last_name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'role' => 'tutor',
                    'phone' => $request->phone,
                    'subjects' => $request->subjects,
                    'education' => $request->education,
                    'experience' => $request->experience,
                    'bio' => $request->education . "\n\n" . $request->experience,
                    'status' => 'pending'
                ]);
            }

            // Log in the tutor
            Auth::login($tutor);

            // Debug the created tutor
            \Log::info('Created Tutor:', $tutor->toArray());

            // Redirect to the tutor's dashboard
            return redirect()->route('tutors.dashboard', ['tutor' => $tutor->id])
                ->with('success', 'Your tutor application has been submitted successfully! We will review your application and get back to you soon.')
                ->with('debug', [
                    'request_data' => $request->all(),
                    'tutor_data' => $tutor->toArray()
                ]);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Tutor registration error: ' . $e->getMessage());
            
            // Return back with error message and debug info
            return back()
                ->withInput()
                ->withErrors(['error' => 'An error occurred while processing your application. Please try again.'])
                ->with('debug', [
                    'error' => $e->getMessage(),
                    'request_data' => $request->all()
                ]);
        }
    }

    public function dashboard(User $tutor)
    {
        // If user is not authenticated and not the tutor being viewed, redirect to login
        if (!Auth::check() && Auth::id() !== $tutor->id) {
            return redirect()->route('login')->with('error', 'Please login to access the dashboard.');
        }

        // If user is authenticated but trying to access another tutor's dashboard
        if (Auth::check() && Auth::id() !== $tutor->id) {
            abort(403);
        }

        // Get the tutor's data
        $tutor = User::findOrFail($tutor->id);

        return view('tutors.dashboard', compact('tutor'));
    }

    public function update(Request $request, User $tutor)
    {
        // Ensure the authenticated user is the tutor
        if (Auth::id() !== $tutor->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $tutor->id,
            'phone' => 'required|string|max:20',
            'education' => 'required|string',
            'experience' => 'required|string',
            'subjects' => 'required|string',
        ]);

        // Convert subjects string to array
        $validated['subjects'] = array_map('trim', explode(',', $validated['subjects']));

        $tutor->update($validated);

        return redirect()->route('tutors.dashboard', $tutor)
            ->with('success', 'Profile updated successfully!');
    }
} 