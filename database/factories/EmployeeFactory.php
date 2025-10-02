<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class EmployeeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'username'               => fake()->unique()->userName(),
            'email'                  => fake()->unique()->safeEmail(),
            'password'               => Hash::make('password'),
            'title'                  => fake()->randomElement(['Mr','Mrs','Ms','Miss']),
            'first_name'             => fake()->firstName(),
            'middle_initial'         => fake()->randomLetter(),
            'last_name'              => fake()->lastName(),
            'date_of_birth'          => fake()->date(),
            'start_date'             => fake()->date(),
            'preferred_name'         => fake()->firstName(),
            'address'                => fake()->streetAddress(),
            'city'                   => fake()->city(),
            'postcode'               => fake()->postcode(),
            'branch'                 => fake()->city(),
            'area'                   => fake()->city(),
            'house_no'               => fake()->buildingNumber(),
            'mobile_no'              => fake()->phoneNumber(),
            'contracted_hours'       => fake()->randomFloat(1, 30, 40),
            'tax_code'               => '1257L',
            'gender'                 => fake()->randomElement(['male','female','other']),
            'marital_status'         => fake()->randomElement(['Single','Married','Divorced']),
            'nationality'            => fake()->country(),
            'ethnic_origin'          => fake()->randomElement(['White','Asian','Black','Mixed']),
            'religion'               => fake()->randomElement(['Christian','Muslim','None']),
            'is_salaried'            => fake()->boolean(),
            'enforce_hours'          => fake()->boolean(),
            'national_insurance'     => fake()->numerify('QQ##_##_##_##_#'),
            'days_per_week'          => fake()->numberBetween(4, 6),
            'hours_of_week'          => fake()->randomFloat(1, 35, 45),
            'drive_status'           => fake()->randomElement(['driver','non-driver']),
            'estimate_hour_pay_date' => fake()->date(),
            'dbs_in_place'           => fake()->randomElement(['Yes','No']),
            'medical_issue'          => fake()->sentence(),
            'disability'             => fake()->boolean(),
            'next_of_kin_name'       => fake()->name(),
            'home_address'           => fake()->streetAddress(),
            'emergency_contact_no'   => fake()->phoneNumber(),
            'emergency_contact_email'=> fake()->safeEmail(),
            'consent_status'         => fake()->randomElement(['Granted','Pending']),
            'consent_date'           => fake()->date(),
            'is_active'              => true,
        ];
    }
}