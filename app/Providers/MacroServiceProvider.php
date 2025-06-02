<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Binding macros for relationships and key constraints (primary & foreign keys)
use Database\Macros\PrimaryKeyMacro;
use Database\Macros\ForeignKeyMacro;

// Binding macros for basic string, text, and enum data types
use Database\Macros\StringMacro;
use Database\Macros\TextMacro;
use Database\Macros\EnumMacro;

// Binding macros for numeric and logical data types (integer, decimal, boolean)
use Database\Macros\IntegerMacro;
use Database\Macros\DecimalMacro;
use Database\Macros\BooleanMacro;

// Binding macros for date and timestamp data types
use Database\Macros\DateMacro;
use Database\Macros\TimestampsMacro;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Register any macros.
    */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any macros.
    */
    public function boot(): void
    {
        // Macros for relationships and keys
        PrimaryKeyMacro::register();
        ForeignKeyMacro::register();

        // Macros for basic data types
        StringMacro::register();
        TextMacro::register();
        EnumMacro::register();

        // Macros for numeric and logical data types
        IntegerMacro::register();
        DecimalMacro::register();
        BooleanMacro::register();

        // Macros for dates and timestamps
        DateMacro::register();
        TimestampsMacro::register();
    }
}
