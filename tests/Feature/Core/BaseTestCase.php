<?php

declare(strict_types=1);

namespace Tests\Feature\Core;

use Tests\TestCase;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

use App\Models\User\User;
use App\Models\Country\Country;
use App\Models\Author\Author;

abstract class BaseTestCase extends TestCase
{
    use RefreshDatabase, WithoutMiddleware;

    protected function createUser(): User
    {
        return User::create([
            'username' => 'Admin',
            'email'    => 'admin@example.com',
            'password' => bcrypt('12345678'),
        ]);
    }

    protected function createCountry(): Country
    {
        return Country::create([
            'name'        => 'Slovakia',
            'code'        => 'SK',
            'nationality' => 'Slovak',
        ]);
    }

    protected function createAuthor(): Author
    {
        $country = $this->createCountry();

        return Author::create([
            'country_id' => $country->id,
            'name'       => 'John',
            'surname'    => 'Doe',
            'gender'     => 'male',
            'birth_date' => '1976-06-13',
        ]);
    }
}
