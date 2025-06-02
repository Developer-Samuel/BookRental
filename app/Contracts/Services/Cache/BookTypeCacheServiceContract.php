<?php

declare(strict_types=1);

namespace App\Contracts\Services\Cache;

interface BookTypeCacheServiceContract
{
    /**
     * Retrieve all book type options
     *
     * @return array
    */
    public function getOptions(): array;
}
