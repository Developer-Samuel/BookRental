<?php

declare(strict_types=1);

namespace App\Services\API;

use App\Contracts\Services\API\CountryServiceWriterContract;

use App\Models\Country\Country;

final class CountryServiceWriter implements CountryServiceWriterContract
{
    /**
     * Save or update a country in the database.
     *
     * @param array $country
     * @return void
    */
    public function saveCountry(array $country): void
    {
        Country::updateOrInsert(
            ['code' => $country['code']],
            [
                'name'        => $country['name'],
                'nationality' => $country['nationality'],
            ]
        );
    }
}
