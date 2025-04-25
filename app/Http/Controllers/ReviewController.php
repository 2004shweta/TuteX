<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'tutor_id' => 'required|exists:users,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $booking = Booking::findOrFail($request->booking_id);

        // Check if the booking belongs to the authenticated user
        if ($booking->student_id !== Auth::id()) {
            abort(403);
        }

        // Check if the booking is completed
        if ($booking->status !== 'completed') {
            return back()->withErrors(['status' => 'You can only review completed sessions.']);
        }

        // Check if a review already exists
        if ($booking->review) {
            return back()->withErrors(['review' => 'You have already reviewed this session.']);
        }

        Review::create([
            'booking_id' => $booking->id,
            'student_id' => Auth::id(),
            'tutor_id' => $request->tutor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review deleted successfully.');
    }
} 