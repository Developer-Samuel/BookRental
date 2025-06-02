<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\StringValidator;
use Database\Validators\SpecialValidator;

final class TextMacro
{
    /**
     * Register the macro for adding a text column with custom attributes.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        Blueprint::macro('addText', function (string $name, mixed $default = null, bool $nullable = false, bool $unique = false) {
            return self::addColumn($name, $default, $nullable, $unique);
        });
    }

    /**
     * Helper function to apply default value and unique constraint for text columns.
     *
     * @param string $name
     * @param mixed $default
     * @param bool $nullable
     * @param bool $unique
     * @return \Illuminate\Database\Schema\ColumnDefinition
     * @throws \InvalidArgumentException
    */
    private static function addColumn(string $name, mixed $default = null, bool $nullable = false, bool $unique = false)
    {
        if (!StringValidator::validate($default)) {
            throw new \InvalidArgumentException('Invalid default value: must be string or null.');
        }

        if (!SpecialValidator::validateUnique($unique)) {
            throw new \InvalidArgumentException('Invalid unique key reference to table ' . $unique);
        }

        $column = Blueprint::text($name);

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
    }
}
