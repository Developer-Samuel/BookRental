<?php

declare(strict_types=1);

namespace Database\Validators;

final class SpecialValidator
{
    /**
     * Validate the uniqueness of the column.
     *
     * @param mixed $unique
     * @return bool
    */
    public static function validateUnique(mixed $unique): bool
    {
        return is_bool($unique);
    }
}
