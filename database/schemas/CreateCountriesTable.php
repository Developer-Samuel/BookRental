<?php

declare(strict_types=1);

namespace Database\Schemas;

use Illuminate\Database\Schema\Blueprint;

/**
 * This class defines the schema structure for the 'countries' table.
*/
final class CreateCountriesTable
{
    /**
     * Build the entire schema definition for the 'countries' table.
     *
     * @param Blueprint $table
     * @return void
    */
    public static function build(Blueprint $table): void
    {
        $table->addPrimaryKey();
        $table->addString('name', 100, false, null, true);
        $table->addString('code', 2, false, null, true);
        $table->addString('nationality', 100, false, null, false);
        $table->addTimestamps();
    }
}
