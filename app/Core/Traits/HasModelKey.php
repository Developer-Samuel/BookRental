<?php

declare(strict_types=1);

namespace App\Core\Traits;

trait HasModelKey
{
    /**
     * @param object|null $modelInstance
     * @return string|null
    */
    private static function getModelKey(?object $modelInstance): ?string
    {
        if ($modelInstance === null) {
            return null;
        }
        return strtolower(class_basename($modelInstance));
    }
}