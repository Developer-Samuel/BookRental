<?php

declare(strict_types=1);

namespace Database\Validators;

use Illuminate\Support\Facades\Schema;

final class ForeignKeyValidator
{
    /**
     * Validate that the foreign key reference is valid for the given table.
     *
     * @param string $on
     * @return bool
    */
    public static function validate(string $on): bool
    {
        return Schema::hasTable($on);
    }
}
