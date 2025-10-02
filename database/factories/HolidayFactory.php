<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class HolidayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->randomElement(['Christmas Day','Boxing Day','New Year\'s Day','Good Friday','Easter Monday','May Day','Spring Bank Holiday','Summer Bank Holiday']),
            'date' => Carbon::now()->addMonths(rand(0, 12))->startOfMonth()->addDays(rand(0, 28)),
        ];
    }
}