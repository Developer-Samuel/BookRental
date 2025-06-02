<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Cache;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Services\Cache\BorrowStatusCacheService;
use App\Contracts\Services\Cache\BorrowStatusCacheServiceContract;

use App\Enums\BorrowStatus;

class BorrowStatusCacheServiceTest extends TestCase
{
    use MockeryTearDown;

    #[Test]
    public function canGetOptionsReturnsFromCacheIfPresent()
    {
        config(['cache.default' => 'file']);

        $expectedOptions = BorrowStatus::options();

        Cache::shouldReceive('remember')
            ->once()
            ->with('borrow_statuses_options', 365 * 24 * 60 * 60, \Mockery::type('Closure'))
            ->andReturn($expectedOptions);

        $service = new BorrowStatusCacheService();

        $this->assertInstanceOf(BorrowStatusCacheServiceContract::class, $service);
        $this->assertEquals($expectedOptions, $service->getOptions());
    }

    #[Test]
    public function canGetOptionsReturnsFromRedisIfPresent()
    {
        config(['cache.default' => 'redis']);

        $expectedOptions = BorrowStatus::options();

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('borrow_statuses_options')
            ->andReturn(serialize($expectedOptions));

        $service = new BorrowStatusCacheService();

        $this->assertInstanceOf(BorrowStatusCacheServiceContract::class, $service);
        $this->assertEquals($expectedOptions, $service->getOptions());
    }

    #[Test]
    public function canStoresOptionsInRedisIfNotCached()
    {
        config(['cache.default' => 'redis']);

        $expectedOptions = BorrowStatus::options();

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('borrow_statuses_options')
            ->andReturn(null);

        Redis::shouldReceive('setex')
            ->once()
            ->with('borrow_statuses_options', 365 * 24 * 60 * 60, serialize($expectedOptions));

        $service = new BorrowStatusCacheService();

        $this->assertInstanceOf(BorrowStatusCacheServiceContract::class, $service);
        $this->assertEquals($expectedOptions, $service->getOptions());
    }
}
