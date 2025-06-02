<?php

declare(strict_types=1);

namespace Database\Validators;

final class StringValidator
{
    /**
     * Validate that the given value is a string or null.
     *
     * @param mixed $value
     * @return bool
    */
    public static function validate(mixed $value): bool
    {
        return is_null($value) || is_string($value);
    }
}
