<?php

declare(strict_types=1);

namespace App\Repositories\Book;

use Illuminate\Database\Eloquent\Collection;

use App\Core\Abstracts\BaseRepository;
use App\Contracts\Repositories\Book\BookRepositoryContract;

use App\Models\Book\Book;

class BookRepository extends BaseRepository implements BookRepositoryContract
{
    public function __construct()
    {
        parent::__construct(new Book());
    }

    /**
     * Get all books for a specific author
     *
     * @param int $authorId
     * @return Collection
    */
    public function fetchAllForAuthor(int $authorId): Collection
    {
        return $this->model->where('author_id', $authorId)->get();
    }

    /**
     * Get all books for a specific author and sort
     *
     * @param int $authorId
     * @param string $orderBy
     * @param string $direction
     * @return Collection
    */
    public function fetchAllByAuthorAndSort(int $authorId, string $orderBy = 'id', string $direction = 'asc'): Collection
    {
        return $this->model
            ->where('author_id', $authorId)
            ->orderBy($orderBy, $direction)
            ->get();
    }

    /**
     * Find book by title
     *
     * @param string $title
     * @return Book|null
    */
    public function findByTitle(string $title): ?Book
    {
        /** @var Book|null $result */
        $result = $this->model->where('title', $title)->first();
        
        return $result;
    }
}
