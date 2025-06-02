<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\Services\Cache\BookTypeCacheServiceContract;
use App\Contracts\Services\Cache\BorrowStatusCacheServiceContract;
use Illuminate\Support\ServiceProvider;

use App\Services\Cache\CountryCacheService;
use App\Services\Cache\GenderCacheService;

use App\Contracts\Services\Cache\CountryCacheServiceContract;
use App\Contracts\Services\Cache\GenderCacheServiceContract;
use App\Services\Cache\BookTypeCacheService;
use App\Services\Cache\BorrowStatusCacheService;

class CacheServiceProvider extends ServiceProvider
{
    /**
     * Register any caches.
    */
    public function register(): void
    {
        $this->app->bind(CountryCacheServiceContract::class, CountryCacheService::class);
        $this->app->bind(GenderCacheServiceContract::class, GenderCacheService::class);
        $this->app->bind(BookTypeCacheServiceContract::class, BookTypeCacheService::class);
        $this->app->bind(BorrowStatusCacheServiceContract::class, BorrowStatusCacheService::class);
    }

    /**
     * Bootstrap any caches.
    */
    public function boot(): void
    {
        //
    }
}
