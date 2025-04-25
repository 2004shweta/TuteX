<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BookingPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Booking $booking)
    {
        return $user->id === $booking->student_id || $user->id === $booking->tutor_id;
    }

    public function confirm(User $user, Booking $booking)
    {
        return $user->isTutor() && $user->id === $booking->tutor_id && $booking->status === 'pending';
    }

    public function cancel(User $user, Booking $booking)
    {
        return ($user->id === $booking->student_id || $user->id === $booking->tutor_id) 
            && in_array($booking->status, ['pending', 'confirmed']);
    }
} 