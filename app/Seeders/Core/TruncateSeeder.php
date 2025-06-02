<?php

declare(strict_types=1);

namespace App\Seeders\Core;

use App\Models\User\User;
use App\Models\Country\Country;
use App\Models\Author\Author;
use App\Models\Book\Book;

final class TruncateSeeder
{
    /**
     * Truncate specific tables to reset data.
     *
     * @return void
     * @throws \RuntimeException
    */
    public function truncate(): void
    {
        try {
            $this->truncateAllTables();
        } catch (\Exception $e) {
            throw new \RuntimeException("Error truncating tables: " . $e->getMessage());
        }
    }

    /**
     * Perform all truncations.
     *
     * @return void
    */
    private function truncateAllTables(): void
    {
        User::truncate();
        Country::truncate();
        Author::truncate();
        Book::truncate();
    }
}
