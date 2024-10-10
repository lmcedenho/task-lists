<?php

namespace Database\Factories;

use App\Models\TaskList;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskListFactory extends Factory
{
    protected $model = TaskList::class;

    public function definition()
    {
        return [
            'name' => $this->faker->sentence,
            'owner_id' => \App\Models\User::factory(),
        ];
    }
}
