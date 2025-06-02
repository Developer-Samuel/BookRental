<?php

declare(strict_types=1);

namespace App\Enums;

enum BorrowStatus: int
{
    case AVAILABLE = 0;
    case BORROWED = 1;

    public function label(): string
    {
        return match($this) {
            self::AVAILABLE => 'Available',
            self::BORROWED  => 'Borrowed',
        };
    }

    public static function options(): array
    {
        return array_map(fn(self $case) => [
            'value' => $case->value,
            'name'  => $case->label(),
        ], self::cases());
    }
}
