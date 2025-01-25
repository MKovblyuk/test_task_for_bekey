<?php

namespace Database\Factories;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = TaskStatus::cases();

        return [
            'name' => fake()->sentence(),
            'description' => fake()->text(),
            'status' => $statuses[array_rand($statuses)],
        ];
    }
}
