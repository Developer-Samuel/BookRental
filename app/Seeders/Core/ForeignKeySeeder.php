<?php

declare(strict_types=1);

namespace App\Seeders\Core;

use Illuminate\Support\Facades\DB;

use Database\Validators\ForeignKeyCheckValidator;

use App\Enums\ForeignKeyCheck;

final class ForeignKeySeeder
{
    /**
     * Set foreign key checks (using enum).
     *
     * @param ForeignKeyCheck $value
     * @return void
     * @throws \RuntimeException
    */
    public function set(ForeignKeyCheck $value): void
    {
        if (!ForeignKeyCheckValidator::validate($value)) {
            throw new \RuntimeException(
                'Invalid value for FOREIGN_KEY_CHECKS. Must be one of: ' .
                implode(', ', ForeignKeyCheck::values())
            );
        }

        DB::statement("SET FOREIGN_KEY_CHECKS={$value->value}");
    }
}
