<?php

declare(strict_types=1);

namespace App\Core\Helpers;

final class IdDataExtractor
{
    /**
     * @param array $validated
     * @return array
    */
    public static function extract(array $validated): array
    {
        $recordId = $validated['id'] ?? null;
        unset($validated['id']);
        return [$recordId, $validated];
    }
}
