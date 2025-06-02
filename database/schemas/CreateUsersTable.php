<?php

declare(strict_types=1);

namespace Database\Schemas;

use Illuminate\Database\Schema\Blueprint;

/**
 * This class defines the schema structure for the 'users' table.
*/
final class CreateUsersTable
{
    /**
     * Build the entire schema definition for the 'users' table.
     *
     * @param Blueprint $table
     * @return void
    */
    public static function build(Blueprint $table): void
    {
        $table->addPrimaryKey();
        $table->addString('username', 100, false, null, true);
        $table->addString('email', 100, false, null, true);
        $table->addCustomTimestamp('email_verified_at', true);
        $table->addString('password', 100);
        $table->addTimestamps();
    }
}
