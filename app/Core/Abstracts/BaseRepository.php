<?php

declare(strict_types=1);

namespace App\Core\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Contracts\Abstracts\BaseRepositoryContract;

abstract class BaseRepository implements BaseRepositoryContract
{
    protected Model $model;

    /**
     * Bind model instance
     *
     * @param Model $model
    */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     *
     * @return Collection
    */
    public function fetchAll(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get all records and sort
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
        array $withRelations = [],
        string $count = ''
    ): Collection {
        $query = $this->model->newQuery();

        if (!empty($withRelations)) {
            $query->with($withRelations);
        }

        if ($count) {
            $query->withCount($count);
        }

        return $query->orderBy($orderBy, $direction)->get();
    }

    /**
     * Find record by ID
     *
     * @param int $recordId
     * @return Model|null
    */
    public function find(int $recordId): ?Model
    {
        return $this->model->find($recordId);
    }

    /**
     * Check if record exists by ID
     *
     * @param int $recordId
     * @return bool
    */
    public function checkIfExists(int $recordId): bool
    {
        return $this->model->where('id', $recordId)->exists();
    }
}
