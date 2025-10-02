<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceUserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'type'                   => fake()->randomElement(['Elderly','Disabled','Child']),
            'title'                  => fake()->randomElement(['Mr','Mrs','Ms','Miss']),
            'first_name'             => fake()->firstName(),
            'middle_initial'         => fake()->randomLetter(),
            'last_name'              => fake()->lastName(),
            'preferred_name'         => fake()->firstName(),
            'city'                   => fake()->city(),
            'country'                => fake()->country(),
            'gender'                 => fake()->randomElement(['male','female','other']),
            'marital_status'         => fake()->randomElement(['Single','Married','Divorced']),
            'ethnic_origin'          => fake()->randomElement(['White','Asian','Black','Mixed']),
            'religion'               => fake()->randomElement(['Christian','Muslim','None']),
            'postcode'               => fake()->postcode(),
            'start_date'             => fake()->date(),
            'date_of_birth'          => fake()->date(),
            'service_priority'       => fake()->randomElement(['Low','Medium','High']),
            'branch'                 => fake()->city(),
            'care_hours'             => fake()->randomFloat(1, 5, 20),
            'visit_duration'         => fake()->randomElement(['30 min','1 hour','2 hours']),
            'type_of_service_user'   => fake()->randomElement(['Residential','Day Care','Home Care']),
            'address'                => fake()->streetAddress(),
            'contact_number'         => fake()->phoneNumber(),
            'fax'                    => fake()->phoneNumber(),
            'other'                  => fake()->sentence(),
            'is_active'              => true,
        ];
    }
}