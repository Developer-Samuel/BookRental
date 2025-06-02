<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Core\Helpers\SmartCache;

use App\Contracts\Services\Cache\GenderCacheServiceContract;
use App\Enums\Gender;

final class GenderCacheService implements GenderCacheServiceContract
{
    /**
     * Retrieve all gender labels
     *
     * @return array
    */
    public function getLabels(): array
    {
        return SmartCache::remember(
            'genders_labels',
            365 * 24 * 60 * 60,
            fn() => Gender::labels()
        );
    }
}
