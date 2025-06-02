<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Book;

use PHPUnit\Framework\Attributes\Test;

use Tests\Feature\Core\BaseTestCase;

use App\Enums\BookType;

use App\Models\Book\Book;
use App\Models\Author\Author;

class BookControllerTest extends BaseTestCase
{
    #[Test]
    public function canDisplayBooksIndexPage()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $this->createBook($author, 'Test Book', BookType::FICTION->value);

        $response = $this->get(route('books.index', ['id' => $author->id]));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Pages/Books/Index')
                 ->has('books', 1)
        );
    }

    #[Test]
    public function canDisplayCreateBookPage()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $response = $this->get(route('books.create', ['id' => $author->id]));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Pages/Books/Create')
                 ->where('authorId', $author->id)
        );
    }

    #[Test]
    public function canStoreNewBook()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $data = [
            'author_id'   => $author->id,
            'title'       => 'New Book',
            'type'        => BookType::FICTION->value,
            'is_borrowed' => 0,
        ];

        $response = $this->post(route('books.store'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', ['title' => 'New Book']);
    }

    #[Test]
    public function canDisplayEditBookPage()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $book = $this->createBook($author, 'Edit Book', BookType::FICTION->value);

        $response = $this->get(route('books.edit', ['id' => $book->id]));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Pages/Books/Edit')
                 ->where('model.id', $book->id)
        );
    }

    #[Test]
    public function canUpdateBook()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $book = $this->createBook($author, 'Old Book', BookType::FICTION->value);

        $data = [
            'id'          => $book->id,
            'author_id'   => $author->id,
            'title'       => 'Updated Title',
            'type'        => BookType::THRILLER->value,
            'is_borrowed' => 1,
        ];

        $response = $this->post(route('books.update'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('books', ['title' => 'Updated Title']);
    }

    #[Test]
    public function canDeleteBook()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $book = $this->createBook($author, 'Delete Book', BookType::FICTION->value);

        $response = $this->delete(route('books.destroy', ['id' => $book->id]), ['id' => $book->id]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    // === Private helper for DRY ===

    private function createBook(Author $author, string $title, string $type, int $isBorrowed = 0): Book
    {
        return Book::create([
            'author_id'   => $author->id,
            'title'       => $title,
            'type'        => $type,
            'is_borrowed' => $isBorrowed,
        ]);
    }
}
