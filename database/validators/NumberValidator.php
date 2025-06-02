<?php

declare(strict_types=1);

namespace Database\Validators;

final class NumberValidator
{
    /**
     * Validate the default value for integer columns.
     *
     * @param mixed $default
     * @return bool
    */
    public static function validateInteger(mixed $default): bool
    {
        return is_null($default) || is_int($default);
    }

    /**
     * Validate the default value for decimal columns.
     *
     * @param mixed $default
     * @return bool
    */
    public static function validateDecimal(mixed $default): bool
    {
        return is_null($default) || is_float($default);
    }
}
