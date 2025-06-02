<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Book;

use Illuminate\Database\Eloquent\Collection;

use App\Contracts\Abstracts\BaseRepositoryContract;

use App\Models\Book\Book;

interface BookRepositoryContract extends BaseRepositoryContract
{
    /**
     * Get all books for a specific author
     *
     * @param int $authorId
     * @return Collection
    */
    public function fetchAllForAuthor(int $authorId): Collection;

    /**
     * Get all books for a specific author and sort
     *
     * @param int $authorId
     * @param string $orderBy
     * @param string $direction
     * @return Collection
    */
    public function fetchAllByAuthorAndSort(int $authorId, string $orderBy = 'title', string $direction = 'asc'): Collection;

    /**
     * Find book by title
     *
     * @param string $title
     * @return Book|null
    */
    public function findByTitle(string $title): ?Book;
}
