<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $datetime = $this->faker->dateTimeBetween('-2 years', 'now');
        return [
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraph,
            'company_name' => $this->faker->company,
            'salary_min' => $this->faker->numberBetween(3000, 8000),
            'salary_max' => $this->faker->numberBetween(9000, 20000),
            'is_remote' => $this->faker->boolean(30),
            'job_type' => Arr::random(['full-time', 'part-time', 'contract', 'freelance']),
            'status' => Arr::random(['draft', 'published', 'archived']),
            'published_at' => $this->faker->dateTimeBetween($datetime, 'now'),
            'created_at' => $datetime,
            'updated_at' => $datetime,
        ];
    }
}
