<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content' => $this->faker->word,
            'title' => $this->faker->word,
            'date' => $this->faker->now(),
            'img' => $this->faker->lorem()->image(),
        ];
    }
}
