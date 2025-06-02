<?php

declare(strict_types=1);

namespace App\Enums;

enum ForeignKeyCheck: int
{
    case DISABLE = 0;
    case ENABLE = 1;

    public static function values(): array
    {
        $values = [];
        foreach (self::cases() as $case) {
            $values[] = $case->value;
        }
        return $values;
    }
}
