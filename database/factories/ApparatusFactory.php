<?php

namespace Database\Factories;

use App\Models\Apparatus;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Apparatus>
 */
class ApparatusFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'position' => fake()->randomElement([
                'Kepala Desa',
                'Sekretaris Desa',
                'Kepala Urusan Umum',
                'Kepala Urusan Keuangan',
                'Kepala Urusan Perencanaan',
                'Kepala Seksi Pemerintahan',
                'Kepala Seksi Kesejahteraan',
            ]),
            'image' => null,
            'sort_order' => fake()->numberBetween(0, 20),
            'welcome_message' => null,
        ];
    }

    public function kepalaDesa(): static
    {
        return $this->state([
            'position' => 'Kepala Desa',
            'sort_order' => 0,
            'welcome_message' => fake()->paragraph(),
        ]);
    }
}
