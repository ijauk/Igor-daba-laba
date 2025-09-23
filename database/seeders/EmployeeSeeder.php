<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Employee::updateOrCreate([
            'user_id' => 2,
            'email' => 'igor@example.com',
            'phone' => '123-456-7890',
            'first_name' => 'Igor',
            'last_name' => 'Jauk',
            'position' => 'Uhljeb'
        ]);
        Employee::updateOrCreate([
            'user_id' => null,
            'email' => 'petar@example.com',
            'phone' => '123-456-7890',
            'first_name' => 'Petar',
            'last_name' => 'Petrović',
            'position' => 'Uhljeb'
        ]);
        Employee::updateOrCreate([
            'user_id' => null,
            'email' => 'marko@example.com',
            'phone' => '123-456-7890',
            'first_name' => 'Marko',
            'last_name' => 'Marković',
            'position' => 'Uhljeb'
        ]);
    }
}
