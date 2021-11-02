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
            'Content' => $this->faker->word,
            'Title' => $this->faker->word,
            'Date' => $this->faker->now(),
            'Img' => $this->faker->word,
        ];
    }
}
