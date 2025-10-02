<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class FunderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'                    => fake()->company(),
            'middle_initial'          => fake()->randomLetter(),
            'last_name'               => fake()->lastName(),
            'preferred_name'          => fake()->companySuffix(),
            'type'                    => fake()->randomElement(['Private','Public','NHS']),
            'address'                 => fake()->streetAddress(),
            'city_town'               => fake()->city(),
            'country'                 => fake()->country(),
            'postcode'                => fake()->postcode(),
            'start_date'              => fake()->date(),
            'branch'                  => fake()->city(),
            'mobile'                  => fake()->phoneNumber(),
            'email'                   => fake()->companyEmail(),
            'notes'                   => fake()->sentence(),
            'fax'                     => fake()->phoneNumber(),
            'other'                   => fake()->sentence(),
            'website'                 => fake()->url(),
            'purchase_order_required' => fake()->boolean(),
            'is_active'               => true,
        ];
    }
}