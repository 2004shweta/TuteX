<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReviewPolicy
{
    use HandlesAuthorization;

    public function create(User $user, Review $review)
    {
        return $user->isStudent() && $user->id === $review->student_id;
    }

    public function delete(User $user, Review $review)
    {
        return $user->id === $review->student_id;
    }
} 