<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

final class TimestampsMacro
{
    /**
     * Register the macros for adding timestamp columns.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        Blueprint::macro('addTimestamps', function () {
            Blueprint::timestamps();
        });

        Blueprint::macro('addCustomTimestamp', function (string $name, bool $nullable = false) {
            $column = Blueprint::timestamp($name);
            if ($nullable) {
                $column->nullable();
            }
            return $column;
        });
    }
}
