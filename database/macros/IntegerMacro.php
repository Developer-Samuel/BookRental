<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\NumberValidator;

final class IntegerMacro
{
    /**
     * Register the macro for adding an number columns with an optional default value and unique constraint.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        $columnTypes = self::getColumnTypes();

        foreach ($columnTypes as $type => $method) {
            Blueprint::macro('add' . $type, function (string $name, $default = null, bool $unique = false) use ($method) {
                return self::addColumn(Blueprint::$method($name), $default, $unique);
            });
        }
    }

    /**
     * Get the list of column types and their corresponding methods.
     *
     * @return array
    */
    private static function getColumnTypes(): array
    {
        return [
            'Integer'            => 'integer',
            'BigInteger'         => 'bigInteger',
            'SmallInteger'       => 'smallInteger',
            'TinyInteger'        => 'tinyInteger',
            'UnsignedInteger'    => 'unsignedInteger',
            'UnsignedBigInteger' => 'unsignedBigInteger'
        ];
    }

    /**
     * Helper function to apply default value and unique constraint for number-based columns.
     *
     * @param mixed $column
     * @param mixed $default
     * @param bool $unique
     * @return \Illuminate\Database\Schema\Blueprint
     * @throws \InvalidArgumentException
    */
    private static function addColumn(mixed $column, mixed $default, bool $unique)
    {
        if (!NumberValidator::validateInteger($default)) {
            throw new \InvalidArgumentException('Invalid default value for the number column');
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
