<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '+9715'.fake()->numberBetween(10000000, 99999999),
            'address' => fake()->streetAddress().', Abu Dhabi',
        ];
    }
}