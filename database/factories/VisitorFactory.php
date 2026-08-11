<?php

namespace Database\Factories;

use App\Models\Visitor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Visitor>
 */
class VisitorFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'ip_address' => fake()->ipv4(),
            'visit_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
        ];
    }
}
