<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Trackers\AuthTracker;

class TrackerServiceProvider extends ServiceProvider
{
    /**
     * Register any trackers.
    */
    public function register(): void
    {
        $this->app->singleton(AuthTracker::class);
    }

    /**
     * Bootstrap any trackers.
    */
    public function boot(): void
    {
        //
    }
}