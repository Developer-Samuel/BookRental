<?php

declare(strict_types=1);

namespace App\Views\Book;

use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;

use App\Models\Book\Book;

final class BookView
{
    /**
     * @param BookRepository $bookRepository
     * @param AuthorRepository $authorRepository
    */
    public function __construct(
        private readonly BookRepository $bookRepository,
        private readonly AuthorRepository $authorRepository,
    ) {}

    /**
     * @param int $authorId
     * @return array
    */
    public function index(int $authorId): array
    {
        if (!$this->authorRepository->checkIfExists($authorId)) {
            abort(404);
        }

        $books = $this->bookRepository->fetchAllForAuthor($authorId);

        return [
            'view'  => 'Pages/Books/Index',
            'props' => [
                'books'    => $books,
                'authorId' => $authorId,
            ]
        ];
    }

    /**
     * @param int $authorId
     * @param array $types
     * @param array $borrowStatuses
     * @return array
    */
    public function create(int $authorId, array $types, array $borrowStatuses): array
    {
        return [
            'view'  => 'Pages/Books/Create',
            'props' => [
                'authorId'       => $authorId,
                'types'          => $types,
                'borrowStatuses' => $borrowStatuses
            ]
        ];
    }

    /**
     * @param Book $book
     * @param array $types
     * @param array $borrowStatuses
     * @return array
    */
    public function edit(Book $book, array $types, array $borrowStatuses): array
    {
        return [
            'view'  => 'Pages/Books/Edit',
            'props' => [
                'book'           => $book,
                'types'          => $types,
                'borrowStatuses' => $borrowStatuses
            ]
        ];
    }
}
