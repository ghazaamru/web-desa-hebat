<?php

namespace Database\Factories;

use App\Models\Complaint;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Complaint>
 */
class ComplaintFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => '628'.fake()->numerify('#########'),
            'subject' => fake()->sentence(4),
            'content' => fake()->paragraph(3),
            'status' => fake()->randomElement(['pending', 'processed', 'resolved']),
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function processed(): static
    {
        return $this->state(['status' => 'processed']);
    }

    public function resolved(): static
    {
        return $this->state(['status' => 'resolved']);
    }
}
