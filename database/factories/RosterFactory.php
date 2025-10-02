<?php

namespace Database\Factories;

use App\Models\{Employee, ServiceUser, User};
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class RosterFactory extends Factory
{
    public function definition(): array
    {
        $start = Carbon::now()->addDays(rand(0, 30))->setTime(rand(8, 16), 0);
        $end   = $start->copy()->addHours(rand(2, 8));

        return [
            'start'              => $start,
            'end'                => $end,
            'shift_hours'        => $start->floatDiffInHours($end),
            'status'             => fake()->randomElement(['assigned','complete']),
            'service_user_id'    => ServiceUser::factory(),
            'employee_id'        => Employee::factory(),
            'travel_hours'       => rand(0, 1),
            'travel_minutes'     => rand(0, 30),
            'assigned_by'        => User::factory(),
            'cancelled_by'       => null,
        ];
    }
}