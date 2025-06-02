<?php

declare(strict_types=1);

namespace App\Repositories\Country;

use Illuminate\Database\Eloquent\Collection;

use App\Core\Abstracts\BaseRepository;

use App\Contracts\Repositories\Country\CountryRepositoryContract;

use App\Models\Country\Country;

class CountryRepository extends BaseRepository implements CountryRepositoryContract
{
    public function __construct()
    {
        parent::__construct(new Country());
    }
    /**
     * Retrieve all countries ordered alphabetically by name (A–Z).
     *
     * @return Collection
    */
    public function fetchAllSortedByName(): Collection
    {
        return $this->model->orderBy('name', 'asc')->get();
    }
}
