<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ChannelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => $this->faker->name(),
            'name'        => ucfirst($this->faker->words(2, true)),
            'description' => $this->faker->sentences(2, true),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function isPasswordProtected()
    {
        return $this->state(function (array $attributes) {
            return [
                'password' => bcrypt('password'),
            ];
        });
    }
}
