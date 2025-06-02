<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Country\CountryRepository;
use App\Repositories\Author\AuthorRepository;
use App\Repositories\Book\BookRepository;

use App\Contracts\Repositories\Country\CountryRepositoryContract;
use App\Contracts\Repositories\Author\AuthorRepositoryContract;
use App\Contracts\Repositories\Book\BookRepositoryContract;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any repositories.
    */
    public function register(): void
    {
        $this->app->bind(AuthorRepositoryContract::class, AuthorRepository::class);
        $this->app->bind(BookRepositoryContract::class, BookRepository::class);
        $this->app->bind(CountryRepositoryContract::class, CountryRepository::class);
    }

    /**
     * Bootstrap any repositories.
    */
    public function boot(): void
    {
        //
    }
}
