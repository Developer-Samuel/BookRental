<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use App\Contracts\Services\API\CountryServiceReaderContract;
use App\Contracts\Services\API\CountryServiceWriterContract;

class LoadCountriesCommandTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject&\App\Contracts\Services\API\CountryServiceReaderContract
    */
    protected $readerMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject&\App\Contracts\Services\API\CountryServiceWriterContract
    */
    protected $writerMock;

    #[Test]
    public function loadCountriesCommandDisplaysCorrectOutput()
    {
        $mockCountries = $this->prepareMockCountries();

        $this->setupCountryServiceMocks($mockCountries);

        $this->artisan('countries:load')
            ->expectsOutput('--- Starting country load process ---')
            ->expectsOutput('✅ Countries fetched successfully.')
            ->expectsOutput('🔢 Total countries: 2')
            ->expectsOutput('📋 Sample of countries:')
            ->expectsOutput('  1. Slovakia (SK)')
            ->expectsOutput('  2. Czechia (CZ)')
            ->expectsOutput('📁 Saving countries to the database...')
            ->expectsOutput('✅ Countries saved successfully to the database')
            ->expectsOutput('--- Country load process completed ---')
            ->assertExitCode(0);
    }

    protected function prepareMockCountries(): array
    {
        return [
            ['name' => 'Slovakia', 'code' => 'SK'],
            ['name' => 'Czechia', 'code' => 'CZ'],
        ];
    }

    protected function setupCountryServiceMocks(array $mockCountries): void
    {
        $this->readerMock->method('fetchAll')->willReturn($mockCountries);

        $this->writerMock->expects($this->exactly(count($mockCountries)))
            ->method('saveCountry')
            ->willReturnCallback(function ($country) use (&$mockCountries) {
                static $callIndex = 0;
                $expected = $mockCountries[$callIndex];
                $this->assertEquals($expected, $country);
                $callIndex++;
            });
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->readerMock = $this->createMock(CountryServiceReaderContract::class);
        $this->writerMock = $this->createMock(CountryServiceWriterContract::class);

        $this->app->instance(CountryServiceReaderContract::class, $this->readerMock);
        $this->app->instance(CountryServiceWriterContract::class, $this->writerMock);
    }
}
