<?php

declare(strict_types=1);

namespace App\Services\Cache;

use App\Core\Helpers\SmartCache;

use App\Contracts\Services\Cache\BorrowStatusCacheServiceContract;

use App\Enums\BorrowStatus;

final class BorrowStatusCacheService implements BorrowStatusCacheServiceContract
{
    /**
     * Retrieve all borrow status options
     *
     * @return array
    */
    public function getOptions(): array
    {
        return SmartCache::remember(
            'borrow_statuses_options',
            365 * 24 * 60 * 60,
            fn() => BorrowStatus::options()
        );
    }
}
