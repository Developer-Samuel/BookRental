<?php

declare(strict_types=1);

namespace Database\Schemas;

use Illuminate\Database\Schema\Blueprint;

use App\Enums\BookType;

/**
 * This class defines the schema structure for the 'books' table.
*/
final class CreateBooksTable
{
    /**
     * Build the entire schema definition for the 'books' table.
     *
     * @param Blueprint $table
     * @return void
    */
    public static function build(Blueprint $table): void
    {
        $table->addPrimaryKey();
        $table->addForeignKey('author_id', 'authors');
        $table->addString('title', 100, false, null);
        $table->addEnum('type', BookType::values(), 'art');
        $table->addBoolean('is_borrowed', false);
        $table->addTimestamps();
    }
}
