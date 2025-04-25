<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Review;
use App\Policies\BookingPolicy;
use App\Policies\ReviewPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Review::class => ReviewPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-tutor', function ($user) {
            return $user->isTutor();
        });

        Gate::define('is-student', function ($user) {
            return $user->isStudent();
        });
    }
} 