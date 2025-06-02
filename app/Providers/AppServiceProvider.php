<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\Auth\AuthService;
use App\Services\Author\AuthorService;
use App\Services\Book\BookService;
use App\Services\API\CountryServiceReader;
use App\Services\API\CountryServiceWriter;

use App\Contracts\Services\Auth\AuthServiceContract;
use App\Contracts\Services\Author\AuthorServiceContract;
use App\Contracts\Services\Book\BookServiceContract;
use App\Contracts\Services\API\CountryServiceReaderContract;
use App\Contracts\Services\API\CountryServiceWriterContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any services.
    */
    public function register(): void
    {
        $this->app->bind(AuthServiceContract::class, AuthService::class);
        $this->app->bind(AuthorServiceContract::class, AuthorService::class);
        $this->app->bind(BookServiceContract::class, BookService::class);

        $this->app->bind(CountryServiceReaderContract::class, CountryServiceReader::class);
        $this->app->bind(CountryServiceWriterContract::class, CountryServiceWriter::class);
    }

    /**
     * Bootstrap any services.
    */
    public function boot(): void
    {
        //
    }
}
