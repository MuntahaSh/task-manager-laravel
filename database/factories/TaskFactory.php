<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'completed']);

        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(12),
            'status' => $status,
            'due_date' => fake()->optional()->dateTimeBetween('-2 days', '+10 days'),
            'completed_at' => $status === 'completed' ? now() : null,
        ];
    }
}