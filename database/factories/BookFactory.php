<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'author' => fake()->name(),
            'isbn' => fake()->unique()->numerify('978-###-###-###'),
            'description' => fake()->paragraph(),
            'cover_image' => null,
            'stock' => fake()->numberBetween(1, 50),
            'category' => fake()->randomElement(['Fiksi', 'Teknologi', 'Sejarah', 'Sains', 'Bisnis']),
            'published_year' => fake()->numberBetween(1900, (int) date('Y')),
        ];
    }

    /**
     * State: stok habis (tidak ada eksemplar tersedia).
     */
    public function outOfStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'stock' => 1,
        ]);
    }
}
