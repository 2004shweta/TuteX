<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TutorSeeder extends Seeder
{
    public function run(): void
    {
        $tutors = [
            [
                'name' => 'John Smith',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'bio' => 'Experienced mathematics tutor with 5 years of teaching experience.',
                'subjects' => ['Mathematics', 'Physics'],
                'hourly_rate' => 25.00,
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'bio' => 'Chemistry and Biology tutor with a passion for teaching.',
                'subjects' => ['Chemistry', 'Biology'],
                'hourly_rate' => 30.00,
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael@example.com',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'bio' => 'English literature tutor with a focus on creative writing.',
                'subjects' => ['English'],
                'hourly_rate' => 20.00,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily@example.com',
                'password' => Hash::make('password'),
                'role' => 'tutor',
                'bio' => 'Physics and Mathematics tutor with a strong academic background.',
                'subjects' => ['Physics', 'Mathematics'],
                'hourly_rate' => 35.00,
            ],
        ];

        foreach ($tutors as $tutor) {
            User::create($tutor);
        }
    }
} 