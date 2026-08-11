<?php

namespace Database\Factories;

use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<News>
 */
class NewsFactory extends Factory
{
    /** @return array<string, mixed> */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(6),
            'slug' => Str::slug(fake()->sentence(6)),
            'excerpt' => fake()->paragraph(2),
            'content' => fake()->paragraphs(5, true),
            'image' => null,
            'published_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function published(): static
    {
        return $this->state(['published_at' => now()]);
    }

    public function unpublished(): static
    {
        return $this->state(['published_at' => null]);
    }
}
