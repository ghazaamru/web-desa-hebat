<?php

namespace Database\Factories;

use App\Models\VillageStatistic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<VillageStatistic>
 */
class VillageStatisticFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'label' => fake()->randomElement([
                'Total Penduduk',
                'Luas Wilayah',
                'Kepala Keluarga',
                'Jumlah RT',
                'Jumlah RW',
            ]),
            'value' => fake()->numberBetween(100, 10000),
            'icon' => null,
            'sort_order' => fake()->numberBetween(0, 10),
        ];
    }
}
