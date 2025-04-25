<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:tutors,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|min:10',
            'session_id' => 'nullable|exists:bookings,id'
        ]);

        $feedback = Feedback::create([
            'tutor_id' => $request->tutor_id,
            'student_id' => Auth::id(),
            'rating' => $request->rating,
            'comment' => $request->feedback,
            'session_id' => $request->session_id
        ]);

        return redirect()->back()->with('success', 'Thank you for your feedback!');
    }
} 