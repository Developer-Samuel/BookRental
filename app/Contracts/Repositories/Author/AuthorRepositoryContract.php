<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Author;

use Illuminate\Database\Eloquent\Collection;

use App\Contracts\Abstracts\BaseRepositoryContract;

use App\Models\Author\Author;

interface AuthorRepositoryContract extends BaseRepositoryContract
{
    /**
     * Get all authors with country relationship
     *
     * @return Collection
    */
    public function fetchAllAndSort(string $orderBy = 'name', string $direction = 'asc', array $withRelations = []): Collection;

    /**
     * Find author by name and surname
     *
     * @param string $name
     * @param string $surname
     * @return Author|null
    */
    public function findByName(string $name, string $surname): ?Author;
}