<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Tutor;
use App\Models\Review;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Feedback submission started', $request->all());

        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'required|string|min:10',
            'session_id' => 'nullable|exists:bookings,id'
        ]);

        // If a session is provided, validate it
        if ($request->session_id) {
            $booking = Booking::findOrFail($request->session_id);

            // Check if the booking belongs to the authenticated user
            if ($booking->student_id !== Auth::id()) {
                abort(403);
            }

            // Check if the booking is completed
            if ($booking->status !== 'completed') {
                return back()->withErrors(['status' => 'You can only review completed sessions.']);
            }

            // Check if a review already exists for this booking
            if ($booking->review) {
                return back()->withErrors(['review' => 'You have already reviewed this session.']);
            }
        }

        try {
            // Create the feedback record
            $feedback = Feedback::create([
                'tutor_id' => $request->tutor_id,
                'student_id' => Auth::id(),
                'session_id' => $request->session_id,
                'rating' => $request->rating,
                'comment' => $request->feedback
            ]);
            \Log::info('Feedback created', ['feedback' => $feedback->toArray()]);

            // Create the review record
            $review = Review::create([
                'tutor_id' => $request->tutor_id,
                'student_id' => Auth::id(),
                'booking_id' => $request->session_id,
                'rating' => $request->rating,
                'comment' => $request->feedback
            ]);
            \Log::info('Review created', ['review' => $review->toArray()]);

            // If there's a booking, associate the review with it
            if ($request->session_id) {
                $booking->review()->save($review);
                \Log::info('Review associated with booking', ['booking_id' => $booking->id]);
            }

            // Verify the review exists in the database
            $savedReview = Review::find($review->id);
            \Log::info('Verifying saved review', ['saved_review' => $savedReview ? $savedReview->toArray() : null]);

            return redirect()->back()->with('success', 'Thank you for your review!');
        } catch (\Exception $e) {
            \Log::error('Error creating review', ['error' => $e->getMessage()]);
            return back()->withErrors(['error' => 'An error occurred while saving your review. Please try again.']);
        }
    }
} 