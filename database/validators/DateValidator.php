<?php

declare(strict_types=1);

namespace Database\Validators;

final class DateValidator
{
    /**
     * Validate the nullable setting for date columns.
     *
     * @param mixed $nullable
     * @return bool
    */
    public static function validate(mixed $nullable): bool
    {
        return is_bool($nullable);
    }
}
