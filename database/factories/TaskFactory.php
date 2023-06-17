<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TodoList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'todo_id' => function () {
                return TodoList::factory()->create()->id;
            },
            'task' => $this->faker->sentence,
            'completed' => $this->faker->boolean,
            'previously_completed' => $this->faker->boolean,
            'deadline' => $this->faker->dateTimeBetween('now', '+1 month'),
            'disabled' => $this->faker->boolean,
        ];
    }

}
