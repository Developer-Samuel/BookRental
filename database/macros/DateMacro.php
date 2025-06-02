<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\DateValidator;

final class DateMacro
{
    /**
     * Register the macro for adding a date columns with optional nullability.
     *
     * @return void
    */
    public static function register(): void
    {
        $columnTypes = self::getColumnTypes();

        foreach ($columnTypes as $type => $method) {
            Blueprint::macro('add' . $type, function (string $name, bool $nullable = false) use ($type, $method) {
                $column = Blueprint::$method($name);

                if (!DateValidator::validate($nullable)) {
                    throw new \InvalidArgumentException("Invalid nullable setting for {$type} column {$name}");
                }

                if ($nullable) {
                    $column->nullable();
                }

                return $column;
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
            'Date'     => 'date',
            'DateTime' => 'dateTime',
        ];
    }
}
