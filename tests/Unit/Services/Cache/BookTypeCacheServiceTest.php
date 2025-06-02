<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Cache;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

use App\Services\Cache\BookTypeCacheService;
use App\Contracts\Services\Cache\BookTypeCacheServiceContract;

use App\Enums\BookType;

class BookTypeCacheServiceTest extends TestCase
{
    use MockeryTearDown;

    #[Test]
    public function canGetOptionsReturnsFromCacheIfPresent()
    {
        config(['cache.default' => 'file']);

        $expectedOptions = BookType::options();

        Cache::shouldReceive('remember')
            ->once()
            ->with('book_types_options', 365 * 24 * 60 * 60, \Mockery::type('Closure'))
            ->andReturn($expectedOptions);

        $service = new BookTypeCacheService();

        $this->assertInstanceOf(BookTypeCacheServiceContract::class, $service);
        $this->assertEquals($expectedOptions, $service->getOptions());
    }

    #[Test]
    public function canGetOptionsReturnsFromRedisIfPresent()
    {
        config(['cache.default' => 'redis']);

        $expectedOptions = BookType::options();

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('book_types_options')
            ->andReturn(serialize($expectedOptions));

        $service = new BookTypeCacheService();

        $this->assertInstanceOf(BookTypeCacheServiceContract::class, $service);
        $this->assertEquals($expectedOptions, $service->getOptions());
    }

    #[Test]
    public function canStoresOptionsInRedisIfNotCached()
    {
        config(['cache.default' => 'redis']);

        $expectedOptions = BookType::options();

        Redis::shouldReceive('connection')->andReturnSelf();

        Redis::shouldReceive('get')
            ->once()
            ->with('book_types_options')
            ->andReturn(null);

        Redis::shouldReceive('setex')
            ->once()
            ->with('book_types_options', 365 * 24 * 60 * 60, serialize($expectedOptions));

        $service = new BookTypeCacheService();

        $this->assertInstanceOf(BookTypeCacheServiceContract::class, $service);
        $this->assertEquals($expectedOptions, $service->getOptions());
    }
}
