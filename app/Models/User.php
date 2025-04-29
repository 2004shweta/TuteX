<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'bio',
        'profile_picture',
        'subjects',
        'hourly_rate',
        'education',
        'experience',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'subjects' => 'array',
        ];
    }

    public function bookingsAsStudent()
    {
        return $this->hasMany(Booking::class, 'student_id');
    }

    public function bookingsAsTutor()
    {
        return $this->hasMany(Booking::class, 'tutor_id');
    }

    public function reviewsAsStudent()
    {
        return $this->hasMany(Review::class, 'student_id');
    }

    public function reviewsAsTutor()
    {
        \Log::info('Loading reviews for tutor', ['tutor_id' => $this->id]);
        $reviews = $this->hasMany(Review::class, 'tutor_id');
        \Log::info('Reviews query', ['sql' => $reviews->toSql(), 'bindings' => $reviews->getBindings()]);
        return $reviews;
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function isTutor()
    {
        return $this->role === 'tutor';
    }

    public function isStudent()
    {
        return $this->role === 'student';
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'student_id');
    }
}
