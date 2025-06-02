<?php

declare(strict_types=1);

namespace App\Contracts\Services\API;

interface CountryServiceReaderContract
{
    /**
     * Fetch all countries from the external API.
     *
     * @return array
    */
    public function fetchAll(): array;
}
