<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobPosting;

class Job_postingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobPosting::updateOrCreate([
            'title' => 'Software Developer',
            'description' => 'Develop and maintain web applications.',
            'posted_at' => now(),
            'expires_at' => now()->addMonth(),
            'deadline' => now()->addWeeks(3),
            'is_valid' => true,
            'employee_id' => 1, // assuming employee with ID 1 exists
        ]);
        JobPosting::updateOrCreate([
            'title' => 'Project Manager',
            'description' => 'Oversee project development and ensure timely delivery.',
            'posted_at' => now(),
            'expires_at' => now()->addMonth(),
            'deadline' => now()->addWeeks(4),
            'is_valid' => true,
            'employee_id' => 2, // assuming employee with ID 2 exists
        ]);
    }
}
