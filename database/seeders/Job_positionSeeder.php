<?php

namespace Database\Seeders;

use App\Models\Job_position;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Job_positionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Job_position::factory()->count(1000)->create();
    }
}
