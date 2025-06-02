<?php

declare(strict_types=1);

namespace App\Contracts\Services\Cache;

interface BorrowStatusCacheServiceContract
{
    /**
     * Retrieve all borrow status options
     *
     * @return array
    */
    public function getOptions(): array;
}
