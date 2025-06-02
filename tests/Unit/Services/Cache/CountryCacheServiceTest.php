<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Cache;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Support\Facades\Redis;

use App\Services\Cache\CountryCacheService;
use App\Contracts\Repositories\Country\CountryRepositoryContract;
use Illuminate\Support\Facades\Cache;

class CountryCacheServiceTest extends TestCase
{
    use MockeryTearDown;

    #[Test]
    public function itReturnsDataFromCacheIfPresent()
    {
        config(['cache.default' => 'file']);

        $expectedData = [
            ['id' => 1, 'name' => 'Austria'],
            ['id' => 2, 'name' => 'Belgium'],
        ];

        Cache::shouldReceive('remember')
            ->once()
            ->with('countries_all_sorted', 90 * 24 * 60 * 60, \Closure::class)
            ->andReturn($expectedData);

        $countryRepoMock = $this->createMock(CountryRepositoryContract::class);

        $service = new CountryCacheService($countryRepoMock);

        $this->assertEquals($expectedData, $service->getAllSorted());
    }

    #[Test]
    public function itReturnsDataFromRedisIfPresent()
    {
        config(['cache.default' => 'redis']);

        $expectedData = [
            ['id' => 3, 'name' => 'Canada'],
            ['id' => 4, 'name' => 'Denmark'],
        ];

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('countries_all_sorted')
            ->andReturn(serialize($expectedData));

        $countryRepoMock = $this->createMock(CountryRepositoryContract::class);
        $countryRepoMock->expects($this->never())->method('fetchAllSortedByName');

        $service = new CountryCacheService($countryRepoMock);

        $this->assertEquals($expectedData, $service->getAllSorted());
    }

    #[Test]
    public function itFetchesFromRepoAndStoresInRedisIfNotCached()
    {
        config(['cache.default' => 'redis']);

        $expectedData = [
            ['id' => 5, 'name' => 'Estonia'],
            ['id' => 6, 'name' => 'Finland'],
        ];

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('countries_all_sorted')
            ->andReturn(null);

        Redis::shouldReceive('setex')
            ->once()
            ->with('countries_all_sorted', 90 * 24 * 60 * 60, serialize($expectedData));

        $fetchedCollection = $this->createMock(\Illuminate\Database\Eloquent\Collection::class);
        $fetchedCollection->method('toArray')->willReturn($expectedData);

        $countryRepoMock = $this->createMock(CountryRepositoryContract::class);
        $countryRepoMock->expects($this->once())
            ->method('fetchAllSortedByName')
            ->willReturn($fetchedCollection);

        $service = new CountryCacheService($countryRepoMock);

        $this->assertEquals($expectedData, $service->getAllSorted());
    }
}
