<?php

declare(strict_types=1);

namespace App\Seeders;

use Illuminate\Support\Facades\Hash;

use App\Models\User\User;

final class UserSeeder
{
    /**
     * Seed one default admin user into the database.
     *
     * @return void
     * @throws \RuntimeException
    */
    public function seed(): void
    {
        try {
            $this->createUsers();
        } catch (\Exception $e) {
            throw new \RuntimeException("Seeding failed: " . $e->getMessage());
        }
    }

    /**
     * Create the users and insert into database.
     *
     * @return void
    */
    private function createUsers(): void
    {
        $users = [
            [
                'username'          => 'admin',
                'email'             => 'admin@example.com',
                'email_verified_at' => now(),
                'password'          => Hash::make('12345678'),
                'created_at'        => now(),
                'updated_at'        => null,
            ],
        ];

        User::insert($users);
    }
}
