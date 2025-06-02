<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Binding core seeders for data integrity and setup
use App\Seeders\Core\ForeignKeySeeder;
use App\Seeders\Core\TruncateSeeder;

// Binding specific seeders for initial data
use App\Seeders\CountrySeeder;
use App\Seeders\AuthorBookSeeder;
use App\Seeders\UserSeeder;

class SeederServiceProvider extends ServiceProvider
{
    /**
     * Register any seeders.
    */
    public function register(): void
    {
        // Seeders for core database operations
        $this->app->bind(ForeignKeySeeder::class);
        $this->app->bind(TruncateSeeder::class);

        // Seeders for populating essential data
        $this->app->bind(UserSeeder::class);
        $this->app->bind(CountrySeeder::class);
        $this->app->bind(AuthorBookSeeder::class);
    }

    /**
     * Bootstrap any seeders.
    */
    public function boot(): void
    {
        //
    }
}
