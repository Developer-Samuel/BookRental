<?php

declare(strict_types=1);

namespace App\Core\Helpers;

final class NameFormatter
{
    /**
     * @param string $fullName
     * @return array|null
    */
    public static function parseFullName(string $fullName): ?array
    {
        $nameParts = explode('-', $fullName);

        if (count($nameParts) !== 2) {
            return null;
        }

        return [
            'name'    => $nameParts[0],
            'surname' => $nameParts[1],
        ];
    }
}