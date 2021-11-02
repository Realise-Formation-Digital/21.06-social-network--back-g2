<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'first_name' => $this->faker->word,
            'last_name' => $this->faker->word,
            'avatar' => $this->faker->word,
            'pseudo' => $this->faker->word,
            'password' => $this->faker->word,
            'email' => $this->faker->word,

            'email_verified_at' => null,
        ];
    }
}
