<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Schemas\CreateAuthorsTable;

return new class extends Migration
{
    /**
     * Run the migrations.
    */
    public function up(): void
    {
        $this->createAuthorsTable();
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('authors');
    }

    /**
     * Create the 'authors' table with all required columns.
     *
     * @return void
    */
    private function createAuthorsTable(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            CreateAuthorsTable::build($table);
        });
    }
};
