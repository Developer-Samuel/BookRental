<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Schemas\CreateBooksTable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up(): void
    {
        $this->createBooksTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }

    /**
     * Create the 'books' table with all required columns.
     *
     * @return void
    */
    private function createBooksTable(): void
    {
        Schema::create('books', function (Blueprint $table) {
            CreateBooksTable::build($table);
        });
    }
};
