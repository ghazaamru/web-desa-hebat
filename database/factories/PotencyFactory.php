<?php

namespace Database\Factories;

use App\Enums\PotencyCategory;
use App\Models\Potency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Potency>
 */
class PotencyFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'category' => fake()->randomElement(PotencyCategory::cases()),
            'description' => fake()->paragraph(),
            'latitude' => fake()->latitude(-7.73, -7.71),
            'longitude' => fake()->longitude(110.80, 110.83),
            'whatsapp' => '6281234567890',
            'image' => null,
        ];
    }

    public function bumdes(): static
    {
        return $this->state(['category' => PotencyCategory::Bumdes]);
    }

    public function umkm(): static
    {
        return $this->state(['category' => PotencyCategory::Umkm]);
    }

    public function wisata(): static
    {
        return $this->state(['category' => PotencyCategory::Wisata]);
    }

    public function fasilitas(): static
    {
        return $this->state(['category' => PotencyCategory::Fasilitas]);
    }
}
