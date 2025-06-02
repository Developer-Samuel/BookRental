<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Core\Helpers\SmartCache;

use App\Contracts\Repositories\Country\CountryRepositoryContract;
use App\Contracts\Services\Cache\CountryCacheServiceContract;

final class CountryCacheService implements CountryCacheServiceContract
{
    /**
     * @param CountryRepositoryContract $countryRepository
    */
    public function __construct(
        private readonly CountryRepositoryContract $countryRepository
    ) {}

    /**
     * Retrieve all countries sorted by name, using cache for 30 days.
     *
     * @return array
    */
    public function getAllSorted(): array
    {
        return SmartCache::remember(
            'countries_all_sorted',
            90 * 24 * 60 * 60,
            fn() => $this->countryRepository->fetchAllSortedByName()->toArray()
        );
    }
}
