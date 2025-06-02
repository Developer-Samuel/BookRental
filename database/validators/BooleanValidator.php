<?php

declare(strict_types=1);

namespace Database\Validators;

final class BooleanValidator
{
    /**
     * Validate the default value for boolean columns.
     *
     * @param mixed $default
     * @return bool
    */
    public static function validate(mixed $default): bool
    {
        return is_null($default) || is_bool($default);
    }
}
