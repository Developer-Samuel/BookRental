<?php

declare(strict_types=1);

namespace Database\Validators;

final class EnumValidator
{
    /**
     * Validate that the given default value is a valid enum value.
     *
     * @param array $values
     * @param string|null $default
     * @return bool
    */
    public static function validateEnum(array $values, ?string $default): bool
    {
        if ($default === null) {
            return true;
        }

        return in_array($default, $values, true);
    }
}
