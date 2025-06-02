<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Core\Helpers\SmartCache;

use App\Contracts\Services\Cache\BookTypeCacheServiceContract;

use App\Enums\BookType;

final class BookTypeCacheService implements BookTypeCacheServiceContract
{
    /**
     * Retrieve all book type options
     *
     * @return array
    */
    public function getOptions(): array
    {
        return SmartCache::remember(
            'book_types_options',
            365 * 24 * 60 * 60,
            fn() => BookType::options()
        );
    }
}
