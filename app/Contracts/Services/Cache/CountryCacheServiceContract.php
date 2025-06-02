<?php

declare(strict_types=1);

namespace App\Contracts\Services\Cache;

interface CountryCacheServiceContract
{
    /**
     * Retrieve all countries sorted by name, using cache for 30 days.
     *
     * @return array
    */
    public function getAllSorted(): array;
}
