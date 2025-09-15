<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Candidate;


class CandidateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Candidate::updateOrCreate([
            'email' => 'neven@example.com',
            'phone' => '123-456-7890',
            'first_name' => 'Neven',
            'last_name' => 'Nevenić'

        ]);
        Candidate::updateOrCreate([
            'email' => 'miro@example.com',
            'phone' => '123-456-7890',
            'first_name' => 'Miro',
            'last_name' => 'Mirić'

        ]);
        Candidate::factory()->count(50)->create();
    }
}
