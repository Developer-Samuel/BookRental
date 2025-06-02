<?php

declare(strict_types=1);

namespace App\Repositories\Author;

use Illuminate\Database\Eloquent\Collection;

use App\Core\Abstracts\BaseRepository;
use App\Contracts\Repositories\Author\AuthorRepositoryContract;

use App\Models\Author\Author;

class AuthorRepository extends BaseRepository implements AuthorRepositoryContract
{
    public function __construct()
    {
        parent::__construct(new Author());
    }

    /**
     * Get all authors with country relationship
     *
     * @param string $orderBy
     * @param string $direction
     * @param array $withRelations
     * @param string $count
     * @return Collection
    */
    public function fetchAllAndSort(
        string $orderBy = 'id',
        string $direction = 'asc',
        array $withRelations = ['country'],
        string $count = 'books'
    ): Collection {
        $query = $this->model->newQuery();

        $query->with($withRelations);

        if ($count) {
            $query->withCount($count);
        }

        return $query->orderBy($orderBy, $direction)->get();
    }

    /**
     * Find author by name and surname
     *
     * @param string $name
     * @param string $surname
     * @return Author|null
    */
    public function findByName(string $name, string $surname): ?Author
    {
        $result = Author::where('name', $name)
                    ->where('surname', $surname)
                    ->first();

        return $result;
    }
}
