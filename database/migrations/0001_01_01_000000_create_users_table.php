<?php

declare(strict_types=1);

use Database\Schemas\CreateUsersTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
    */
    public function up(): void
    {
        $this->createUsersTable();
    }

    /**
     * Reverse the migrations.
    */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

    /**
     * Create the 'users' table with all required columns.
     *
     * @return void
    */
    private function createUsersTable(): void
    {
        Schema::create('users', function (Blueprint $table) {
            CreateUsersTable::build($table);
        });
    }
};
