<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\SpecialValidator;

final class StringMacro
{
    /**
     * Register the macro for adding a string column with custom attributes.
     *
     * @return \Illuminate\Database\Schema\Blueprint
     * @throws \InvalidArgumentException
    */
    public static function register(): void
    {
        Blueprint::macro('addString', function (
            string $name,
            int $length = 255,
            bool $nullable = false,
            mixed $default = null,
            bool $unique = false
        ) {
            if (!SpecialValidator::validateUnique($unique)) {
                throw new \InvalidArgumentException('Invalid unique key reference to table ' . $unique);
            }

            $column = Blueprint::string($name, $length);

            if ($nullable) {
                $column->nullable();
            }

            if (!is_null($default)) {
                $column->default($default);
            }

            if ($unique) {
                $column->unique();
            }

            return $column;
        });
    }
}
