<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Contracts\Services\API\CountryServiceReaderContract;
use App\Contracts\Services\API\CountryServiceWriterContract;

class LoadCountries extends Command
{
    protected $signature = 'countries:load';
    protected $description = 'Load countries from external API and store them in a JSON file';

    /**
     * @param CountryServiceReaderContract $countryReader
     * @param CountryServiceWriterContract $countryWriter
    */
    public function __construct(
        protected readonly CountryServiceReaderContract $countryReader,
        protected readonly CountryServiceWriterContract $countryWriter
    ) {
        parent::__construct();
    }

    /**
     * Starts the entire country loading process and stores them in the database.
     *
     * @return void
    */
    public function handle(): void
    {
        $this->info('--- Starting country load process ---');

        $countries = $this->countryReader->fetchAll();

        if (!$countries) {
            $this->error('❌ No countries fetched. API might have failed.');
            return;
        }

        $this->displayCountriesInfo($countries);

        $this->info('📁 Saving countries to the database...');

        $this->saveCountries($countries);

        $this->info('--- Country load process completed ---');
    }

    /**
     * Displays information about the fetched countries (count, sample).
     *
     * @param array $countries
     * @return void
    */
    private function displayCountriesInfo(array $countries): void
    {
        $this->info('✅ Countries fetched successfully.');
        $this->info('🔢 Total countries: ' . count($countries));
        $this->info('📋 Sample of countries:');

        foreach (array_slice($countries, 0, 5) as $index => $country) {
            $this->line("  " . ($index + 1) . '. ' . $country['name'] . ' (' . $country['code'] . ')');
        }
    }

    /**
     * Saves countries to the database and processes each country.
     *
     * @param array $countries
     * @return void
    */
    private function saveCountries(array $countries): void
    {
        try {
            foreach ($countries as $country) {
                $this->countryWriter->saveCountry($country);
            }
            $this->info('✅ Countries saved successfully to the database');
        } catch (\Exception $e) {
            $this->error('❌ Failed to save countries to the database: ' . $e->getMessage());
        }
    }
}
