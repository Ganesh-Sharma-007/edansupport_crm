<?php

namespace Database\Factories;

use App\Models\{ServiceUser, Funder, User};
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition(): array
    {
        $issue = fake()->dateTimeThisMonth();
        $due   = (clone $issue)->modify('+30 days');

        return [
            'invoice_no'      => 'INV-'.time().'-'.fake()->unique()->numerify('#####'),
            'service_user_id' => ServiceUser::factory(),
            'funder_id'       => Funder::factory(),
            'issue_date'      => $issue,
            'due_date'        => $due,
            'status'          => fake()->randomElement(['draft','published']),
            'total_amount'    => fake()->randomFloat(2, 100, 2000),
            'generated_by'    => User::factory(),
        ];
    }
}