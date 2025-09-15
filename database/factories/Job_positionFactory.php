<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Job_position;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job_position>
 */
class Job_positionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Job_position::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->jobTitle(),
            'description' => $this->faker->paragraph(),
            'min_salary' => $this->faker->numberBetween(30000, 60000),
            'max_salary' => $this->faker->numberBetween(60001, 120000),
            'is_active' => $this->faker->boolean(80), // 80% chance of being true
            'education_id' => \App\Models\Education::inRandomOrder()->first()->id ?? null,
        ];
    }
}
