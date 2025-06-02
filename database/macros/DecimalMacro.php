<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\NumberValidator;

final class DecimalMacro
{
    /**
     * Register the macro for adding a decimal column with optional precision, scale, and default value.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        Blueprint::macro('addDecimal', function (
            string $name,
            int $precision = 10,
            int $scale = 2,
            ?float $default = null
        ) {
            if (!NumberValidator::validateDecimal($default)) {
                throw new \InvalidArgumentException("Invalid default value for decimal column {$name}");
            }

            $column = Blueprint::decimal($name, $precision, $scale);

            if (!is_null($default)) {
                $column->default($default);
            }

            return $column;
        });
    }
}
