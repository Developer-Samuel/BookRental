<?php

declare(strict_types=1);

namespace App\Contracts\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface BaseRepositoryContract
{
    /**
     * Get all records
     *
     * @return Collection
    */
    public function fetchAll(): Collection;

    /**
     * Get all records and sort
     *
     * @return Collection
    */
    public function fetchAllAndSort(string $orderBy = 'id', string $direction = 'asc', array $withRelations = []): Collection;

    /**
     * Find record by ID
     *
     * @param int $recordId
     * @return Model|null
    */
    public function find(int $recordId): ?Model;

    /**
     * Check if record exists by ID
     *
     * @param int $recordId
     * @return bool
    */
    public function checkIfExists(int $recordId): bool;
}
