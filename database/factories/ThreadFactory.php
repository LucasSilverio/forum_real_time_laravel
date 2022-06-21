<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ThreadFactory extends Factory
{
    /**
     * Define the model's default state. 
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'body' => implode(' ', $this->faker->paragraphs),
            'user_id' => function(){
                return \App\Models\User::factory()->create()->id;
            }
        ];
    }
}
