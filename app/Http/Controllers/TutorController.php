<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;

class TutorController extends Controller
{
    public function index(Request $request)
    {
        $tutors = User::where('role', 'tutor')
            ->paginate(12);

        return view('tutors.index', compact('tutors'));
    }

    public function show(User $tutor)
    {
        if ($tutor->role !== 'tutor') {
            abort(404);
        }

        $averageRating = $tutor->reviewsAsTutor()->avg('rating') ?? 0;
        $totalReviews = $tutor->reviewsAsTutor()->count();
        $recentReviews = $tutor->reviewsAsTutor()
            ->with('student')
            ->latest()
            ->take(5)
            ->get();
            
        // Get completed sessions for the current user with this tutor
        $completedSessions = Booking::where('tutor_id', $tutor->id)
            ->where('student_id', auth()->id())
            ->where('status', 'completed')
            ->latest()
            ->get();

        return view('tutors.show', compact('tutor', 'averageRating', 'totalReviews', 'recentReviews', 'completedSessions'));
    }
} 