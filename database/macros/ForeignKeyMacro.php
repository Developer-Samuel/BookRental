<?php

declare(strict_types=1);

namespace Database\Macros;

use Illuminate\Database\Schema\Blueprint;

use Database\Validators\ForeignKeyValidator;

final class ForeignKeyMacro
{
    /**
     * Register the macro for adding a foreign key constraint to a column.
     *
     * @return \Illuminate\Database\Schema\Blueprint
    */
    public static function register(): void
    {
        Blueprint::macro('addForeignKey', function (
            string $column,
            string $on,
            string $onDelete = 'cascade'
        ) {
            if (!ForeignKeyValidator::validate($on)) {
                throw new \InvalidArgumentException('Invalid foreign key reference to table ' . $on);
            }

            Blueprint::foreignId($column)
                ->constrained($on)
                ->onDelete($onDelete);
        });
    }
}
