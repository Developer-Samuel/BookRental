<?php

declare(strict_types=1);

namespace App\Seeders;

use App\Contracts\Services\API\CountryServiceReaderContract;

use App\Models\Country\Country;

final class CountrySeeder
{
    /**
     * @param CountryServiceReaderContract $countryServiceReader,
    */
    public function __construct(
        private readonly CountryServiceReaderContract $countryServiceReader
    ) {}

    /**
     * Seed the countries from the API.
     *
     * @return void
     * @throws \RuntimeException
    */
    public function seedFromApi(): void
    {
        try {
            $countries = $this->countryServiceReader->fetchAll();

            if (isset($countries['error'])) {
                echo "Error during fetching countries: " . $countries['error'] . PHP_EOL;
                return;
            }

            foreach ($countries as $countryData) {
                Country::updateOrCreate(
                    ['code' => $countryData['code']],
                    [
                        'name'        => $countryData['name'],
                        'nationality' => $countryData['nationality'],
                        'updated_at'  => null
                    ]
                );
            }
        } catch (\Exception $e) {
            throw new \RuntimeException("Seeding failed: " . $e->getMessage());
        }
    }
}
