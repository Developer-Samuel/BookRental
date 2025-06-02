<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Cache;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Services\Cache\GenderCacheService;
use App\Contracts\Services\Cache\GenderCacheServiceContract;

use App\Enums\Gender;

class GenderCacheServiceTest extends TestCase
{
    use MockeryTearDown;

    #[Test]
    public function canGetLabelsReturnsFromCacheIfPresent()
    {
        config(['cache.default' => 'file']);

        $expectedLabels = Gender::labels();

        Cache::shouldReceive('remember')
            ->once()
            ->with('genders_labels', 365 * 24 * 60 * 60, \Mockery::type('Closure'))
            ->andReturn($expectedLabels);

        $service = new GenderCacheService();

        $this->assertInstanceOf(GenderCacheServiceContract::class, $service);
        $this->assertEquals($expectedLabels, $service->getLabels());
    }

    #[Test]
    public function canGetLabelsReturnsFromRedisIfPresent()
    {
        config(['cache.default' => 'redis']);

        $expectedLabels = Gender::labels();

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('genders_labels')
            ->andReturn(serialize($expectedLabels));

        $service = new GenderCacheService();

        $this->assertInstanceOf(GenderCacheServiceContract::class, $service);
        $this->assertEquals($expectedLabels, $service->getLabels());
    }

    #[Test]
    public function it_stores_labels_in_redis_if_not_cached()
    {
        config(['cache.default' => 'redis']);

        $expectedLabels = Gender::labels();

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('genders_labels')
            ->andReturn(null);

        Redis::shouldReceive('setex')
            ->once()
            ->with('genders_labels', 365 * 24 * 60 * 60, serialize($expectedLabels));

        $service = new GenderCacheService();

        $this->assertInstanceOf(GenderCacheServiceContract::class, $service);
        $this->assertEquals($expectedLabels, $service->getLabels());
    }
}
