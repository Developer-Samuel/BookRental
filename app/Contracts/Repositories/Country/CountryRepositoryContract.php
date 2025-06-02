<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Country;

use Illuminate\Database\Eloquent\Collection;

use App\Contracts\Abstracts\BaseRepositoryContract;

interface CountryRepositoryContract extends BaseRepositoryContract
{
    /**
     * Retrieve all countries ordered alphabetically by name (A–Z).
     *
     * @return Collection
    */
    public function fetchAllSortedByName(): Collection;
}
