<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

final class PrimaryKeyMacro
{
    /**
     * Register the macro for adding a primary key column to the table.
     *
     * @return void
    */
    public static function register(): void
    {
        Blueprint::macro('addPrimaryKey', function () {
            Blueprint::id();
        });
    }
}
