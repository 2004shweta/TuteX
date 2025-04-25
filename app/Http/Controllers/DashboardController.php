<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isStudent()) {
            $upcomingBookings = Booking::where('student_id', $user->id)
                ->where('start_time', '>', now())
                ->where('status', '!=', 'cancelled')
                ->orderBy('start_time')
                ->take(5)
                ->get();

            $availableTutors = User::where('role', 'tutor')
                ->where('id', '!=', $user->id)
                ->get();

            return view('dashboard', compact('upcomingBookings', 'availableTutors'));
        } elseif ($user->isTutor()) {
            $todayBookings = Booking::where('tutor_id', $user->id)
                ->whereDate('start_time', Carbon::today())
                ->where('status', '!=', 'cancelled')
                ->orderBy('start_time')
                ->get();

            $totalBookings = Booking::where('tutor_id', $user->id)
                ->where('status', 'completed')
                ->count();

            $averageRating = Review::where('tutor_id', $user->id)
                ->avg('rating') ?? 0;

            return view('dashboard', compact('todayBookings', 'totalBookings', 'averageRating'));
        }

        return view('dashboard');
    }
} 