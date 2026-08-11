<?php

namespace Database\Factories;

use App\Models\PageView;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PageView>
 */
class PageViewFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'ip_address' => fake()->ipv4(),
            'path' => fake()->randomElement(['/', '/profil', '/peta-potensi', '/katalog-usaha', '/pengaduan']),
            'created_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
