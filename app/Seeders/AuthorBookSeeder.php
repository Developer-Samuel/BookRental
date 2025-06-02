<?php

declare(strict_types=1);

namespace App\Seeders;

use App\Models\Author\Author;
use App\Models\Book\Book;

final class AuthorBookSeeder
{
    /**
     * Seed authors and their books into the database.
     *
     * @return void
     * @throws \RuntimeException
    */
    public function seedAuthorsAndBooks(): void
    {
        try {
            $authors = $this->createAuthorsWithBooks(10, 3);
            $this->resetUpdatedAtForAuthorsAndBooks($authors);
        } catch (\Exception $e) {
            throw new \RuntimeException("Seeding failed: " . $e->getMessage());
        }
    }

    /**
     * Create authors with a given number of books.
     *
     * @param int $authorCount
     * @param int $booksPerAuthor
     * @return \Illuminate\Support\Collection
    */
    private function createAuthorsWithBooks(int $authorCount, int $booksPerAuthor)
    {
        return Author::factory()
            ->count($authorCount)
            ->has(Book::factory()->count($booksPerAuthor), 'books')
            ->create();
    }

    /**
     * Set updated_at to null for authors and their books.
     *
     * @param \Illuminate\Support\Collection $authors
     * @return void
    */
    private function resetUpdatedAtForAuthorsAndBooks($authors): void
    {
        foreach ($authors as $author) {
            $this->resetUpdatedAtForModel($author);

            foreach ($author->books as $book) {
                $this->resetUpdatedAtForModel($book);
            }
        }
    }

    /**
     * Set updated_at to null and save the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return void
    */
    private function resetUpdatedAtForModel($model): void
    {
        $model->setAttribute('updated_at', null);

        $model->save();
    }
}
