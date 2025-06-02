<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

use App\Seeders\AuthorBookSeeder;
use App\Seeders\Core\ForeignKeySeeder;
use App\Seeders\Core\TruncateSeeder;
use App\Seeders\CountrySeeder;
use App\Seeders\UserSeeder;

use App\Enums\ForeignKeyCheck;

class DatabaseSeeder extends Seeder
{
    /**
     * @param ForeignKeySeeder $foreignKeySeeder,
     * @param TruncateSeeder $truncateSeeder,
     * @param UserSeeder $userSeeder,
     * @param CountrySeeder $countrySeeder,
     * @param AuthorBookSeeder $authorBookSeeder
    */
    public function __construct(
        private readonly ForeignKeySeeder $foreignKeySeeder,
        private readonly TruncateSeeder $truncateSeeder,
        private readonly UserSeeder $userSeeder,
        private readonly CountrySeeder $countrySeeder,
        private readonly AuthorBookSeeder $authorBookSeeder
    ) {}

    /**
     * Seed the application's database.
     *
     * @return void
    */
    public function run(): void
    {
        try {
            $this->seed();
        } catch (\RuntimeException $e) {
            Log::critical('[Seeder] Runtime exception: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            $this->command->error('❌ Seeding failed due to a runtime error.');
        } catch (\Throwable $e) {
            Log::error('[Seeder] Unhandled exception: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            $this->command->error('❌ Seeding failed due to an unexpected error.');
        }
    }

    /**
     * Perform all seeding operations within a transaction.
     *
     * @return void
     * @throws \RuntimeException
    */
    private function seed(): void
    {
        try {
            $this->foreignKeySeeder->set(value: ForeignKeyCheck::DISABLE);

            $this->truncateSeeder->truncate();

            $this->seedUsers();
            $this->seedCountries();
            $this->seedAuthorsAndBooks();

            $this->foreignKeySeeder->set(ForeignKeyCheck::ENABLE);
        } catch (\Exception $e) {
            throw new \RuntimeException("Seeding failed: " . $e->getMessage());
        }
    }

    /**
     * Seed users with info message.
     *
     * @return void
    */
    private function seedUsers(): void
    {
        $this->userSeeder->seed();
        $this->command->info('✅ Users have been seeded successfully.');
    }

    /**
     * Seed countries and nationalities with info message.
     *
     * @return void
    */
    private function seedCountries(): void
    {
        $this->countrySeeder->seedFromApi();
        $this->command->info('✅ Countries have been seeded successfully.');
    }

    /**
     * Seed authors and books with info message.
     *
     * @return void
    */
    private function seedAuthorsAndBooks(): void
    {
        $this->authorBookSeeder->seedAuthorsAndBooks();
        $this->command->info('✅ Authors and their books have been seeded successfully.');
    }
}
