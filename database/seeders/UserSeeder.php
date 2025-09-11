<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
        ]);
        User::updateOrCreate([
            'name' => 'Igor Jauk',
            'email' => 'igor@example.com',
            'password' => bcrypt('igor123'),
        ]);
    }
}
