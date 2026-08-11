<?php

namespace Database\Factories;

use App\Enums\ApbdesCategory;
use App\Models\ApbdesItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApbdesItem>
 */
class ApbdesItemFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'category' => fake()->randomElement(ApbdesCategory::cases()),
            'name' => fake()->words(3, true),
            'amount' => fake()->numberBetween(50_000_000, 900_000_000),
        ];
    }

    public function pendapatan(): static
    {
        return $this->state(['category' => ApbdesCategory::Pendapatan]);
    }

    public function belanja(): static
    {
        return $this->state(['category' => ApbdesCategory::Belanja]);
    }
}
