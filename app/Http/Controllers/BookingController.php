<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->isStudent()) {
            $bookings = Booking::where('student_id', $user->id)
                ->with('tutor')
                ->orderBy('start_time', 'desc')
                ->paginate(10);
        } else {
            $bookings = Booking::where('tutor_id', $user->id)
                ->with('student')
                ->orderBy('start_time', 'desc')
                ->paginate(10);
        }

        return view('bookings.index', compact('bookings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tutor_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'duration' => 'required|integer|min:1|max:3',
            'notes' => 'nullable|string|max:500',
        ]);

        $tutor = User::findOrFail($request->tutor_id);
        $startTime = Carbon::parse($request->date . ' ' . $request->start_time);
        $duration = (int) $request->duration;
        $endTime = $startTime->copy()->addHours($duration);

        // Check for overlapping bookings
        $overlappingBooking = Booking::where('tutor_id', $tutor->id)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->whereBetween('start_time', [$startTime, $endTime])
                    ->orWhereBetween('end_time', [$startTime, $endTime])
                    ->orWhere(function ($q) use ($startTime, $endTime) {
                        $q->where('start_time', '<', $startTime)
                            ->where('end_time', '>', $endTime);
                    });
            })
            ->where('status', '!=', 'cancelled')
            ->first();

        if ($overlappingBooking) {
            return back()->withErrors(['time' => 'This time slot is already booked. Please choose another time.']);
        }

        $booking = Booking::create([
            'student_id' => Auth::id(),
            'tutor_id' => $tutor->id,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'status' => 'pending',
            'notes' => $request->notes,
            'amount' => $tutor->hourly_rate * $request->duration,
        ]);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking request sent successfully. Waiting for tutor confirmation.');
    }

    public function show(Booking $booking)
    {
        $this->authorize('view', $booking);

        return view('bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        $this->authorize('confirm', $booking);

        $booking->update(['status' => 'confirmed']);

        return back()->with('success', 'Booking confirmed successfully.');
    }

    public function cancel(Booking $booking)
    {
        $this->authorize('cancel', $booking);

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking cancelled successfully.');
    }
} 