<?php

declare(strict_types=1);

namespace Database\Factories\Book;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Enums\BookType;

use App\Models\Author\Author;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
    */
    public function definition(): array
    {
        return [
            'author_id'   => Author::factory(),
            'title'       => fake()->sentence(3),
            'type'        => fake()->randomElement(BookType::values()),
            'is_borrowed' => fake()->boolean(20),
        ];
    }
}
