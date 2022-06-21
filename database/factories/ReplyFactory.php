<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Thread;

class ReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->paragraph,
            'user_id' => function(){
                return \App\Models\User::factory()->create()->id;
            },
            'thread_id' => function(){
                return \App\Models\Thread::factory()->create()->id;
            }
        ];
    }
}
