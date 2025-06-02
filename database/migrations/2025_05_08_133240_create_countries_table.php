<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\Schemas\CreateCountriesTable;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
    */
    public function up(): void
    {
        $this->createCountriesTable();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
    */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }

    /**
     * Create the 'countries' table with all required columns.
     *
     * @return void
    */
    private function createCountriesTable(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            CreateCountriesTable::build($table);
        });
    }
};
