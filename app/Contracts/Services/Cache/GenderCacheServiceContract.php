<?php

declare(strict_types=1);

namespace App\Contracts\Services\Cache;

interface GenderCacheServiceContract
{
    /**
     * Retrieve all gender labels
     *
     * @return array
    */
    public function getLabels(): array;
}
