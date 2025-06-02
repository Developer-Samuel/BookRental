<?php

declare(strict_types=1);

namespace Database\Validators;

use App\Enums\ForeignKeyCheck;

final class ForeignKeyCheckValidator
{
    /**
     * Validate the value for FOREIGN_KEY_CHECKS.
     *
     * @param ForeignKeyCheck $value
     * @return bool
    */
    public static function validate(ForeignKeyCheck $value): bool
    {
        $validValues = ForeignKeyCheck::values();

        return in_array($value->value, $validValues);
    }
}
