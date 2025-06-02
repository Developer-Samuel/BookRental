<?php

declare(strict_types=1);

namespace App\Contracts\Services\API;

interface CountryServiceWriterContract
{
    /**
     * Save or update a country in the database.
     *
     * @param array $country
     * @return void
    */
    public function saveCountry(array $country): void;
}
