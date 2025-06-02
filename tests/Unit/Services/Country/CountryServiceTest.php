<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Country;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\API\CountryServiceWriter;
use App\Contracts\Services\API\CountryServiceWriterContract;

class CountryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected CountryServiceWriterContract $writer;

    #[Test]
    public function canSaveCountryInsertsOrUpdatesRecord(): void
    {
        $countryData = [
            'code'        => 'SK',
            'name'        => 'Slovakia',
            'nationality' => 'Slovak',
        ];

        $this->writer->saveCountry($countryData);

        $this->assertDatabaseHas('countries', [
            'code'        => 'SK',
            'name'        => 'Slovakia',
            'nationality' => 'Slovak',
        ]);

        $countryData['name'] = 'Slovak Republic';
        $this->writer->saveCountry($countryData);

        $this->assertDatabaseHas('countries', [
            'code'        => 'SK',
            'name'        => 'Slovak Republic',
            'nationality' => 'Slovak',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->writer = new CountryServiceWriter();
    }
}
