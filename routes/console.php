<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use App\Console\Commands\LoadCountries;

Artisan::command('countries:load', function () {
    $this->call(LoadCountries::class);
})->describe('Load countries from external API and store them in a JSON file');
