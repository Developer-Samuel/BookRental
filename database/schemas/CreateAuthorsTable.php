<?php

declare(strict_types=1);

namespace Database\Schemas;

use Illuminate\Database\Schema\Blueprint;

use App\Enums\Gender;

/**
 * This class defines the schema structure for the 'authors' table.
*/
final class CreateAuthorsTable
{
    /**
     * Build the entire schema definition for the 'authors' table.
     *
     * @param Blueprint $table
     * @return void
    */
    public static function build(Blueprint $table): void
    {
        $table->addPrimaryKey();
        $table->addForeignKey('country_id', 'countries');
        $table->addString('name', 100);
        $table->addString('surname', 100);
        $table->addEnum('gender', Gender::values(), 'male');
        $table->addDate('birth_date', true);
        $table->addTimestamps();
    }
}
