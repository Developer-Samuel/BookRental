<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

     public static function labels(): array
    {
        return [
            self::MALE->value   => 'Male',
            self::FEMALE->value => 'Female',
        ];
    }
}
