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
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('admin123')
            ]
        );
        User::updateOrCreate(
            [
                'email' => 'igor@example.com'
            ],
            [
                'name' => 'Igor Jauk',
                'password' => bcrypt('igor123')
            ]
        );
    }
}
