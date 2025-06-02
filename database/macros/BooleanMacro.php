<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\BooleanValidator;

final class BooleanMacro
{
    /**
     * Register the macro for adding a boolean column with a default value.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        Blueprint::macro('addBoolean', function (string $name, bool $default = false) {
            if (!BooleanValidator::validate($default)) {
                throw new \InvalidArgumentException("Invalid default value for boolean column {$name}");
            }

            return Blueprint::boolean($name)->default($default);
        });
    }
}
