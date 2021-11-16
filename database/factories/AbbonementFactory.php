<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AbbonementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'prix' => $this->faker->randomNumber(2),
            'date_deb' => $this->faker->date(),
            'date_fin' => $this->faker->date(),
        ];
    }
}
